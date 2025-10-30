// Pequeno script para adicionar/remover a classe `.header-bg` na `.navbar`
// quando o usuário rola a página. Usa requestAnimationFrame para melhor
// desempenho e previne múltiplas chamadas por evento de scroll.
(function () {
  'use strict';

  var navbar = document.querySelector('.navbar');
  if (!navbar) return;

  var threshold = 80; // altura em px antes de ativar o header compacto
  var ticking = false;

  function onScroll() {
    var sc = window.scrollY || document.documentElement.scrollTop;
    if (sc > threshold) {
      navbar.classList.add('header-bg');
    } else {
      navbar.classList.remove('header-bg');
    }
    ticking = false;
  }

  function requestTick() {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }

  window.addEventListener('scroll', requestTick, { passive: true });
  window.addEventListener('resize', requestTick);

  // executa já ao carregar para ajustar estado inicial
  document.addEventListener('DOMContentLoaded', onScroll);
  onScroll();
})();
