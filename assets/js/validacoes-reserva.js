// ===============================
// FUNÇÕES DE UTILIDADE E VALIDAÇÃO
// ===============================


function mascaraCPF(valor) {
    valor = valor.replace(/\D/g, ""); 
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return valor;
}


function mascaraTelefone(valor) {
    valor = valor.replace(/\D/g, ""); 

    valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");
    if (valor.length <= 13) {

        valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
    } else {
   
        valor = valor.replace(/(\d)(\d{5})$/, "$1-$2");
    }
    return valor;
}


function validarTelefone(telefone) {
    if (!telefone) return false;
    const digits = telefone.replace(/\D/g, '');
    return digits.length >= 11 && digits.length <= 12;
}


function validarEmail(email) {

    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}


function validarDatas(entrada, saida) {
    const dataEntrada = new Date(entrada);
    const dataSaida = new Date(saida);
    const hoje = new Date();

    hoje.setHours(0, 0, 0, 0);

    if (dataEntrada < hoje) {
        alert("A data de entrada não pode ser no passado.");
        return false;
    }

    if (dataSaida <= dataEntrada) {
        alert("A data de saída deve ser posterior à data de entrada.");
        return false;
    }
    return true;
}

// ===============================
// Validação de disponibilidade por quarto (consulta ao servidor)
// ===============================
// Observações / suposições:
// - Este código faz uma requisição POST para `controller/processar_reservas.php`
//   com JSON { action: 'verificar_disponibilidade', quarto, entrada, saida }.
// - O endpoint deverá retornar JSON { available: boolean, conflicts: [...] }.
// - Se o endpoint não existir ou falhar, a validação será permissiva (não bloqueia)
//   para evitar interromper a experiência do usuário. Recomenda-se implementar
//   o endpoint no servidor para comportamento completo.

async function verificarDisponibilidadeNoServidor(quarto, entrada, saida) {
    if (!quarto) return true; // sem quarto selecionado, não bloqueia aqui
    try {
        // usar caminho relativo para funcionar tanto em /projetohotel/ quanto em subpastas
        const resp = await fetch('controller/processar_reservas.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'verificar_disponibilidade', quarto, entrada, saida })
        });

        if (!resp.ok) {
            // se o servidor retornou erro, não bloquear — log para debug
            console.warn('Verificação de disponibilidade retornou erro:', resp.status);
            return true;
        }

        const data = await resp.json();
        // espera { available: boolean }
        if (typeof data.available === 'boolean') {
            return data.available;
        }
        // formato inesperado: não bloquear
        console.warn('Formato inesperado na verificação de disponibilidade:', data);
        return true;
    } catch (err) {
        console.error('Erro ao verificar disponibilidade no servidor:', err);
        // Em caso de erro de rede, não bloqueamos a submissão aqui.
        return true;
    }
}

// Função que valida datas (local) e depois checa disponibilidade no servidor.
// Retorna Promise<boolean>. Uso: if (await validarDatasComDisponibilidade(entrada, saida, quarto)) { ... }
async function validarDatasComDisponibilidade(entrada, saida, quarto) {
    if (!validarDatas(entrada, saida)) return false;
    const disponivel = await verificarDisponibilidadeNoServidor(quarto, entrada, saida);
    if (!disponivel) {
        alert('O quarto selecionado já possui reserva nas datas escolhidas. Por favor escolha outras datas ou outro quarto.');
        return false;
    }
    return true;
}

// Exportar funções para uso em outras scripts (caso o projeto use módulos, senão ficam globais)
// Em páginas que fazem submit de reserva, chame `await validarDatasComDisponibilidade(checkin, checkout, quarto)`
