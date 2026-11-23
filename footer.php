<?php
/**
 * Rodapé: fecha o <main> aberto no header.php e o HTML.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$athis_home = is_front_page() ? '' : home_url( '/' );
?>

</main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-athis.png' ); ?>" width="900" height="295" alt="ATHIS UFSC - Residência em Arquitetura e Urbanismo" loading="lazy">
          </a>
          <p style="font-size:0.875rem; margin-bottom:12px; max-width:300px;"><?php echo esc_html( athis_texto( 'rod_desc' ) ); ?></p>
          <p style="font-size:0.875rem;">Contato: <?php echo esc_html( athis_texto( 'rod_email' ) ); ?><br><?php echo esc_html( athis_texto( 'rod_cidade' ) ); ?></p>
        </div>
        <div>
          <h5>Navegação</h5>
          <div class="footer-links">
            <a href="<?php echo esc_url( $athis_home . '#sobre' ); ?>">O Guarda-Chuva</a>
            <a href="<?php echo esc_url( $athis_home . '#territorios' ); ?>">Atlas de Territórios</a>
            <a href="<?php echo esc_url( $athis_home . '#experiencias' ); ?>">Projetos por Frentes</a>
            <a href="<?php echo esc_url( $athis_home . '#conhecimento' ); ?>">Biblioteca Integrada</a>
          </div>
        </div>
        <div>
          <h5>Transparência</h5>
          <div class="footer-links">
            <a href="#">Equipe e Docentes</a>
            <a href="#">Relatórios Anuais</a>
            <a href="#">Parceiros Financiadores</a>
            <a href="#">Política de Privacidade</a>
          </div>
        </div>
        <div>
          <h5>Participe</h5>
          <div class="footer-links">
            <a href="<?php echo esc_url( athis_inscricoes_pagina_url() ); ?>">Seja um voluntário</a>
            <a href="<?php echo esc_url( athis_inscricoes_pagina_url() ); ?>">Edital de Bolsas</a>
            <a href="<?php echo esc_url( athis_inscricoes_pagina_url() ); ?>">Apoie um projeto</a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> ATHIS UFSC. Todos os direitos reservados.</p>
        <div class="footer-partners">
          <span class="partner-ph">UFSC</span>
          <span class="partner-ph">PERIFERIA VIVA</span>
          <span class="partner-ph">MINISTÉRIO DAS CIDADES</span>
        </div>
      </div>
    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>
