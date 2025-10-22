
document.addEventListener('DOMContentLoaded', function () {
    const editModalElement = document.getElementById('editModal');
    const editModal = new bootstrap.Modal(editModalElement);

    
    editModalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const numero = button.getAttribute('data-numero') || '';
        const tipo = button.getAttribute('data-tipo') || '';
        const preco = button.getAttribute('data-preco') || '';
        const ativo = button.getAttribute('data-ativo');

        const form = document.getElementById('editForm');
        form.reset();

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-numero').value = numero;
        document.getElementById('edit-tipo').value = tipo;
    
        document.getElementById('edit-preco').value = preco;

        if (typeof ativo !== 'undefined' && ativo !== null) {
            document.getElementById('edit-ativo').value = ativo;
        }
    });


    const saveButton = document.getElementById('saveChangesBtn');
    saveButton.addEventListener('click', function () {
        const form = document.getElementById('editForm');
        form.submit();
        
    });
});

