/**
 * "Construção" ao rolar: os blocos marcados com a classe "sobe" sobem e se encaixam
 * quando entram na tela, como as casas do logo sendo empilhadas.
 *
 * - O CSS só esconde esses blocos quando o JavaScript está ativo (a classe "js" no <html>),
 *   então sem JavaScript nada fica invisível.
 * - Quem prefere menos movimento (prefers-reduced-motion) vê tudo parado, sem animação (CSS).
 */
(function () {
  var itens = Array.prototype.slice.call(document.querySelectorAll('.sobe'));
  if (!itens.length) { return; }

  // Navegadores sem IntersectionObserver: mostra tudo de uma vez
  if (!('IntersectionObserver' in window)) {
    itens.forEach(function (el) { el.classList.add('dentro'); });
    return;
  }

  var observador = new IntersectionObserver(function (entradas) {
    entradas.forEach(function (e) {
      if (e.isIntersecting) {
        e.target.classList.add('dentro');
        observador.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });

  itens.forEach(function (el) { observador.observe(el); });
})();
