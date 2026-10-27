<?php
/**
 * Cabeçalho: abre o HTML e mostra a barra de navegação.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Fora da página inicial, os links de âncora precisam apontar para a home.
$athis_home = is_front_page() ? '' : home_url( '/' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="container">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--terra)"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        ATHIS <span>UFSC</span>
      </a>
      <div class="nav-links">
        <a href="<?php echo esc_url( $athis_home . '#sobre' ); ?>">O Programa</a>
        <a href="<?php echo esc_url( $athis_home . '#territorios' ); ?>">Atlas de Territórios</a>
        <a href="<?php echo esc_url( $athis_home . '#experiencias' ); ?>">Projetos</a>
        <a href="<?php echo esc_url( $athis_home . '#conhecimento' ); ?>">Acervo</a>
        <a href="<?php echo esc_url( $athis_home . '#conhecimento' ); ?>" class="btn btn-primary">Acessar Hub</a>
      </div>
    </div>
  </nav>
