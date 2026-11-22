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
  <script>
    /* Aplica cedo o tamanho de texto escolhido (evita "piscar"). Veja assets/js/acessibilidade.js (o zoom multiplica a escala automática do CSS) */
    (function(){try{var e={},p=[100,112.5,125,137.5],d=document.documentElement;d.classList.add('js');e=JSON.parse(localStorage.getItem('athis-acess'))||{};if(e.t>0&&p[e.t]){d.style.setProperty('--zoom',p[e.t]/100);}}catch(x){}})();
  </script>
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
        <div class="acess" role="group" aria-label="Tamanho do texto">
          <button type="button" data-acess="menos" aria-label="Diminuir o tamanho do texto">A&minus;</button>
          <button type="button" data-acess="mais" aria-label="Aumentar o tamanho do texto">A+</button>
        </div>
      </div>
    </div>
  </nav>

<main id="conteudo">
