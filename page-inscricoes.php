<?php
/**
 * Página "Inscrições" (slug: inscricoes).
 * Fundo colorido e cartões brancos simples; cada cartão leva a um formulário do Google
 * (os links são colados em Configurações > Inscrições ATHIS).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$opcoes = athis_inscricoes_opcoes();
?>

  <!-- APRESENTAÇÃO -->
  <header class="insc-hero">
    <div class="container">
      <a class="terr-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">← Início</a>
      <span class="tag">Participe</span>
      <h1>Inscrições</h1>
      <p class="insc-lead">Escolha como quer participar do ATHIS UFSC. Cada opção abre um formulário do Google em uma nova aba.</p>
    </div>
    <div class="insc-casas" aria-hidden="true"><?php echo athis_casas_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
    <div class="hero-telhado" aria-hidden="true"></div>
  </header>

  <!-- OPÇÕES -->
  <section class="insc-lista">
    <div class="container">
      <div class="insc-grid">
        <?php foreach ( $opcoes as $chave => $o ) :
          $url = athis_inscricao_url( $chave );
          ?>
          <article class="insc-card sobe <?php echo esc_attr( $o['cor'] ); ?>">
            <span class="insc-icone" aria-hidden="true"></span>
            <h2><?php echo esc_html( $o['titulo'] ); ?></h2>
            <p><?php echo esc_html( $o['texto'] ); ?></p>
            <?php if ( $url ) : ?>
              <a class="insc-btn" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">Inscrever-se →<span class="sr-only"> (abre o formulário do Google em uma nova aba)</span></a>
            <?php else : ?>
              <span class="insc-btn is-breve">Em breve</span>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>

      <?php if ( current_user_can( 'manage_options' ) ) : ?>
        <p class="empty-note insc-aviso">Aviso para administradores: cole os links dos formulários em <a href="<?php echo esc_url( admin_url( 'options-general.php?page=athis-inscricoes' ) ); ?>">Configurações &gt; Inscrições ATHIS</a>. Opções sem link aparecem como "Em breve".</p>
      <?php endif; ?>
    </div>
  </section>

<?php get_footer(); ?>
