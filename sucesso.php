<!-- Página de sucesso -->
<?php
$action = $_GET['action'] ?? 'indefinida';
$mensagens = [
    'create' => 'Quarto cadastrado com sucesso!',
    'update' => 'Quarto atualizado com sucesso!',
    'delete' => 'Quarto excluído com sucesso!',
    'indefinida' => 'Operação realizada com sucesso!'
];

$mensagem = $mensagens[$action] ?? $mensagens['indefinida'];
?> 
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
      <h2><?php echo htmlspecialchars($mensagem); ?></h2>
      <br>
      <div class="buttons-container">
         <button onclick="window.location.href='quartos-gerenciar.php';"  class="ver-quartos">Ver Quartos</button>
         <button onclick="window.location.href='quarto.php';" class="cadastrar-novo">Cadastrar Novo</button>
      </div>
   </div>
</div>
</body>
</html>
<?php include 'view/footer.php'; ?>