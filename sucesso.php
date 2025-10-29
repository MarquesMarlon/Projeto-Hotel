<!-- Página de sucesso -->
<?php
$action = $_GET['action'] ?? 'indefinida';
$type = $_GET['type'] ?? 'quarto';

// mensagens padrão para quartos
$mensagens_quarto = [
    'create' => 'Quarto cadastrado com sucesso!',
    'update' => 'Quarto atualizado com sucesso!',
    'delete' => 'Quarto excluído com sucesso!',
    'indefinida' => 'Operação realizada com sucesso!'
];

// mensagens para reservas
$mensagens_reserva = [
    'create' => 'Reserva cadastrada com sucesso!',
    'update' => 'Reserva atualizada com sucesso!',
    'delete' => 'Reserva excluída com sucesso!',
    'indefinida' => 'Operação realizada com sucesso!'
];

if ($type === 'reserva') {
    $mensagem = $mensagens_reserva[$action] ?? $mensagens_reserva['indefinida'];
} else {
    $mensagem = $mensagens_quarto[$action] ?? $mensagens_quarto['indefinida'];
}
?>
<?php include 'view/header.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="assets/css/sucesso.css" />
   <title>Sucesso</title>
   <style>
      /* pequenos ajustes inline para garantir visual mínimo caso CSS não carregue */
      .sucesso-container{ text-align:center; padding:2rem; }
      .buttons-container{ display:flex; gap:1rem; justify-content:center; margin-top:1rem; }
      .ver-reservas, .cadastrar-novo-reserva, .ver-quartos, .cadastrar-novo{ padding:0.6rem 1rem; border-radius:6px; border:none; cursor:pointer; }
      .ver-reservas, .ver-quartos{ background:#6c757d; color:#fff }
      .cadastrar-novo-reserva, .cadastrar-novo{ background:#0d6efd; color:#fff }
   </style>
</head>
<body>
   <div class="main-content">
   <div class="sucesso-container">
      <h2><?php echo htmlspecialchars($mensagem); ?></h2>
      <br>
      <div class="buttons-container">
         <?php if ($type === 'reserva') : ?>
            <button onclick="window.location.href='reservas-gerenciar.php';"  class="ver-reservas">Ver Reservas</button>
            <button onclick="window.location.href='reserva.php';" class="cadastrar-novo-reserva">Cadastrar Nova Reserva</button>
         <?php else: ?>
            <button onclick="window.location.href='quartos-gerenciar.php';"  class="ver-quartos">Ver Quartos</button>
            <button onclick="window.location.href='quarto.php';" class="cadastrar-novo">Cadastrar Novo</button>
         <?php endif; ?>
      </div>
   </div>
</div>
</body>
</html>
<?php include 'view/footer.php'; ?>