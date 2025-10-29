document.addEventListener('DOMContentLoaded', function () {
    const editReservaElement = document.getElementById('editReserva');
    const editReserva = new bootstrap.Modal(editReservaElement);

    
    editReservaElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const quarto = button.getAttribute('data-quarto') || '';
        const nome = button.getAttribute('data-nome') || '';
        const adultos = button.getAttribute('data-adultos') || 0;
        const criancas = button.getAttribute('data-criancas') || 0;
        const status = button.getAttribute('data-status') || 'confirmada';
        const telefone = button.getAttribute('data-telefone') || '';
        const cpf = button.getAttribute('data-cpf') || '';
        const email = button.getAttribute('data-email') || '';
        const checkin = button.getAttribute('data-checkin') || '';
        const checkout = button.getAttribute('data-checkout') || '';
        const form = document.getElementById('editForm');
        form.reset();

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-quarto').value = quarto;
        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-adultos').value = adultos;
        document.getElementById('edit-criancas').value = criancas;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-cpf').value = cpf;
        document.getElementById('edit-telefone').value = telefone;
        document.getElementById('edit-checkin').value = checkin;
        document.getElementById('edit-checkout').value = checkout;
        document.getElementById('edit-status').value = status;
    });


    const saveButton = document.getElementById('saveChangesBtn');
    // Aplica máscaras e validações antes de submeter
    // utiliza funções de validacoes-reserva.js (mascaraCPF, mascaraTelefone, validarEmail)
    const inputCpf = document.getElementById('edit-cpf');
    const inputTel = document.getElementById('edit-telefone');
    if (inputCpf) {
        inputCpf.addEventListener('input', (e) => {
            e.target.value = mascaraCPF(e.target.value);
        });
    }
    if (inputTel) {
        inputTel.addEventListener('input', (e) => {
            e.target.value = mascaraTelefone(e.target.value);
        });
    }

    saveButton.addEventListener('click', function () {
        const form = document.getElementById('editForm');
        const nome = document.getElementById('edit-nome').value.trim();
        const email = document.getElementById('edit-email').value.trim();
        const cpf = document.getElementById('edit-cpf').value.trim();
        const telefone = document.getElementById('edit-telefone').value.trim();

        if (!nome) {
            alert('Informe o nome do cliente.');
            return;
        }

        if (email && !validarEmail(email)) {
            alert('E-mail inválido.');
            return;
        }

        const cpfDigits = cpf.replace(/\D/g, '');
        if (!cpfDigits || cpfDigits.length !== 11) {
            alert('CPF inválido: informe 11 dígitos.');
            return;
        }

        const telDigits = telefone.replace(/\D/g, '');
        if (!telDigits || (telDigits.length < 10 || telDigits.length > 12)) {
            alert('Telefone inválido: informe um número com DDD (10-12 dígitos).');
            return;
        }
        form.submit();
    });
});

