<!-- Página de Sucesso -->
<?php include 'view/header.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="assets/css/sucesso.css" />
   <title>Sucesso</title>
</head>
<body>
   <div class="main-content">
   <div class="sucesso-container">
      <h2>Quarto cadastrado com sucesso! </h2>
      <br>
      <div class="buttons-container">
         <button onclick="window.location.href='quartos.php';" class="ver-quartos">Ver Quartos</button>
         <button onclick="window.location.href='quarto.php';" class="cadastrar-novo">Cadastrar Novo</button>
      </div>
   </div>
</div>
</body>
</html>
<?php include 'view/footer.php'; ?>