<?php
/**
 * Página inicial.
 * Seções fixas: Hero, "O que é ATHIS", Expansão.
 * Seções dinâmicas (vêm dos tipos de conteúdo): Atlas, Ecossistema, Projetos, Acervo.
 *
 * Estrutura visual: a página é um fundo contínuo e as seções são "casas empilhadas" (blocos de cor
 * desencontrados, com telhados inclinados). Algumas casas do logo atravessam as divisas
 * (athis_casa_peca) e os elementos com a classe "sobe" aparecem ao rolar (assets/js/construcao.js).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$territorios = get_posts( array(
	'post_type'      => 'territorio',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'ASC',
) );

$projetos = get_posts( array(
	'post_type'      => 'projeto',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'ASC',
) );

$acervo = get_posts( array(
	'post_type'      => 'acervo',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

// Mapa id => território, para achar nome e slug a partir do ID guardado no campo
$terr_por_id = array();
foreach ( $territorios as $t ) {
	$terr_por_id[ $t->ID ] = $t;
}

$demo_url = admin_url( 'tools.php?page=athis-demo' );
?>

  <!-- HERO -->
  <header class="hero">
    <!-- Fundo: ilustração "Capa Site" (moradores caminhando), espelhada, à esquerda. Decorativa; o escurecimento sob o texto o mantém legível e o lado direito é azul sólido (onde ficam as casas). -->
    <img class="hero-bg" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/capa-inicio.jpg' ); ?>" width="1800" height="1058" alt="" fetchpriority="high">
    <div class="container">
      <div class="hero-content">
        <div class="hero-tag"><?php echo esc_html( athis_texto( 'hero_tag' ) ); ?></div>
        <h1><span class="linha"><?php echo esc_html( athis_texto( 'hero_l1' ) ); ?></span><br><?php echo esc_html( athis_texto( 'hero_l2a' ) ); ?> <span><?php echo esc_html( athis_texto( 'hero_l2b' ) ); ?></span></h1>
        <p><?php echo athis_texto_html( 'hero_texto' ); ?></p>
        <div class="hero-btns">
          <a href="#territorios" class="btn btn-primary"><?php echo esc_html( athis_texto( 'hero_btn1' ) ); ?></a>
          <a href="#sobre" class="btn btn-outline"><?php echo esc_html( athis_texto( 'hero_btn2' ) ); ?></a>
        </div>
      </div>
      <div class="hero-art"><?php echo athis_casas_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
    </div>
    <!-- Telhado: o fundo claro "morde" o canto inferior do hero; uma casa do logo desce e pisa no bloco seguinte -->
    <div class="hero-telhado" aria-hidden="true"></div>
    <?php echo athis_casa_peca( 5, 'a1' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
  </header>

  <!-- CONCEITO: bloco amarelo recuado à direita; cada card é uma casa de formato diferente, com janela vazada -->
  <section id="sobre" class="bloco conceito">
    <div class="conceito-grid">
      <div class="conceito-txt sobe">
        <span class="tag"><?php echo esc_html( athis_texto( 'con_tag' ) ); ?></span>
        <h2 class="section-title"><?php echo esc_html( athis_texto( 'con_titulo' ) ); ?></h2>
        <p class="section-sub"><?php echo esc_html( athis_texto( 'con_sub' ) ); ?></p>
      </div>

      <div class="about-grid">
        <div class="about-card k1 vaza sobe">
          <h3><?php echo esc_html( athis_texto( 'k1_titulo' ) ); ?></h3>
          <p><?php echo esc_html( athis_texto( 'k1_texto' ) ); ?></p>
        </div>
        <div class="about-card k2 vaza sobe">
          <span class="about-marca" aria-hidden="true"></span>
          <h3><?php echo esc_html( athis_texto( 'k2_titulo' ) ); ?></h3>
          <p><?php echo esc_html( athis_texto( 'k2_texto' ) ); ?></p>
        </div>
        <div class="about-card k3 vaza sobe">
          <h3><?php echo esc_html( athis_texto( 'k3_titulo' ) ); ?></h3>
          <p><?php echo esc_html( athis_texto( 'k3_texto' ) ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ATLAS DE TERRITÓRIOS (vem do tipo "Território"): cada território é uma casa no chão; o formato depende da cor -->
  <section id="territorios" class="atlas">
    <?php echo athis_casa_peca( 3, 'a2' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
    <div class="container">
      <div class="sobe">
        <span class="tag tag-blue"><?php echo esc_html( athis_texto( 'atlas_tag' ) ); ?></span>
        <h2 class="section-title"><?php echo esc_html( athis_texto( 'atlas_titulo' ) ); ?></h2>
        <p class="section-sub"><?php echo esc_html( athis_texto( 'atlas_sub' ) ); ?></p>
      </div>

      <div class="atlas-grid">
        <?php if ( $territorios ) : ?>
          <?php foreach ( $territorios as $t ) :
            $img   = athis_imagem_url( $t->ID, 'large' );
            $cor   = athis_cor_classe( $t );
            $botao = athis_meta( $t->ID, 'texto_botao', 'Explorar território' );
            ?>
            <div class="casa-w sobe">
              <article class="atlas-card vaza <?php echo esc_attr( $cor ); ?>">
                <div class="atlas-img<?php echo $img ? '' : ' no-img'; ?>"<?php echo athis_bg_style( $img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>></div>
                <div class="atlas-content">
                  <div class="atlas-tag"><?php echo esc_html( athis_meta( $t->ID, 'localidade' ) ); ?></div>
                  <h3><?php echo esc_html( get_the_title( $t ) ); ?></h3>
                  <p><?php echo esc_html( get_the_excerpt( $t ) ); ?></p>
                  <div class="atlas-meta">
                    <?php foreach ( array( 'destaque_1', 'destaque_2' ) as $chave ) :
                      $texto = athis_meta( $t->ID, $chave );
                      if ( $texto ) : ?>
                        <span><?php echo esc_html( $texto ); ?></span>
                      <?php endif;
                    endforeach; ?>
                  </div>
                </div>
              </article>
              <!-- O botão fica fora da casa (que é recortada) e cai exatamente no vão da "porta" -->
              <a class="porta-cta" href="<?php echo esc_url( get_permalink( $t ) ); ?>"><?php echo esc_html( $botao ); ?> →</a>
            </div>
          <?php endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum território cadastrado ainda. Cadastre em <strong>Territórios &gt; Adicionar</strong> ou carregue exemplos em <a href="<?php echo esc_url( $demo_url ); ?>">Ferramentas &gt; Dados de exemplo ATHIS</a>.</div>
        <?php endif; ?>

        <!-- NOVOS TERRITÓRIOS (EXPANSÃO): a "casa aberta" -->
        <div class="atlas-expansion casa-aberta sobe">
          <svg viewBox="0 0 200 190" aria-hidden="true" focusable="false"><path d="M10 186 V66 L100 12 L190 66 V186 Z" fill="none" stroke="currentColor" stroke-width="5" stroke-dasharray="14 10" stroke-linejoin="round"/><path d="M100 80 V132 M74 106 H126" stroke="currentColor" stroke-width="9"/></svg>
          <h4><?php echo esc_html( athis_texto( 'atlas_exp_t' ) ); ?></h4>
          <p><?php echo esc_html( athis_texto( 'atlas_exp_p' ) ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ECOSSISTEMA: a "rua do bairro". Cada casa é um território; a altura e as janelas vêm do número real de projetos dele -->
  <section class="eco">
    <div class="container">
      <div class="eco-cab sobe">
        <h2 class="section-title"><?php echo esc_html( athis_texto( 'eco_titulo' ) ); ?></h2>
        <p class="section-sub"><?php echo esc_html( athis_texto( 'eco_sub' ) ); ?></p>
        <p class="eco-legenda"><?php echo esc_html( athis_texto( 'eco_legenda' ) ); ?></p>
      </div>

      <?php $colunas = count( $territorios ) + 1; ?>
      <div class="rua-eco" style="--cols:<?php echo (int) $colunas; ?>">
        <?php $col = 0; ?>
        <?php foreach ( $territorios as $t ) :
          $col++;
          $meus = array();
          foreach ( $projetos as $p ) {
            if ( (int) athis_meta( $p->ID, 'territorio_id' ) === $t->ID ) {
              $meus[] = $p;
            }
          }
          ?>
          <div class="casa-e vaza sobe <?php echo esc_attr( athis_cor_classe( $t ) ); ?>" style="grid-column:<?php echo (int) $col; ?>; --n:<?php echo count( $meus ); ?>" aria-hidden="true">
            <div class="janelas"><?php echo str_repeat( '<i></i>', count( $meus ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          </div>
          <div class="eco-rotulo <?php echo esc_attr( athis_cor_classe( $t ) ); ?>" style="grid-column:<?php echo (int) $col; ?>">
            <h3><a href="<?php echo esc_url( get_permalink( $t ) ); ?>"><?php echo esc_html( get_the_title( $t ) ); ?></a></h3>
            <?php if ( $meus ) : ?>
              <ul>
                <?php foreach ( $meus as $p ) : ?>
                  <li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a> <span><?php echo esc_html( athis_meta( $p->ID, 'status' ) ); ?></span></li>
                <?php endforeach; ?>
              </ul>
            <?php else : ?>
              <p class="eco-vazio">Nenhum projeto ainda.</p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

        <!-- Lote livre: sempre cabe mais uma casa na rua -->
        <div class="casa-e-aberta sobe" style="grid-column:<?php echo (int) $colunas; ?>" aria-hidden="true">
          <svg viewBox="0 0 200 190" focusable="false"><path d="M10 186 V66 L100 12 L190 66 V186 Z" fill="none" stroke="currentColor" stroke-width="5" stroke-dasharray="14 10" stroke-linejoin="round"/><path d="M100 80 V132 M74 106 H126" stroke="currentColor" stroke-width="9"/></svg>
        </div>
        <div class="eco-rotulo" style="grid-column:<?php echo (int) $colunas; ?>"><h3>Próximo território</h3><p class="eco-vazio">Espaço aberto na rua.</p></div>

        <div class="eco-chao" aria-hidden="true"></div>
      </div>
    </div>
  </section>

  <!-- VITRINE DE EXPERIÊNCIAS (vem do tipo "Projeto"): cards de alturas diferentes, apoiados no chão -->
  <section id="experiencias" class="experiences">
    <div class="container">
      <div class="sobe">
        <span class="tag"><?php echo esc_html( athis_texto( 'vit_tag' ) ); ?></span>
        <h2 class="section-title"><?php echo esc_html( athis_texto( 'vit_titulo' ) ); ?></h2>
        <p class="section-sub"><?php echo esc_html( athis_texto( 'vit_sub' ) ); ?></p>
      </div>

      <div class="filter-bar" id="exp-filters">
        <button class="filter-btn active" data-filter="all">Todos os Territórios</button>
        <?php foreach ( $territorios as $t ) : ?>
          <button class="filter-btn <?php echo esc_attr( athis_cor_classe( $t ) ); ?>" data-filter="<?php echo esc_attr( $t->post_name ); ?>"><?php echo esc_html( get_the_title( $t ) ); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="exp-grid" id="exp-grid">
        <?php if ( $projetos ) : ?>
          <?php foreach ( $projetos as $p ) :
            get_template_part( 'template-parts/card', 'projeto', array(
              'post' => $p,
              'terr' => $terr_por_id[ (int) athis_meta( $p->ID, 'territorio_id' ) ] ?? null,
            ) );
          endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum projeto cadastrado ainda. Use <strong>Projetos &gt; Adicionar</strong>.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- BIBLIOTECA (vem do tipo "Acervo"): bloco escuro recuado à esquerda, com telhado inclinado -->
  <section id="conhecimento" class="bloco library">
    <?php echo athis_casas_telhado(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
    <div class="container">
      <div class="sobe">
        <span class="tag"><?php echo esc_html( athis_texto( 'lib_tag' ) ); ?></span>
        <h2 class="section-title"><?php echo esc_html( athis_texto( 'lib_titulo' ) ); ?></h2>
        <p class="section-sub"><?php echo esc_html( athis_texto( 'lib_sub' ) ); ?></p>
      </div>

      <div class="filter-bar" id="lib-filters">
        <button class="filter-btn lib-filter-btn active" data-filter="all">Todos</button>
        <?php foreach ( $territorios as $t ) : ?>
          <button class="filter-btn lib-filter-btn <?php echo esc_attr( athis_cor_classe( $t ) ); ?>" data-filter="<?php echo esc_attr( $t->post_name ); ?>"><?php echo esc_html( get_the_title( $t ) ); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="lib-grid" id="lib-grid">
        <?php if ( $acervo ) : ?>
          <?php foreach ( $acervo as $a ) :
            get_template_part( 'template-parts/card', 'acervo', array(
              'post' => $a,
              'terr' => $terr_por_id[ (int) athis_meta( $a->ID, 'territorio_id' ) ] ?? null,
            ) );
          endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum item no acervo ainda. Use <strong>Acervo &gt; Adicionar</strong>.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
