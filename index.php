<?php
/**
 * Modelo genérico: páginas internas, páginas de território/projeto/acervo e listagens.
 * No esboço serve de base; na versão final cada tipo ganha seu próprio template.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="page-wrap">
  <div class="container">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
          <?php if ( is_singular() ) : ?>
            <?php
            $chips = array();
            foreach ( array( 'localidade', 'status', 'tipo', 'ano' ) as $chave ) {
              $v = athis_meta( get_the_ID(), $chave );
              if ( $v ) {
                $chips[] = $v;
              }
            }
            $img = athis_imagem_url( get_the_ID(), 'large' );
            ?>
            <h1><?php the_title(); ?></h1>
            <?php if ( $chips ) : ?>
              <div class="entry-meta">
                <?php foreach ( $chips as $c ) : ?>
                  <span><?php echo esc_html( $c ); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php if ( $img ) : ?>
              <div class="entry-thumb"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></div>
            <?php endif; ?>
            <div class="entry-content">
              <?php
              if ( 'acervo' === get_post_type() ) {
                echo wp_kses_post( wpautop( get_the_excerpt() ) );
                $arquivo = athis_meta( get_the_ID(), 'arquivo_url' );
                if ( $arquivo ) {
                  echo '<p><a href="' . esc_url( $arquivo ) . '" target="_blank" rel="noopener">Baixar PDF</a></p>';
                }
              } else {
                the_content();
              }
              ?>
            </div>
          <?php else : ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p><?php echo esc_html( get_the_excerpt() ); ?></p>
          <?php endif; ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <h1>Nada por aqui</h1>
      <p>Não encontramos conteúdo para esta página.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
