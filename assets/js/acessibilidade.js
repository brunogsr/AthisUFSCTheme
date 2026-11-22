/**
 * Botões A- / A+ do menu: tamanho do texto do site.
 * A escolha fica guardada no navegador (localStorage) e vale nas outras páginas.
 * O mesmo estado é aplicado cedo por um pequeno script no <head> (header.php),
 * para a página não "piscar" ao carregar.
 */
(function () {
  var CHAVE = 'athis-acess';
  var PASSOS = [100, 112.5, 125, 137.5]; // % do tamanho-padrão do site (cada clique em A+ aumenta, em A- diminui)
  var raiz = document.documentElement;

  function ler() {
    try { return JSON.parse(localStorage.getItem(CHAVE)) || {}; } catch (e) { return {}; }
  }
  function gravar(estado) {
    try { localStorage.setItem(CHAVE, JSON.stringify(estado)); } catch (e) { /* sem armazenamento: só vale nesta página */ }
  }

  var estado = ler();
  estado.t = (typeof estado.t === 'number' && PASSOS[estado.t]) ? estado.t : 0;

  var btnMenos = document.querySelector('[data-acess="menos"]');
  var btnMais = document.querySelector('[data-acess="mais"]');

  function aplicar() {
    // O zoom multiplica a escala automática do CSS (variável --zoom); no passo 0 volta ao padrão
    if (estado.t > 0) { raiz.style.setProperty('--zoom', PASSOS[estado.t] / 100); } else { raiz.style.removeProperty('--zoom'); }
    if (btnMenos) { btnMenos.disabled = estado.t === 0; }
    if (btnMais) { btnMais.disabled = estado.t === PASSOS.length - 1; }
  }

  if (btnMenos) {
    btnMenos.addEventListener('click', function () {
      if (estado.t > 0) { estado.t--; gravar(estado); aplicar(); }
    });
  }
  if (btnMais) {
    btnMais.addEventListener('click', function () {
      if (estado.t < PASSOS.length - 1) { estado.t++; gravar(estado); aplicar(); }
    });
  }

  aplicar();
})();
