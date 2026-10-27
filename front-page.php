<?php
/**
 * Página inicial.
 * Seções fixas: Hero, "O que é ATHIS", Expansão.
 * Seções dinâmicas (vêm dos tipos de conteúdo): Atlas, Ecossistema, Projetos, Acervo.
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
    <div class="container">
      <div class="hero-content">
        <div class="hero-tag">Laboratório / Guarda-Chuva Institucional ATHIS UFSC</div>
        <h1>Arquitetura que escuta.<br>Territórios que <span>transformam.</span></h1>
        <p>O <strong>Programa ATHIS UFSC</strong> é o guarda-chuva institucional que abriga e articula diferentes frentes e territórios populares em Santa Catarina, unindo pesquisa, extensão e impacto social real.</p>
        <div class="hero-btns">
          <a href="#territorios" class="btn btn-primary">Explorar Territórios</a>
          <a href="#sobre" class="btn btn-outline">Nossa Missão</a>
        </div>
      </div>
    </div>
  </header>

  <!-- O QUE É ATHIS -->
  <section id="sobre" class="about">
    <div class="container">
      <span class="tag">Conceito</span>
      <h2 class="section-title">Muito além da construção</h2>
      <p class="section-sub">A Assessoria Técnica em Habitação de Interesse Social (ATHIS) é um direito e uma ferramenta de transformação socioespacial gerida pela UFSC.</p>

      <div class="about-grid">
        <div class="about-card highlight">
          <div class="about-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>Escuta Ativa</h3>
          <p>Processos participativos onde a comunidade é a protagonista das decisões sobre o seu próprio território.</p>
        </div>
        <div class="about-card">
          <div class="about-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
          </div>
          <h3>Projetos Integrados</h3>
          <p>Da regularização fundiária ao projeto arquitetônico, atuamos de forma multidisciplinar sob um mesmo programa guarda-chuva.</p>
        </div>
        <div class="about-card">
          <div class="about-card-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          </div>
          <h3>Impacto Escalonável</h3>
          <p>Uma plataforma modular que permite integrar novos territórios e comunidades parceiras à rede ATHIS UFSC.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ATLAS DE TERRITÓRIOS (vem do tipo "Território") -->
  <section id="territorios" class="atlas">
    <div class="container">
      <span class="tag tag-blue">O Guarda-Chuva ATHIS</span>
      <h2 class="section-title">Atlas de Territórios</h2>
      <p class="section-sub">Comunidades parceiras onde a UFSC desenvolve frentes de atuação e projetos integrados de longo prazo.</p>

      <div class="atlas-grid">
        <?php if ( $territorios ) : ?>
          <?php foreach ( $territorios as $t ) :
            $img   = athis_imagem_url( $t->ID, 'large' );
            $alt   = ( 'cinza' === athis_meta( $t->ID, 'visual', 'azul' ) );
            $botao = athis_meta( $t->ID, 'texto_botao', 'Explorar território' );
            ?>
            <div class="atlas-card<?php echo $alt ? ' is-alt' : ''; ?>">
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
                <a class="btn btn-outline" href="<?php echo esc_url( get_permalink( $t ) ); ?>"><?php echo esc_html( $botao ); ?> →</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum território cadastrado ainda. Cadastre em <strong>Territórios &gt; Adicionar</strong> ou carregue exemplos em <a href="<?php echo esc_url( $demo_url ); ?>">Ferramentas &gt; Dados de exemplo ATHIS</a>.</div>
        <?php endif; ?>

        <!-- NOVOS TERRITÓRIOS (EXPANSÃO) -->
        <div class="atlas-expansion">
          <div style="font-size:2rem; margin-bottom:12px;">🌱</div>
          <h4>Estrutura Escalável</h4>
          <p>O hub ATHIS UFSC foi desenhado para abraçar novas comunidades parceiras. Nossa rede está pronta para integrar, diagnosticar e atuar em futuros territórios catarinenses.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ECOSSISTEMA (árvore: território > projetos) -->
  <section class="tree-section">
    <div class="container">
      <h2 class="section-title" style="text-align:center; font-size:2rem;">Ecossistema ATHIS UFSC</h2>
      <p class="section-sub" style="text-align:center; margin:0 auto 3rem;">Visualização do hub de projetos estruturados sob seus respectivos territórios.</p>

      <div class="tree-container">
        <div class="tree">
          <div class="tree-root">ATHIS UFSC (Plataforma Central)</div>

          <div class="tree-level-1">
            <?php foreach ( $territorios as $t ) : ?>
              <div class="tree-node">
                <div class="tree-territory">📍 <?php echo esc_html( get_the_title( $t ) ); ?></div>
                <div class="tree-projects">
                  <?php foreach ( $projetos as $p ) :
                    if ( (int) athis_meta( $p->ID, 'territorio_id' ) !== $t->ID ) {
                      continue;
                    } ?>
                    <div class="tree-project">
                      <a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a>
                      <span><?php echo esc_html( athis_meta( $p->ID, 'status' ) ); ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VITRINE DE EXPERIÊNCIAS (vem do tipo "Projeto") -->
  <section id="experiencias" class="experiences">
    <div class="container">
      <span class="tag">Portfólio Ativo</span>
      <h2 class="section-title">Vitrine de Experiências</h2>
      <p class="section-sub">Filtre as obras, diagnósticos e projetos por território de atuação.</p>

      <div class="filter-bar" id="exp-filters">
        <button class="filter-btn active" data-filter="all">Todos os Territórios</button>
        <?php foreach ( $territorios as $t ) : ?>
          <button class="filter-btn" data-filter="<?php echo esc_attr( $t->post_name ); ?>"><?php echo esc_html( get_the_title( $t ) ); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="exp-grid" id="exp-grid">
        <?php if ( $projetos ) : ?>
          <?php foreach ( $projetos as $p ) :
            $terr   = $terr_por_id[ (int) athis_meta( $p->ID, 'territorio_id' ) ] ?? null;
            $img    = athis_imagem_url( $p->ID, 'large' );
            $status = athis_meta( $p->ID, 'status' );
            $alt    = $terr && ( 'cinza' === athis_meta( $terr->ID, 'visual', 'azul' ) );
            ?>
            <a class="exp-card" href="<?php echo esc_url( get_permalink( $p ) ); ?>" data-terr="<?php echo esc_attr( $terr ? $terr->post_name : '' ); ?>">
              <div class="exp-img<?php echo $img ? '' : ' no-img'; ?>"<?php echo athis_bg_style( $img ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
                <?php if ( $terr ) : ?>
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
          <?php endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum projeto cadastrado ainda. Use <strong>Projetos &gt; Adicionar</strong>.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- BIBLIOTECA (vem do tipo "Acervo") -->
  <section id="conhecimento" class="library">
    <div class="container">
      <span class="tag" style="background:rgba(255,255,255,0.1); color:var(--white); border:1px solid rgba(255,255,255,0.3);">Hub de Documentos</span>
      <h2 class="section-title">Biblioteca Integrada</h2>
      <p class="section-sub">Acesse a produção acadêmica, diagnósticos e relatórios estruturados por território.</p>

      <div class="filter-bar" id="lib-filters">
        <button class="filter-btn lib-filter-btn active" data-filter="all">Todos</button>
        <?php foreach ( $territorios as $t ) : ?>
          <button class="filter-btn lib-filter-btn" data-filter="<?php echo esc_attr( $t->post_name ); ?>"><?php echo esc_html( get_the_title( $t ) ); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="lib-grid" id="lib-grid">
        <?php if ( $acervo ) : ?>
          <?php foreach ( $acervo as $a ) :
            $terr    = $terr_por_id[ (int) athis_meta( $a->ID, 'territorio_id' ) ] ?? null;
            $tipo    = athis_meta( $a->ID, 'tipo' );
            $ano     = athis_meta( $a->ID, 'ano' );
            $autoria = athis_meta( $a->ID, 'autoria' );
            $orient  = athis_meta( $a->ID, 'orientacao' );
            $arquivo = athis_meta( $a->ID, 'arquivo_url' );

            if ( $autoria ) {
              $resumo = 'Autoria: ' . $autoria . ( $orient ? '. Orientação: ' . $orient . '.' : '.' );
            } else {
              $resumo = get_the_excerpt( $a );
            }
            ?>
            <div class="lib-card" data-terr="<?php echo esc_attr( $terr ? $terr->post_name : '' ); ?>">
              <?php if ( $terr ) : ?>
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
          <?php endforeach; ?>
        <?php elseif ( current_user_can( 'manage_options' ) ) : ?>
          <div class="empty-note">Nenhum item no acervo ainda. Use <strong>Acervo &gt; Adicionar</strong>.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
