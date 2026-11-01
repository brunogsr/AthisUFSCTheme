<?php
/**
 * Cartão de projeto (Vitrine da Home e página do território).
 *
 * Parâmetros em $args:
 *   post      WP_Post do projeto (obrigatório)
 *   terr      WP_Post do território do projeto, ou null
 *   show_terr mostrar a etiqueta do território? (padrão: true)
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$p = $args['post'] ?? null;
if ( ! $p ) {
	return;
}

$terr       = $args['terr'] ?? null;
$mostra_ter = $args['show_terr'] ?? true;
$img        = athis_imagem_url( $p->ID, 'large' );
$status     = athis_meta( $p->ID, 'status' );
$alt        = $terr && ( 'cinza' === athis_meta( $terr->ID, 'visual', 'azul' ) );
?>
<a class="exp-card" href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-terr="<?php echo esc_attr( $terr ? $terr->post_name : '' ); ?>">
  <div class="exp-img<?php echo $img ? '' : ' no-img'; ?>"<?php echo athis_bg_style( $img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
    <?php if ( $terr && $mostra_ter ) : ?>
      <div class="exp-terr<?php echo $alt ? ' is-alt' : ''; ?>"><?php echo esc_html( get_the_title( $terr ) ); ?></div>
    <?php endif; ?>
    <?php if ( $status ) : ?>
      <div class="exp-status<?php echo ( 'Concluído' === $status ) ? '' : ' is-info'; ?>"><?php echo esc_html( $status ); ?></div>
    <?php endif; ?>
  </div>
  <div class="exp-content">
    <h3 class="exp-title"><?php echo esc_html( get_the_title( $p ) ); ?></h3>
    <p class="exp-desc"><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
    <span class="exp-link"><?php echo esc_html( athis_meta( $p->ID, 'texto_link', 'Ver projeto' ) ); ?> →</span>
  </div>
</a>
