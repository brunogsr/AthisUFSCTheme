/**
 * Filtros por território (Vitrine de Experiências e Biblioteca).
 * Cada botão tem data-filter="<slug do território>" (ou "all")
 * e cada card tem data-terr="<slug do território>".
 */
(function () {
  function setupFilters(btnSelector, itemSelector) {
    var btns = document.querySelectorAll(btnSelector);
    var items = document.querySelectorAll(itemSelector);

    btns.forEach(function (btn) {
      // Leitores de tela anunciam qual filtro está ligado
      btn.setAttribute('aria-pressed', btn.classList.contains('active') ? 'true' : 'false');
      btn.addEventListener('click', function () {
        btns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
        btn.classList.add('active');
        btn.setAttribute('aria-pressed', 'true');

        var filterValue = btn.getAttribute('data-filter');

        items.forEach(function (item) {
          if (filterValue === 'all' || item.getAttribute('data-terr') === filterValue) {
            item.classList.remove('hidden');
          } else {
            item.classList.add('hidden');
          }
        });
      });
    });
  }

  setupFilters('#exp-filters .filter-btn', '#exp-grid .exp-slot');
  setupFilters('#lib-filters .filter-btn', '#lib-grid .lib-slot');
})();

/**
 * Menu do celular: abre e fecha o painel de links.
 */
(function () {
  var nav = document.querySelector('.navbar');
  var btn = document.querySelector('.nav-toggle');
  if (!nav || !btn) { return; }

  function definir(aberto) {
    nav.classList.toggle('open', aberto);
    btn.setAttribute('aria-expanded', aberto ? 'true' : 'false');
    btn.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
  }

  btn.addEventListener('click', function () {
    definir(!nav.classList.contains('open'));
  });

  nav.querySelectorAll('.nav-links a').forEach(function (a) {
    a.addEventListener('click', function () { definir(false); });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { definir(false); }
  });
})();
