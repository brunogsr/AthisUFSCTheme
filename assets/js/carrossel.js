/**
 * Carrossel no celular: "Muito além da construção" (.about-grid) e "Atlas de Territórios" (.atlas-grid).
 * O deslizar com o dedo é feito só pelo CSS (scroll-snap). Este script acrescenta as setas e os pontos
 * (que o CSS só mostra em telas até 768px) e marca qual item está à vista.
 */
(function () {
  var SELETORES = ['.about-grid', '.atlas-grid'];
  var reduzMovimento = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function criar(tag, classe, atributos) {
    var el = document.createElement(tag);
    el.className = classe;
    Object.keys(atributos || {}).forEach(function (k) { el.setAttribute(k, atributos[k]); });
    return el;
  }

  function montar(grade) {
    var itens = Array.prototype.slice.call(grade.children);
    if (itens.length < 2) { return; }

    var barra = criar('div', 'carrossel-controles', { role: 'group', 'aria-label': 'Navegação do carrossel' });
    var anterior = criar('button', 'carrossel-seta', { type: 'button', 'aria-label': 'Item anterior' });
    var proximo = criar('button', 'carrossel-seta', { type: 'button', 'aria-label': 'Próximo item' });
    anterior.innerHTML = '&#8249;';
    proximo.innerHTML = '&#8250;';
    var pontos = criar('div', 'carrossel-pontos');

    var botoes = itens.map(function (item, i) {
      var p = criar('button', 'carrossel-ponto', { type: 'button', 'aria-label': 'Ir para o item ' + (i + 1) + ' de ' + itens.length });
      p.addEventListener('click', function () { ir(i); });
      pontos.appendChild(p);
      return p;
    });

    barra.appendChild(anterior);
    barra.appendChild(pontos);
    barra.appendChild(proximo);
    grade.parentNode.insertBefore(barra, grade.nextSibling);

    function margemEsquerda() {
      return parseFloat(window.getComputedStyle(grade).paddingLeft) || 0;
    }

    // Índice do item cujo início está mais perto do início da área visível
    function atual() {
      var base = grade.getBoundingClientRect().left + margemEsquerda();
      var melhor = 0;
      var menor = Infinity;
      itens.forEach(function (item, i) {
        var d = Math.abs(item.getBoundingClientRect().left - base);
        if (d < menor) { menor = d; melhor = i; }
      });
      return melhor;
    }

    function ir(i) {
      i = Math.max(0, Math.min(itens.length - 1, i));
      var alvo = grade.scrollLeft + (itens[i].getBoundingClientRect().left - grade.getBoundingClientRect().left) - margemEsquerda();
      grade.scrollTo({ left: alvo, behavior: reduzMovimento ? 'auto' : 'smooth' });
    }

    function atualizar() {
      var i = atual();
      // Fim da lista: o último item pode não chegar ao início da tela
      if (grade.scrollLeft + grade.clientWidth >= grade.scrollWidth - 2) { i = itens.length - 1; }
      botoes.forEach(function (b, n) { b.setAttribute('aria-current', n === i ? 'true' : 'false'); });
      anterior.disabled = i === 0;
      proximo.disabled = i === itens.length - 1;
    }

    anterior.addEventListener('click', function () { ir(atual() - 1); });
    proximo.addEventListener('click', function () { ir(atual() + 1); });

    var espera = null;
    grade.addEventListener('scroll', function () {
      if (espera) { return; }
      espera = window.requestAnimationFrame(function () { espera = null; atualizar(); });
    }, { passive: true });
    window.addEventListener('resize', atualizar);

    atualizar();
  }

  SELETORES.forEach(function (sel) {
    var grade = document.querySelector(sel);
    if (grade) { montar(grade); }
  });
})();
