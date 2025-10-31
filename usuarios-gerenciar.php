<?php
require_once 'model/usuario.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: admin-login.php');
    exit;
}

$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gerenciar Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/correcao-modal.css">
</head>
<body>
  <?php include 'view/header.php'; ?>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Usuários</h2>
      <a href="usuario-form.php" class="btn btn-success">Novo Usuário</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">Operação realizada com sucesso.</div>
    <?php endif; ?>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Data Cadastro</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['data_cadastro']) ?></td>
            <td>
              <a href="usuario-form.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controller/processar_usuarios.php?action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php include 'view/footer.php'; ?>
</body>
</html>
