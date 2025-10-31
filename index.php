<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/model/reserva.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Projeto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/header.css" />
   <link rel="stylesheet" href="assets/css/modal-reserva.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  
</head>
<!-- NAVBAR-->

<body>
  <header>
    <div class="navbar">
      <div class="container-navbar">
        <img src="assets/img/logo-header.png" alt="sharai" class="logo-navbar" />
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="sobre.php">Sobre</a></li>
          <li><a href="contato.php">Contato</a></li>
          <li><a href="admin-login.php">Login</a></li>
          <li><a href="area-adm.php">Área Administrativa</a></li>
        </ul>
      </div>
    </div>
    <div class="banner"></div>
  </header>
  <!-- RESERVA  -->
  <form id="reserva-form" action="" method="POST">
    <div class="container-reserva">
      <h3 class="reserva-text">Reserva</h3>
      <div class="reserva-list">
        <div class="list-item">

          <label for="dataEntrada"><b>Entrada/Saida</b> </label>
          <div class="input-grupo">
            <span class="seta">➜</span>
            <input type="text" id="reserva-entrada" class="date-field" placeholder="Entrada" required>


            <span class="seta">➜</span>
            <input type="text" id="reserva-saida" class="date-field" placeholder="Saida" required>
          </div>
        </div>
      </div>
      <div class="list-item">
        <label for="quarto"><b>Quarto</b></label>
        <select name="reserva-quarto" class="reserva-quarto" required>
          <option value="">Selecione o quarto</option>
          <?php
          require_once __DIR__ . '/config/conexaobd.php';
          $conexao = new Conexao();
          $con = $conexao->getPdo();
          $stmt = $con->prepare("SELECT id, nome FROM quartos WHERE ativo = 1 ORDER BY nome ASC");
          $stmt->execute();
          $quartos = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($quartos as $q) {
            echo "<option value='{$q['id']}'>{$q['nome']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="list-item">
        <label for=""><b>Adulto</b></label>
        <select name="reserva-adulto" id="" class="reserva-adulto" required>
          <option value="">Selecione</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>

      <div class="list-item">
        <label for="crianca"><b>Criança</b></label>
        <select name="reserva-crianca" id="" class="reserva-crianca" required>
          <option value="">Selecione</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>

      <button type="submit" id="list-botom">RESERVAR</button>
  </form>
  </div>

  <div class="container-central">
    <div class="container-central-sobre">
      <h1 class="text-sobre1-transparente">Sobre</h1>
      <h2 class="text-sobre2-negrito">Sobre</h2>
      <div class="line-cetral"></div>
      <h3 class="text-info-central">
        We will be so proud to be our guest.Lorem Ipsum is simply dummy text
        of the printing.
      </h3>
      <p class="text-msg-central">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the typesetting industry's standard
        dummy text ever since the when.Lorem Ipsum is simply dummy text of
        the printing and typesetting industry.
      </p>
      <div class="cards-menus">
        <div class="card-menu">
          <div class="card-icon">
            <img src="assets/img/Restauranteicon.png" alt="restaurante" class="icon-food" />
          </div>
          <div class="card-info">
            <h4>Restaurante</h4>
            <p>Lorem ipsum dolor sit piscing sed nonmy</p>
          </div>
        </div>

        <div class="card-menu">
          <div class="card-icon">
            <img src="assets/img/spaicon.png" alt="spa" class="icon-spa" />
          </div>
          <div class="card-info">
            <h4>Wellness & Spa</h4>
            <p>Lorem ipsum dolor sit piscing sed nonmy</p>
          </div>
        </div>

        <div class="card-menu">
          <div class="card-icon">
            <img src="assets/img/wifiicon.png" alt="wifi" class="icon-wifi" />
          </div>
          <div class="card-info">
            <h4>Free Wifi</h4>
            <p>Lorem ipsum dolor sit piscing sed nonmy</p>
          </div>
        </div>

        <div class="card-menu">
          <div class="card-icon">
            <img src="assets/img/jogosicon.png" alt="jogos" class="icon-jogos" />
          </div>
          <div class="card-info">
            <h4>Espaço de jogos</h4>
            <p>Lorem ipsum dolor sit piscing sed nonmy</p>
          </div>
        </div>
      </div>

    <a class="more-info-button" href="#reserva-form">SAIBA MAIS
      <div class="info-traco"></div>
    </a>
    </div>

    <div class="cocontainer-central image">
      <img src="assets/img/sobrefoto.png" alt="Imagem do Quarto" class="imagem-quarto" />
    </div>
  </div>

  <div class="container-acomodacao">
    <div class="home-acomodacao">
      <h1 class="text-acomodacao-g">ACOMODAÇÕES</h1>
      <h3 class="text-acomodacao-p">Acomodações</h3>
      <div class="barra-acomodacao"></div>
    </div>

    <div class="menu-home-acomodacao">
      <ul class="links">
        <li id="todos"><a href="#">TODOS</a></li> <!-- id e cor temporária -->
        <li><a href="#">CASAL</a></li>
        <li><a href="#">SOLTEIRO</a></li>
        <li><a href="#">SUÍTE</a></li>
      </ul>
    </div>



    <div class="acomodacoes-cards">
      <div class="acomodacao-card">
        <div class="acomodacao-img">
          <img src="assets/img/acomodacoes/casal01.png" alt="Casal 01" class="acomodacao-img">
        </div>
        <div class="acomodacao-info">
          <img src="assets/img/acomodacoes/Border.png" alt="border" class="acomodacao-border">
          <div class="container-info">
            <div>
              <span class="acomodacao-preco">R$ 299,00/NOITE</span>
            </div>
            <div class="acomodacao-detalhes">
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-seta.png" alt="icon-info"> tamanho 30m² </span>
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-sticker.svg" alt="icon-info"> Adultos: 3 </span>
            </div>
            <a class="acomodacao-btn" href="#reserva-form">SAIBA MAIS</a>
          </div>
        </div>
      </div>
      <div class="acomodacao-card">
        <div class="acomodacao-img">
          <img src="assets/img/acomodacoes/solteiro01.png" alt="Solteiro 01" class="acomodacao-img">
        </div>
        <div class="acomodacao-info">
          <img src="assets/img/acomodacoes/Border.png" alt="border" class="acomodacao-border">
          <div class="container-info">
            <div>
              <span class="acomodacao-preco">R$ 199,00/NOITE</span>
            </div>
            <div class="acomodacao-detalhes">
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-seta.png"> tamanho 30m² </span>
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-sticker.svg"> Adultos: 3 </span>
            </div>
            <a class="acomodacao-btn" href="#reserva-form">SAIBA MAIS</a>
          </div>
        </div>
      </div>
      <div class="acomodacao-card">
        <div class="acomodacao-img">
          <img src="assets/img/acomodacoes/casal02.png" alt="Casal 02" class="acomodacao-img">
        </div>
        <div class="acomodacao-info">
          <img src="assets/img/acomodacoes/Border.png" alt="borer" class="acomodacao-border">
          <div class="container-info">
            <div>
              <span class="acomodacao-preco">R$ 299,00/NOITE</span>
            </div>
            <div class="acomodacao-detalhes">
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-seta.png" alt="icon-info"> tamanho 30m² </span>
              <span class="icon-info"> <img src="assets/img/acomodacoes/icon-sticker.svg" alt="icon-info"> Adultos: 3 </span>
            </div>
            <a class="acomodacao-btn" href="#reserva-form">SAIBA MAIS</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- footer  -->
  <footer>
    <div class="container-footer">

      <!-- Newsletter -->
      <div class="newsletter-section">
        <div class="newsletter">
          <h4>NEWSLETTER</h4>
          <p>Never Miss Anything From Construx By Signing Up To Our Newsletter.</p>
        </div>
        <!-- linha vertical -->
        <div class="linha-vertical"></div>
        <!-- input e-mail -->
        <div class="newsletter-input">
          <div id="error-message" aria-live="polite"></div> <!-- mensagem de erro -->
          <form id="email-newsletter">
            <input id="email-input" type="email" placeholder="Digite seu email">
            <button>ENVIAR</button>
          </form>
        </div>
      </div>

      <!-- Linha divisória -->
      <div class="footer-line"></div>

      <!-- Colunas -->
      <div class="footer-columns">

        <!-- Logo e descrição -->
        <div class="footer-logo">
          <div class="logo-img">
            <img src="assets/img/footer/logo-sharan.png" alt="Logo Sharan">
          </div>
          <div class="logo-text">
            <p>Today we can tell you, thanks to your passion, hard work creativity, and expertise, you delivered us the
              most beautiful house great looks.</p>
          </div>
          <div class="social-icons">
            <img src="assets/img/footer/facebook-icon.svg" alt="Facebook">
            <img src="assets/img/footer/linkedin-icon.png" alt="LinkedIn">
            <img src="assets/img/footer/google-icon.svg" alt="Google Plus">
            <img src="assets/img/footer/ig-icon.svg" alt="Instagram">
          </div>
        </div>

        <!-- Links -->
        <div class="footer-links">
          <h5>LINKS</h5>
          <ul>
            <li><a href="sobre.php">ABOUT</a></li>
            <li><a href="#">GALLERY</a></li>
            <li><a href="#">BLOG</a></li>
            <li><a href="#">PORTFOLIO</a></li>
            <li><a href="#">CONTACT US</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>

        <!-- Acomodações -->
        <div class="footer-acomodacoes">
          <h5>ACOMODAÇÕES</h5>
          <ul>
            <li><a href="#">CLASSIC</a></li>
            <li><a href="#">SUPERIOR</a></li>
            <li><a href="#">DELUX</a></li>
            <li><a href="#">MASTER</a></li>
            <li><a href="#">LUXURY</a></li>
            <li><a href="#">BANQUET HALLS</a></li>
          </ul>
        </div>

        <!-- Fale conosco -->
        <div class="footer-contato">
          <h5>FALE CONOSCO</h5>
          <div>
            <img src="assets/img/footer/maps-icon.svg" alt="Ícone endereço">
            <span id="address">
              92 Princess Road, Parkvenue,
              Greater London, NW18JR, United Kingdom
            </span>
          </div>
          <div class="contato-item">
            <img src="assets/img/footer/email-icon.svg" alt="Ícone email">
            <span>sharandemo@gmail.com</span>
          </div>
          <div class="contato-item">
            <img src="assets/img/footer/number-icon.svg" alt="Ícone telefone">
            <span>(+0091) 912-3456-073</span>
          </div>
          <div class="contato-item">
            <img src="assets/img/footer/print-icon.svg" alt="Ícone telefone">
            <span>(+0091) 912-3456-084</span>
          </div>
        </div>

      </div>
    </div>
  </footer>

  <div class="direitos">
    <p>© 2024 Your Company. Designed By Jafe</p>
  </div>
  <div id="modal" class="static-modal hidden" role="dialog" aria-hidden="true" aria-labelledby="modal-title">
    <div class="modal-content">
      <h2 id="modal-title">Inscrição realizada com sucesso!</h2>
      <button id="close-modal" aria-label="Fechar modal">Fechar</button>
    </div>
  </div>
  <script src="assets/js/validacoes-reserva.js"></script>
  <script src="assets/js/header.js"></script>
  <script src="assets/js/datepicker.js"></script>
  <script src="assets/js/reserva.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/email.js"></script>
</body>

</html>