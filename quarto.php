
 <!-- CADASTRAR NOVO QUARTO -->
<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/model/quarto.php';

$quarto = new Quarto();
$quartoData = null;
$isEdit = false;

if (isset($_GET['id'])) {
    $isEdit = true;
    $quartoData = $quarto->buscarPorId($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cadastrar Novo Quarto</title>
</head>

<body>
    <?php include 'view/header.php'; ?>
    <div class="container_mt-5">
        <h2><?= $isEdit ? 'Editar Quarto' : 'Cadastrar Novo Quarto' ?></h2>
        <div class="card">
            <div class="card-body">
                <form action="controller/processar_quartos.php" method="POST">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $quartoData['id'] ?>">
                        <input type="hidden" name="action" value="update">
                    <?php else: ?>
                        <input type="hidden" name="action" value="create">
                    <?php endif; ?>



                    <div class="mb-3">
                        <label for="numero" class="form-label">Número do Quarto *</label>
                        <input type="number" class="form-control" id="numero" name="numero"
                            value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo *</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="Standard">Standard</option>
                            <option value="Luxo">Luxo</option>
                            <option value="Suíte">Suíte</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço por Noite *</label>
                        <input type="number" step="0.01" class="form-control" id="preco" name="preco"
                            value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1"
                                checked>
                            <label class="form-check-label" for="ativo">
                                Quarto Ativo
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Salvar Alterações' : 'Cadastrar' ?></button>
                    <a href="quartos-gerenciar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include 'view/footer.php';
?>