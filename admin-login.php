<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: area-adm.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Administrativo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/footer.css" rel="stylesheet">
</head>
<body>
  <?php include 'view/header.php'; ?>

  <div class="container mt-5" style="padding-top:100px;">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Login Administrativo</div>
          <div class="card-body">
            <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger">E-mail ou senha inválidos.</div>
            <?php endif; ?>
            <form method="post" action="controller/auth.php">
              <input type="hidden" name="action" value="login" />
              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input id="email" name="email" type="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input id="senha" name="senha" type="password" class="form-control" required />
              </div>
              <button class="btn btn-primary" type="submit">Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'view/footer.php'; ?>
</body>
</html>
