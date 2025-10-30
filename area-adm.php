<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área Administrativa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
  <?php include 'view/header.php'; ?>
  <div class="container mt-5">
    <div class="text-center mb-5">
      <h2><i>Área Administrativa</i></h2>
    </div>

    <!-- Linha com 3 colunas -->
    <div class="row text-center">

      <!-- COLUNA 1 - Quartos -->
      <div class="col-md-4 mb-4">
        <h3>Quartos</h3>
        <a href="quarto.php" class="btn btn-primary w-75 my-2">Cadastrar Novo Quarto</a>
        <a href="quartos-gerenciar.php" class="btn btn-primary w-75 my-2">Gerenciar Quartos</a>
      </div>

      <!-- COLUNA 2 - Reservas -->
      <div class="col-md-4 mb-4">
        <h3>Reservas</h3>
        <a href="reserva.php" class="btn btn-primary w-75 my-2">Cadastrar Nova Reserva</a>
        <a href="reservas-gerenciar.php" class="btn btn-primary w-75 my-2">Gerenciar Reservas</a>
      </div>

      <!-- COLUNA 3 - Usuários -->
      <div class="col-md-4 mb-4">
        <h3>Usuários</h3>
        <a href="usuarios-gerenciar.php" class="btn btn-primary w-75 my-2">Gerenciar Usuários</a>
        <a href="index.php" class="btn btn-danger w-75 my-2">Sair</a>
      </div>

    </div>
  </div>

  <?php include 'view/footer.php'; ?>
</body>

</html>
