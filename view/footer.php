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
    <!-- Newsletter modal (nome e classes alterados para não conflitar com Bootstrap) -->
    <div id="modal-newsletter" class="newsletter-modal hidden" role="dialog" aria-hidden="true" aria-labelledby="modal-newsletter-title">
      <div class="newsletter-modal-content">
        <h2 id="modal-newsletter-title">Inscrição realizada com sucesso!</h2>
        <button id="close-modal-news" aria-label="Fechar modal">Fechar</button>
      </div>
    </div>
    <script src="assets/js/email.js"></script>
</footer>