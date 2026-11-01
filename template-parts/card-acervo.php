<?php
/**
 * Cartão de item do acervo (Biblioteca da Home e página do território).
 *
 * Parâmetros em $args:
 *   post      WP_Post do item (obrigatório)
 *   terr      WP_Post do território do item, ou null
 *   show_terr mostrar a etiqueta do território? (padrão: true)
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$a = $args['post'] ?? null;
if ( ! $a ) {
	return;
}

$terr       = $args['terr'] ?? null;
$mostra_ter = $args['show_terr'] ?? true;
$tipo       = athis_meta( $a->ID, 'tipo' );
$ano        = athis_meta( $a->ID, 'ano' );
$autoria    = athis_meta( $a->ID, 'autoria' );
$orient     = athis_meta( $a->ID, 'orientacao' );
$arquivo    = athis_pdf_url( $a->ID );

if ( $autoria ) {
	$resumo = 'Autoria: ' . $autoria . ( $orient ? '. Orientação: ' . $orient . '.' : '.' );
} else {
	$resumo = get_the_excerpt( $a );
}
?>
<div class="lib-card" data-terr="<?php echo esc_attr( $terr ? $terr->post_name : '' ); ?>">
  <?php if ( $terr && $mostra_ter ) : ?>
    <div class="lib-card-terr">📍 <?php echo esc_html( get_the_title( $terr ) ); ?></div>
  <?php endif; ?>
  <div class="lib-card-type"><?php echo esc_html( trim( $tipo . ( $ano ? ' · ' . $ano : '' ) ) ); ?></div>
  <h4><?php echo esc_html( get_the_title( $a ) ); ?></h4>
  <p><?php echo esc_html( $resumo ); ?></p>
  <?php if ( $arquivo ) : ?>
    <a class="lib-download" href="<?php echo esc_url( $arquivo ); ?>" target="_blank" rel="noopener"><?php echo athis_icone_download(); // phpcs:ignore WordPress.Security.EscapeOutput ?> Baixar PDF</a>
  <?php else : ?>
    <span class="lib-download is-disabled"><?php echo athis_icone_download(); // phpcs:ignore WordPress.Security.EscapeOutput ?> PDF indisponível</span>
  <?php endif; ?>
</div>
