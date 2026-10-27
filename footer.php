<?php
/**
 * Rodapé: fecha o HTML.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$athis_home = is_front_page() ? '' : home_url( '/' );
?>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--terra)"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            ATHIS <span>UFSC</span>
          </a>
          <p style="font-size:0.875rem; margin-bottom:24px; max-width:300px;">Plataforma Institucional em Arquitetura, Urbanismo e Assessoria Técnica. Universidade Federal de Santa Catarina.</p>
          <p style="font-size:0.875rem;">Contato: athis@contato.ufsc.br<br>Florianópolis, SC - Brasil</p>
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
            <a href="#">Seja um voluntário</a>
            <a href="#">Edital de Bolsas</a>
            <a href="#">Apoie um projeto</a>
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
