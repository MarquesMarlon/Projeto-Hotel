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
    <div id="modal" class="modal hidden" role="dialog" aria-hidden="true" aria-labelledby="modal-title">
      <div class="modal-content">
        <h2 id="modal-title">Inscrição realizada com sucesso!</h2>
        <button id="close-modal" aria-label="Fechar modal">Fechar</button>
      </div>
    </div>
    <script src="assets/js/email.js"></script>
</footer>