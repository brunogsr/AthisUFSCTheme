<?php
/**
 * Cabeçalho: abre o HTML e mostra a barra de navegação.
 * Termina abrindo o <main id="conteudo">, que o footer.php fecha.
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
  <meta name="theme-color" content="#0B1F3A" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <a class="skip-link" href="#conteudo">Pular para o conteúdo</a>

  <!-- NAVBAR -->
  <nav class="navbar" aria-label="Menu principal">
    <div class="container">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-athis.png' ); ?>" width="900" height="295" alt="ATHIS UFSC - Residência em Arquitetura e Urbanismo (página inicial)">
      </a>
      <button class="nav-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="menu-principal">
        <span></span><span></span><span></span>
      </button>
      <div class="nav-links" id="menu-principal">
        <a href="<?php echo esc_url( $athis_home . '#sobre' ); ?>">O Programa</a>
        <a href="<?php echo esc_url( $athis_home . '#territorios' ); ?>">Atlas de Territórios</a>
        <a href="<?php echo esc_url( $athis_home . '#experiencias' ); ?>">Projetos</a>
        <a href="<?php echo esc_url( $athis_home . '#conhecimento' ); ?>">Acervo</a>
        <a href="<?php echo esc_url( $athis_home . '#conhecimento' ); ?>" class="btn btn-primary">Acessar Hub</a>
      </div>
    </div>
  </nav>

<main id="conteudo">
