<?php
define('ROOT_PATH', __DIR__);
// pedir ao header que inclua o CSS específico desta página (CSS exclusivo, novo)
$page_css = 'assets/css/sobre-page.css';
$page_footer_css = 'assets/css/footer-sobre.css';
require_once ROOT_PATH . '/view/header.php';
?>

  <main class="sobre-page">
    <h1>Sobre Sharai Luxury Hotel</h1>
    <p>Bem-vindo ao Sharai Luxury Hotel. Somos comprometidos em oferecer uma experiência única de conforto e sofisticação. Nossa equipe está à disposição para tornar sua estadia memorável, com serviços personalizados, gastronomia requintada e instalações de primeira classe.</p>
    <p>Visite nossas acomodações, aproveite o spa e as áreas de lazer, e entre em contato conosco caso precise de assistência. Agradecemos a preferência e esperamos recebê-lo em breve.</p>
    <p><a class="btn-home" href="index.php">Voltar à Home</a></p>
  </main>
  <?php include 'view/footer.php'; ?>

</body>
</html>
