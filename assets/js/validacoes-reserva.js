// ===============================
// FUNÇÕES DE UTILIDADE E VALIDAÇÃO
// ===============================

// Adiciona máscara de CPF (000.000.000-00)
function mascaraCPF(valor) {
    valor = valor.replace(/\D/g, ""); // Remove tudo que não for dígito
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
    valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return valor;
}

// Adiciona máscara de Telefone ((00) 00000-0000 ou (00) 0000-0000)
function mascaraTelefone(valor) {
    valor = valor.replace(/\D/g, ""); // Remove tudo que não for dígito
    // Formata conforme quantidade de dígitos:
    // até 10 dígitos: (00) 0000-0000
    // 11 dígitos: (00) 00000-0000
    // 12 dígitos: (00) 00000-00000) — aceita mas menos comum
    valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");
    if (valor.length <= 13) {
        // formato (00) 0000-0000 ou (00) 00000-0000
        valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
    } else {
        // para 12 dígitos formata 5-5
        valor = valor.replace(/(\d)(\d{5})$/, "$1-$2");
    }
    return valor;
}

// Validação de Telefone: exige entre 11 e 12 dígitos (DDD + número)
function validarTelefone(telefone) {
    if (!telefone) return false;
    const digits = telefone.replace(/\D/g, '');
    return digits.length >= 11 && digits.length <= 12;
}

// Validação de E-mail
function validarEmail(email) {
    // Regex simples mas eficaz para a maioria dos emails
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

// Validação de Data (Garante que a entrada seja antes da saída)
function validarDatas(entrada, saida) {
    const dataEntrada = new Date(entrada);
    const dataSaida = new Date(saida);
    const hoje = new Date();
    // Zera horas para comparação
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