document.getElementById("reserva-form").addEventListener("submit", function(e) {
  e.preventDefault();

  const quartoSelect = document.querySelector(".reserva-quarto");
  const quarto = quartoSelect.value; // 
  const quartoNome = quartoSelect.options[quartoSelect.selectedIndex]?.text || quarto;
  const dataEntrada = document.getElementById("reserva-entrada").value;
  const dataSaida = document.getElementById("reserva-saida").value;
  const adultos = document.querySelector(".reserva-adulto").value;
  const criancas = document.querySelector(".reserva-crianca").value;

  // 2. Validações básicas (campos preenchidos)
  if (!quarto || !dataEntrada || !dataSaida || !adultos || !criancas) {
    alert("Preencha todos os campos da reserva!");
    return;
  }
  
  // 3. Validação de Datas
  if (!validarDatas(dataEntrada, dataSaida)) {
      return; 
  }

  abrirModalReserva(quarto, quartoNome, dataEntrada, dataSaida, adultos, criancas);
});


function abrirModalReserva(quarto, quartoNome, entrada, saida, adultos, criancas) {
  const modal = document.createElement("div");
  modal.classList.add('modal-overlay');
  modal.innerHTML = `
    <div class="custom-modal">
      <button id="fechar-modal" class="modal-close-btn">&times;</button>
      <h3>Confirmar Reserva</h3>
      <div class="resumo-reserva">
        <p><strong>Quarto:</strong> ${quartoNome}</p>
        <p><strong>Entrada:</strong> ${entrada}</p>
        <p><strong>Saída:</strong> ${saida}</p>
        <p><strong>Adultos:</strong> ${adultos}</p>
        <p><strong>Crianças:</strong> ${criancas}</p>
      </div>

      <h4>Seus Dados</h4>
      <input type="text" id="nome" placeholder="Nome Completo" required>
      <input type="text" id="email" placeholder="E-mail" required>
      <input type="text" id="cpf" placeholder="CPF" maxlength="14" required>
      <input type="text" id="telefone" placeholder="Telefone" maxlength="15" required>

      <button id="confirmar">Confirmar Reserva</button>
    </div>
  `;
  document.body.appendChild(modal);


  // ===============================
  // LÓGICA DO MODAL
  // ===============================

  const inputCPF = document.getElementById("cpf");
  const inputTelefone = document.getElementById("telefone");

  // Adiciona as Máscaras ao digitar
  inputCPF.addEventListener('input', (e) => {
    e.target.value = mascaraCPF(e.target.value);
  });
  inputTelefone.addEventListener('input', (e) => {
    e.target.value = mascaraTelefone(e.target.value);
  });

  // Fecha o modal ao clicar no botão fechar ou na overlay
  document.getElementById("fechar-modal").addEventListener("click", () => {
    modal.remove();
  });
  modal.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        modal.remove();
    }
  });


  // Evento de Confirmação Final
  document.getElementById("confirmar").addEventListener("click", () => {
    const nome = document.getElementById("nome").value.trim();
    const email = document.getElementById("email").value.trim();
    const cpf = inputCPF.value.trim();
    const telefone = inputTelefone.value.trim();

    // 5. Validação dos campos do Cliente (dentro do modal)
    if (!nome || !email || !cpf || !telefone) {
        alert("Todos os campos de contato (Nome, E-mail, CPF, Telefone) são obrigatórios.");
        return;
    }
    
    if (!validarEmail(email)) {
        alert("Por favor, insira um endereço de E-mail válido.");
        return;
    }

  // Validação básica do CPF: deve conter 11 dígitos numéricos
  const cpfDigits = cpf.replace(/\D/g, '');
  if (cpfDigits.length !== 11) {
    alert('CPF inválido: digite os 11 dígitos do CPF.');
    return;
  }

  // Validar telefone usando função centralizada
  if (!validarTelefone(telefone)) {
    alert('Telefone inválido: informe um número com DDD (11 a 12 dígitos).');
    return;
  }

    // 6. Envia os dados completos
    fetch("model/salvar-reserva.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
          quarto, entrada, saida, adultos, criancas,
          nome, email, cpf, telefone
      })
    })
    .then(res => res.json().catch(() => ({ success: false, message: 'Resposta inválida do servidor.' })))
    .then(data => {
      if (data && data.success) {
        alert(data.message || 'Reserva salva com sucesso!');
      } else {
        alert(data.message || 'Erro ao salvar a reserva.');
      }
      modal.remove();
    })
    .catch(error => {
        alert("Erro ao tentar salvar a reserva. Tente novamente.");
        console.error('Fetch Error:', error);
        modal.remove();
    });
  });
}