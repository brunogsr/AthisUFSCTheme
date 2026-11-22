<?php
/**
 * Página de um projeto: apresentação, texto completo, acervo relacionado e outros projetos do território.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$p      = get_post();
	$img    = athis_imagem_url( $p->ID, 'full' );
	$status = athis_meta( $p->ID, 'status' );
	$admin  = current_user_can( 'edit_posts' );

	// Território do projeto (se ainda existir e for mesmo um território)
	$terr = null;
	$tid  = absint( athis_meta( $p->ID, 'territorio_id' ) );
	// Só usa o território se estiver publicado (quem edita o vê também em rascunho)
	if ( $tid && 'territorio' === get_post_type( $tid ) && ( 'publish' === get_post_status( $tid ) || current_user_can( 'edit_post', $tid ) ) ) {
		$terr = get_post( $tid );
	}
	$cor = athis_cor_classe( $terr );

	$acervo = athis_posts_do_projeto( $p->ID );

	// Outros projetos do mesmo território (sem repetir este)
	$outros = array();
	if ( $terr ) {
		foreach ( athis_posts_do_territorio( 'projeto', $terr->ID, 'ASC' ) as $o ) {
			if ( $o->ID !== $p->ID ) {
				$outros[] = $o;
			}
		}
	}
	?>

  <!-- APRESENTAÇÃO DO PROJETO -->
  <header class="terr-hero <?php echo esc_attr( $cor ); ?>">
    <div class="terr-hero-bg<?php echo $img ? '' : ' no-img'; ?>"<?php echo athis_bg_style( $img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>></div>
    <div class="container">
      <?php if ( $terr ) : ?>
        <a class="terr-back" href="<?php echo esc_url( get_permalink( $terr ) ); ?>">← <?php echo esc_html( get_the_title( $terr ) ); ?></a>
      <?php else : ?>
        <a class="terr-back" href="<?php echo esc_url( home_url( '/#experiencias' ) ); ?>">← Projetos</a>
      <?php endif; ?>
      <?php if ( $status ) : ?>
        <div class="atlas-tag"><?php echo esc_html( $status ); ?></div>
      <?php endif; ?>
      <h1><?php echo esc_html( get_the_title( $p ) ); ?></h1>
      <?php if ( has_excerpt( $p ) ) : ?>
        <p class="terr-lead"><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
      <?php endif; ?>
      <?php if ( $terr ) : ?>
        <div class="atlas-meta"><span>📍 <?php echo esc_html( get_the_title( $terr ) ); ?></span></div>
      <?php endif; ?>
    </div>
  </header>

  <?php if ( '' !== trim( $p->post_content ) ) : ?>
  <!-- TEXTO DO PROJETO (escrito no editor) -->
  <section class="terr-sobre">
    <div class="container">
      <div class="entry-content"><?php the_content(); ?></div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ( $acervo || $admin ) : ?>
  <!-- ACERVO DO PROJETO -->
  <section id="acervo" class="library">
    <div class="container">
      <span class="tag">Hub de Documentos</span>
      <h2 class="section-title">Documentos deste projeto</h2>

      <div class="lib-grid">
        <?php if ( $acervo ) : ?>
          <?php foreach ( $acervo as $a ) :
            get_template_part( 'template-parts/card', 'acervo', array(
              'post'      => $a,
              'terr'      => $terr,
              'show_terr' => false,
            ) );
          endforeach; ?>
        <?php else : ?>
          <div class="empty-note">Nenhum documento ligado a este projeto. Em <strong>Acervo &gt; editar item</strong>, escolha este projeto no campo "Projeto relacionado".</div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ( $outros ) : ?>
  <!-- OUTROS PROJETOS DO TERRITÓRIO -->
  <section class="experiences">
    <div class="container">
      <span class="tag">Mais do território</span>
      <h2 class="section-title">Outros projetos em <?php echo esc_html( get_the_title( $terr ) ); ?></h2>

      <div class="exp-grid">
        <?php foreach ( $outros as $o ) :
          get_template_part( 'template-parts/card', 'projeto', array(
            'post'      => $o,
            'terr'      => $terr,
            'show_terr' => false,
          ) );
        endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

<?php
endwhile;

get_footer();
