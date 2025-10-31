<?php
define('ROOT_PATH', __DIR__);
// opcional: carregar CSS específico para a página de contato
$page_css = 'assets/css/sobre-page.css';
$page_footer_css = 'assets/css/footer-sobre.css';
require_once ROOT_PATH . '/view/header.php';
?>

  <main class="sobre-page contato-page">
    <h1>Fale Conosco</h1>

    <div class="contato-content">
      <p>Se preferir, entre em contato pelos meios abaixo:</p>
      <ul>
        <li><strong>Telefone:</strong> 45 99842-4684</li>
        <li><strong>Email:</strong> jafe.marlon@essentia.com.br</li>
        <li><strong>Horário comercial:</strong> Seg–Sex, 09:00–18:00</li>
      </ul>

      <p>Se quiser voltar à página inicial:</p>
      <p><a class="btn-home" href="index.php">Voltar à Home</a></p>
    </div>
  </main>

  <?php include 'view/footer.php'; ?>

</body>
</html>
