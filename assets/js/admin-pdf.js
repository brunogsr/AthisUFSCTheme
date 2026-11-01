/**
 * Campo "Arquivo PDF" do Acervo: abre a biblioteca de mídia filtrada por PDF,
 * guarda o ID do arquivo escolhido e mostra o nome na tela.
 */
(function ($) {
  $(function () {
    $('.athis-pdf').each(function () {
      var box = $(this);
      var input = box.find('input[type=hidden]');
      var nome = box.find('.athis-pdf-nome');
      var remover = box.find('.athis-pdf-remover');
      var frame;

      function mostrar(texto) {
        nome.text(texto || 'Nenhum arquivo selecionado');
        remover.toggle(!!input.val());
      }

      box.find('.athis-pdf-escolher').on('click', function (e) {
        e.preventDefault();
        if (!frame) {
          frame = wp.media({
            title: 'Escolher PDF',
            button: { text: 'Usar este PDF' },
            library: { type: 'application/pdf' },
            multiple: false
          });
          frame.on('select', function () {
            var a = frame.state().get('selection').first().toJSON();
            input.val(a.id);
            mostrar(a.filename || a.title);
          });
        }
        frame.open();
      });

      remover.on('click', function (e) {
        e.preventDefault();
        input.val('');
        mostrar('');
      });

      mostrar(nome.text() === 'Nenhum arquivo selecionado' ? '' : nome.text());
    });
  });
})(jQuery);
