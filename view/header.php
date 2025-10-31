<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title></title>
  <link rel="stylesheet" href="assets/css/header.css"/>
  <link rel="stylesheet" href="assets/css/footer.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />

  <?php if (isset($page_css) && $page_css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($page_css) ?>" />
  <?php endif; ?>

  <?php if (isset($page_footer_css) && $page_footer_css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($page_footer_css) ?>" />
  <?php endif; ?>

</head>
<!-- NAVBAR-->

<body>
  <header>
  <div class="navbar">
      <div class="container-navbar">
        <img src="assets/img/sharai_logo.png" alt="sharai" class="logo-navbar" />
        <style>
            .navbar {
                background-color: black;
            }
        </style>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="sobre.php">Sobre</a></li>
          <li><a href="contato.php">Contato</a></li>
          <li><a href="area-adm.php">Área Administrativa</a></li>
        </ul>
      </div>
  </div>
</header>
<div class="page-content">