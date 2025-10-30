<?php
require_once 'model/usuario.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: admin-login.php');
    exit;
}

$usuarioModel = new Usuario();
$usuario = null;
if (isset($_GET['id'])) {
    $usuario = $usuarioModel->findById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $usuario ? 'Editar' : 'Novo' ?> Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'view/header.php'; ?>

  <div class="container mt-5">
    <h2><?= $usuario ? 'Editar' : 'Novo' ?> Usuário</h2>
    <form method="post" action="controller/processar_usuarios.php">
      <input type="hidden" name="action" value="<?= $usuario ? 'update' : 'create' ?>">
      <?php if ($usuario): ?>
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input name="nome" class="form-control" required value="<?= $usuario ? htmlspecialchars($usuario['nome']) : '' ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input name="email" type="email" class="form-control" required value="<?= $usuario ? htmlspecialchars($usuario['email']) : '' ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Senha <?= $usuario ? '(preencha para alterar)' : '' ?></label>
        <input name="senha" type="password" class="form-control" <?= $usuario ? '' : 'required' ?>>
      </div>

      <button class="btn btn-primary" type="submit">Salvar</button>
      <a class="btn btn-secondary" href="usuarios-gerenciar.php">Cancelar</a>
    </form>
  </div>

  <?php include 'view/footer.php'; ?>
</body>
</html>
