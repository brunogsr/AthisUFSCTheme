<?php
/**
 * Página de um território: apresentação, projetos e acervo daquela comunidade.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$t        = get_post();
	$img      = athis_imagem_url( $t->ID, 'full' );
	$alt      = ( 'cinza' === athis_meta( $t->ID, 'visual', 'azul' ) );
	$projetos = athis_posts_do_territorio( 'projeto', $t->ID, 'ASC' );
	$acervo   = athis_posts_do_territorio( 'acervo', $t->ID, 'DESC' );
	$n_proj   = count( $projetos );
	$n_acervo = count( $acervo );
	$admin    = current_user_can( 'edit_posts' );
	?>

  <!-- APRESENTAÇÃO DO TERRITÓRIO -->
  <header class="terr-hero<?php echo $alt ? ' is-alt' : ''; ?>">
    <div class="terr-hero-bg<?php echo $img ? '' : ' no-img'; ?>"<?php echo athis_bg_style( $img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>></div>
    <div class="container">
      <a class="terr-back" href="<?php echo esc_url( home_url( '/#territorios' ) ); ?>">← Atlas de Territórios</a>
      <?php if ( athis_meta( $t->ID, 'localidade' ) ) : ?>
        <div class="atlas-tag"><?php echo esc_html( athis_meta( $t->ID, 'localidade' ) ); ?></div>
      <?php endif; ?>
      <h1><?php echo esc_html( get_the_title( $t ) ); ?></h1>
      <?php if ( has_excerpt( $t ) ) : ?>
        <p class="terr-lead"><?php echo esc_html( get_the_excerpt( $t ) ); ?></p>
      <?php endif; ?>
      <div class="atlas-meta">
        <?php foreach ( array( 'destaque_1', 'destaque_2' ) as $chave ) :
          $texto = athis_meta( $t->ID, $chave );
          if ( $texto ) : ?>
            <span><?php echo esc_html( $texto ); ?></span>
          <?php endif;
        endforeach; ?>
      </div>
      <div class="terr-contagem">
        <?php echo (int) $n_proj; ?> <?php echo 1 === $n_proj ? 'projeto' : 'projetos'; ?>
        · <?php echo (int) $n_acervo; ?> <?php echo 1 === $n_acervo ? 'item no acervo' : 'itens no acervo'; ?>
      </div>
    </div>
  </header>

  <?php if ( '' !== trim( $t->post_content ) ) : ?>
  <!-- SOBRE O TERRITÓRIO (texto escrito no editor) -->
  <section class="terr-sobre">
    <div class="container">
      <?php if ( athis_meta( $t->ID, 'titulo_texto' ) ) : ?>
        <h2 class="section-title"><?php echo esc_html( athis_meta( $t->ID, 'titulo_texto' ) ); ?></h2>
      <?php endif; ?>
      <div class="entry-content"><?php the_content(); ?></div>
    </div>
  </section>
  <?php endif; ?>

  <!-- PROJETOS DO TERRITÓRIO -->
  <section id="projetos" class="experiences">
    <div class="container">
      <span class="tag">Frentes e projetos</span>
      <h2 class="section-title">Projetos em <?php echo esc_html( get_the_title( $t ) ); ?></h2>

      <div class="exp-grid">
        <?php if ( $projetos ) : ?>
          <?php foreach ( $projetos as $p ) :
            get_template_part( 'template-parts/card', 'projeto', array(
              'post'      => $p,
              'terr'      => $t,
              'show_terr' => false,
            ) );
          endforeach; ?>
        <?php else : ?>
          <div class="empty-note">
            Ainda não há projetos cadastrados neste território.
            <?php if ( $admin ) : ?>
              Cadastre em <strong>Projetos &gt; Adicionar</strong>.
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ( $acervo || $admin ) : ?>
  <!-- ACERVO DO TERRITÓRIO -->
  <section id="acervo" class="library">
    <div class="container">
      <span class="tag" style="background:rgba(255,255,255,0.1); color:var(--white); border:1px solid rgba(255,255,255,0.3);">Hub de Documentos</span>
      <h2 class="section-title">Acervo de <?php echo esc_html( get_the_title( $t ) ); ?></h2>

      <div class="lib-grid">
        <?php if ( $acervo ) : ?>
          <?php foreach ( $acervo as $a ) :
            get_template_part( 'template-parts/card', 'acervo', array(
              'post'      => $a,
              'terr'      => $t,
              'show_terr' => false,
            ) );
          endforeach; ?>
        <?php else : ?>
          <div class="empty-note">Nenhum item no acervo deste território. Cadastre em <strong>Acervo &gt; Adicionar</strong>.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

<?php
endwhile;

get_footer();
