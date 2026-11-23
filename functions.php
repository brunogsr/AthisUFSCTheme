<?php
/**
 * Tema ATHIS UFSC - configuração principal.
 *
 * - Registra os tipos de conteúdo (Território, Projeto, Acervo)
 * - Cria os campos de cada tipo, com regras (limite de caracteres, valores permitidos)
 * - Carrega CSS, fonte e o script de filtros
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ATHIS_VERSION', '0.8' );
define( 'ATHIS_LIMITE_PDF_MB', 50 );

/* ------------------------------------------------------------------
 * Configuração básica do tema
 * ---------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'principal' => 'Menu principal' ) );
	set_post_thumbnail_size( 1000, 600, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'athis-fonte-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'athis-style', get_stylesheet_uri(), array( 'athis-fonte-inter' ), ATHIS_VERSION );
	wp_enqueue_script( 'athis-filtros', get_template_directory_uri() . '/assets/js/filters.js', array(), ATHIS_VERSION, true );
	wp_enqueue_script( 'athis-acessibilidade', get_template_directory_uri() . '/assets/js/acessibilidade.js', array(), ATHIS_VERSION, true );
	wp_enqueue_script( 'athis-carrossel', get_template_directory_uri() . '/assets/js/carrossel.js', array(), ATHIS_VERSION, true );
	wp_enqueue_script( 'athis-construcao', get_template_directory_uri() . '/assets/js/construcao.js', array(), ATHIS_VERSION, true );
} );

/* ------------------------------------------------------------------
 * Tipos de conteúdo
 * ---------------------------------------------------------------- */
add_action( 'init', function () {
	$comuns = array(
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => true,
	);

	register_post_type( 'territorio', array_merge( $comuns, array(
		'labels'     => array(
			'name'          => 'Territórios',
			'singular_name' => 'Território',
			'add_new_item'  => 'Adicionar território',
			'edit_item'     => 'Editar território',
			'all_items'     => 'Todos os territórios',
		),
		'menu_icon'  => 'dashicons-location-alt',
		'supports'   => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'    => array( 'slug' => 'territorios' ),
	) ) );

	register_post_type( 'projeto', array_merge( $comuns, array(
		'labels'     => array(
			'name'          => 'Projetos',
			'singular_name' => 'Projeto',
			'add_new_item'  => 'Adicionar projeto',
			'edit_item'     => 'Editar projeto',
			'all_items'     => 'Todos os projetos',
		),
		'menu_icon'  => 'dashicons-hammer',
		'supports'   => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'    => array( 'slug' => 'projetos' ),
	) ) );

	register_post_type( 'acervo', array_merge( $comuns, array(
		'labels'     => array(
			'name'          => 'Acervo',
			'singular_name' => 'Item do acervo',
			'add_new_item'  => 'Adicionar item ao acervo',
			'edit_item'     => 'Editar item do acervo',
			'all_items'     => 'Todo o acervo',
		),
		'menu_icon'  => 'dashicons-book-alt',
		'supports'   => array( 'title', 'excerpt' ),
		'rewrite'    => array( 'slug' => 'acervo' ),
	) ) );
} );

/* ------------------------------------------------------------------
 * Definição dos campos de cada tipo
 *
 * type:      text | number | select | territorio | url
 * maxlength: limite de caracteres (aplicado no formulário e no servidor)
 * options:   valores permitidos, para select
 * ---------------------------------------------------------------- */
function athis_campos() {
	return array(
		'territorio' => array(
			'titulo' => 'Dados do território',
			'campos' => array(
				'localidade'  => array( 'label' => 'Cidade / UF', 'type' => 'text', 'maxlength' => 40, 'help' => 'Ex.: Palhoça / SC' ),
				'destaque_1'  => array( 'label' => 'Destaque 1', 'type' => 'text', 'maxlength' => 30, 'help' => 'Ex.: 12 mil habitantes' ),
				'destaque_2'  => array( 'label' => 'Destaque 2', 'type' => 'text', 'maxlength' => 30, 'help' => 'Ex.: 75 hectares' ),
				'texto_botao' => array( 'label' => 'Texto do botão', 'type' => 'text', 'maxlength' => 50, 'help' => 'Ex.: Explorar território' ),
				'visual'      => array( 'label' => 'Cor do território', 'type' => 'select', 'options' => array( '' => 'Automática (segue as cores do logo)', 'azul' => 'Azul', 'amarelo' => 'Amarelo', 'vermelho' => 'Vermelho', 'verde' => 'Verde' ), 'help' => 'É a cor da "casa" deste território no site (como no logo). Em "Automática", cada território novo recebe a próxima cor da sequência (azul, amarelo, vermelho, verde) e as cores não se repetem. Escolha uma cor só se quiser fixá-la.' ),
				'titulo_texto' => array( 'label' => 'Título do texto', 'type' => 'text', 'maxlength' => 40, 'help' => 'Título acima do texto do território (ex.: Sobre o território). Deixe em branco para não mostrar título.' ),
			),
		),
		'projeto'    => array(
			'titulo' => 'Dados do projeto',
			'campos' => array(
				'territorio_id' => array( 'label' => 'Território', 'type' => 'territorio' ),
				'status'        => array( 'label' => 'Status', 'type' => 'select', 'options' => array(
					'Diagnóstico'  => 'Diagnóstico',
					'Projeto'      => 'Projeto',
					'Em andamento' => 'Em andamento',
					'Obra'         => 'Obra',
					'Concluído'    => 'Concluído',
					'Pesquisa'     => 'Pesquisa',
				) ),
				'texto_link'    => array( 'label' => 'Texto do link', 'type' => 'text', 'maxlength' => 40, 'help' => 'Ex.: Ver projeto completo' ),
			),
		),
		'acervo'     => array(
			'titulo' => 'Dados do item do acervo',
			'campos' => array(
				'territorio_id' => array( 'label' => 'Território', 'type' => 'territorio' ),
				'projeto_id'    => array( 'label' => 'Projeto relacionado', 'type' => 'projeto', 'help' => 'Opcional. Se escolhido, o item também aparece na página desse projeto.' ),
				'tipo'          => array( 'label' => 'Tipo', 'type' => 'select', 'options' => array(
					'TCC'       => 'TCC',
					'Pesquisa'  => 'Pesquisa',
					'Cartilha'  => 'Cartilha',
					'Relatório' => 'Relatório',
					'Vídeo'     => 'Vídeo',
					'Notícia'   => 'Notícia',
				) ),
				'ano'           => array( 'label' => 'Ano', 'type' => 'number', 'min' => 1990, 'max' => 2100 ),
				'autoria'       => array( 'label' => 'Autoria', 'type' => 'text', 'maxlength' => 80 ),
				'orientacao'    => array( 'label' => 'Orientação', 'type' => 'text', 'maxlength' => 80 ),
				'arquivo_id'    => array( 'label' => 'Arquivo PDF', 'type' => 'pdf', 'help' => 'Envie ou escolha um PDF de até ' . ATHIS_LIMITE_PDF_MB . ' MB. Sem PDF, o card mostra "PDF indisponível".' ),
			),
		),
	);
}

/* Lista de territórios para os selects de relacionamento */
function athis_lista_territorios() {
	return get_posts( array(
		'post_type'      => 'territorio',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
	) );
}

/* Lista de projetos para o campo "Projeto relacionado" */
function athis_lista_projetos() {
	return get_posts( array(
		'post_type'      => 'projeto',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
	) );
}

/* Lê um campo do post */
function athis_meta( $post_id, $chave, $padrao = '' ) {
	$valor = get_post_meta( $post_id, '_athis_' . $chave, true );
	return ( '' === $valor || false === $valor ) ? $padrao : $valor;
}

/* ------------------------------------------------------------------
 * Caixas de campos no editor
 * ---------------------------------------------------------------- */
add_action( 'add_meta_boxes', function () {
	foreach ( athis_campos() as $tipo => $config ) {
		add_meta_box( 'athis_' . $tipo, $config['titulo'], 'athis_render_metabox', $tipo, 'normal', 'high' );
	}
} );

function athis_render_metabox( $post ) {
	$todos  = athis_campos();
	$config = $todos[ $post->post_type ] ?? null;
	if ( ! $config ) {
		return;
	}
	wp_nonce_field( 'athis_salvar', 'athis_nonce' );

	echo '<table class="form-table" role="presentation">';
	foreach ( $config['campos'] as $chave => $campo ) {
		$valor = athis_meta( $post->ID, $chave );
		$nome  = 'athis_' . $chave;

		echo '<tr><th scope="row"><label for="' . esc_attr( $nome ) . '">' . esc_html( $campo['label'] ) . '</label></th><td>';

		switch ( $campo['type'] ) {
			case 'select':
				echo '<select name="' . esc_attr( $nome ) . '" id="' . esc_attr( $nome ) . '">';
				foreach ( $campo['options'] as $val => $rotulo ) {
					printf( '<option value="%s"%s>%s</option>', esc_attr( $val ), selected( $valor, $val, false ), esc_html( $rotulo ) );
				}
				echo '</select>';
				break;

			case 'territorio':
				echo '<select name="' . esc_attr( $nome ) . '" id="' . esc_attr( $nome ) . '" required>';
				echo '<option value="">— escolha —</option>';
				foreach ( athis_lista_territorios() as $t ) {
					printf( '<option value="%d"%s>%s</option>', $t->ID, selected( (int) $valor, $t->ID, false ), esc_html( $t->post_title ) );
				}
				echo '</select>';
				break;

			case 'projeto':
				echo '<select name="' . esc_attr( $nome ) . '" id="' . esc_attr( $nome ) . '">';
				echo '<option value="">— nenhum —</option>';
				foreach ( athis_lista_projetos() as $pj ) {
					$tid_pj = absint( athis_meta( $pj->ID, 'territorio_id' ) );
					$rotulo = $pj->post_title . ( $tid_pj ? ' (' . get_the_title( $tid_pj ) . ')' : '' );
					printf( '<option value="%d"%s>%s</option>', $pj->ID, selected( (int) $valor, $pj->ID, false ), esc_html( $rotulo ) );
				}
				echo '</select>';
				break;

			case 'number':
				printf(
					'<input type="number" class="small-text" name="%s" id="%s" value="%s" min="%d" max="%d">',
					esc_attr( $nome ), esc_attr( $nome ), esc_attr( $valor ), (int) $campo['min'], (int) $campo['max']
				);
				break;

			case 'url':
				printf( '<input type="url" class="large-text" name="%s" id="%s" value="%s">', esc_attr( $nome ), esc_attr( $nome ), esc_url( $valor ) );
				break;

			case 'pdf':
				$id_pdf   = absint( $valor );
				$nome_pdf = ( $id_pdf && 'application/pdf' === get_post_mime_type( $id_pdf ) ) ? wp_basename( get_attached_file( $id_pdf ) ) : '';
				echo '<div class="athis-pdf">';
				printf( '<input type="hidden" name="%s" id="%s" value="%s">', esc_attr( $nome ), esc_attr( $nome ), $nome_pdf ? $id_pdf : '' );
				echo '<button type="button" class="button athis-pdf-escolher">Escolher ou enviar PDF</button> ';
				echo '<span class="athis-pdf-nome">' . esc_html( $nome_pdf ? $nome_pdf : 'Nenhum arquivo selecionado' ) . '</span> ';
				echo '<a href="#" class="athis-pdf-remover" style="display:none">Remover</a>';
				echo '</div>';
				break;

			default: // text
				printf(
					'<input type="text" class="regular-text" name="%s" id="%s" value="%s" maxlength="%d">',
					esc_attr( $nome ), esc_attr( $nome ), esc_attr( $valor ), (int) $campo['maxlength']
				);
				echo ' <span class="description">máx. ' . (int) $campo['maxlength'] . ' caracteres</span>';
		}

		if ( ! empty( $campo['help'] ) ) {
			echo '<p class="description">' . esc_html( $campo['help'] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

/* Salva e valida os campos (as regras também valem no servidor) */
add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['athis_nonce'] ) || ! wp_verify_nonce( $_POST['athis_nonce'], 'athis_salvar' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$todos  = athis_campos();
	$config = $todos[ get_post_type( $post_id ) ] ?? null;
	if ( ! $config ) {
		return;
	}

	foreach ( $config['campos'] as $chave => $campo ) {
		$bruto = isset( $_POST[ 'athis_' . $chave ] ) ? wp_unslash( $_POST[ 'athis_' . $chave ] ) : '';

		switch ( $campo['type'] ) {
			case 'select':
				$valor = array_key_exists( $bruto, $campo['options'] ) ? $bruto : '';
				break;
			case 'territorio':
				// Só aceita o ID de um território de verdade (vazio se inválido)
				$valor = absint( $bruto );
				if ( ! $valor || 'territorio' !== get_post_type( $valor ) ) {
					$valor = '';
				}
				break;
			case 'number':
				$valor = ( '' === $bruto ) ? '' : max( $campo['min'], min( $campo['max'], absint( $bruto ) ) );
				break;
			case 'url':
				$valor = esc_url_raw( $bruto );
				break;
			case 'projeto':
				// Opcional: vazio se não escolheu ou se o ID não for de um projeto
				$valor = absint( $bruto );
				if ( ! $valor || 'projeto' !== get_post_type( $valor ) ) {
					$valor = '';
				}
				break;
			case 'pdf':
				$valor = absint( $bruto );
				if ( $valor && 'application/pdf' !== get_post_mime_type( $valor ) ) {
					$valor = '';
				}
				break;
			default:
				$valor = sanitize_text_field( $bruto );
				$valor = mb_substr( $valor, 0, (int) $campo['maxlength'] );
		}
		update_post_meta( $post_id, '_athis_' . $chave, $valor );
	}
} );
/* ------------------------------------------------------------------
 * Regras de upload (limite de tamanho)
 * ---------------------------------------------------------------- */
add_filter( 'wp_handle_upload_prefilter', function ( $file ) {
	$limite_mb = 2;
	if ( 0 === strpos( $file['type'], 'image/' ) && $file['size'] > $limite_mb * 1024 * 1024 ) {
		$file['error'] = 'Imagens podem ter no máximo ' . $limite_mb . ' MB. Reduza o arquivo e envie novamente.';
	}
	if ( 'application/pdf' === $file['type'] && $file['size'] > ATHIS_LIMITE_PDF_MB * 1024 * 1024 ) {
		$file['error'] = 'PDFs podem ter no máximo ' . ATHIS_LIMITE_PDF_MB . ' MB. Comprima o arquivo e envie novamente.';
	}
	return $file;
} );

/* Faz a biblioteca de mídia mostrar o mesmo limite do tema */
add_filter( 'upload_size_limit', function ( $tamanho ) {
	return min( $tamanho, ATHIS_LIMITE_PDF_MB * 1024 * 1024 );
} );

/* ------------------------------------------------------------------
 * Funções de apoio para os templates
 * ---------------------------------------------------------------- */
/* Endereço da imagem do post: destaque, ou o link de exemplo dos dados de demonstração */
function athis_imagem_url( $post_id, $tamanho = 'large' ) {
	$url = get_the_post_thumbnail_url( $post_id, $tamanho );
	if ( ! $url ) {
		$url = get_post_meta( $post_id, '_athis_img_exemplo', true );
	}
	return $url ? $url : '';
}

/* Sequência automática de cores dos territórios, na ordem de cadastro. Segue as cores do logo:
   o primeiro é azul, o segundo amarelo, o terceiro vermelho, o quarto verde, e a sequência recomeça. */
function athis_cores_sequencia() {
	return array( 'azul', 'amarelo', 'vermelho', 'verde' );
}

/* Posição (0, 1, 2...) do território entre os territórios publicados, na mesma ordem usada na Home. */
function athis_posicao_territorio( $id ) {
	static $ordem = null;
	if ( null === $ordem ) {
		$ordem = array_map( 'intval', get_posts( array(
			'post_type'      => 'territorio',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'fields'         => 'ids',
		) ) );
	}
	$pos = array_search( (int) $id, $ordem, true );
	return ( false === $pos ) ? 0 : (int) $pos;
}

/* Classe de cor do território (cor-vermelho, cor-azul, cor-verde ou cor-amarelo).
   Se o campo "Cor do território" foi escolhido, vale a escolha. Se estiver em "Automática"
   (ou com um valor antigo/inválido), usa a sequência do logo, para as cores não se repetirem.
   Sem território, usa azul. */
function athis_cor_classe( $terr ) {
	$id = is_object( $terr ) ? (int) $terr->ID : absint( $terr );
	if ( ! $id ) {
		return 'cor-azul';
	}
	$cores = athis_cores_sequencia();
	$cor   = get_post_meta( $id, '_athis_visual', true );
	if ( ! in_array( $cor, $cores, true ) ) {
		$cor = $cores[ athis_posicao_territorio( $id ) % count( $cores ) ];
	}
	return 'cor-' . $cor;
}

/* As casas do logo, em SVG (cada casa é uma peça; janelas e portas são vazadas).
   c1..c6 permitem animar uma a uma pelo CSS. */
function athis_casas_svg( $classe = '' ) {
	$casas = array(
		array( 'c1 casa-vermelho', 'M251 0 L481 2 L481 216 L250 214 Z M390 65 L445 66 L445 117 L390 115 Z' ),
		array( 'c2 casa-azul',     'M0 237 L231 202 L231 432 L0 432 Z M119 276 L174 275 L174 326 L119 326 Z' ),
		array( 'c3 casa-verde',    'M299 222 L527 221 L529 435 L300 436 Z M335 281 L390 280 L390 331 L335 331 Z' ),
		array( 'c4 casa-vermelho', 'M22 442 L253 438 L253 653 L204 653 L204 537 L149 536 L149 653 L23 653 Z' ),
		array( 'c5 casa-amarelo',  'M278 438 L510 440 L508 654 L364 653 L364 537 L309 536 L309 653 L278 653 Z' ),
		array( 'c6 casa-azul',     'M542 424 L773 459 L773 655 L542 655 Z M599 504 L654 504 L654 555 L599 555 Z' ),
	);
	$svg = '<svg class="athis-casas ' . esc_attr( $classe ) . '" viewBox="0 0 773 655" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">';
	foreach ( $casas as $c ) {
		$svg .= '<path class="casa ' . esc_attr( $c[0] ) . '" fill-rule="evenodd" d="' . esc_attr( $c[1] ) . '"/>';
	}
	return $svg . '</svg>';
}

/* Uma única casa do logo (n = 1 a 6), para "atravessar" a divisa entre duas seções.
   As casas são as mesmas de athis_casas_svg(); aqui cada uma tem o seu próprio recorte (viewBox). */
function athis_casa_peca( $n, $classe = '', $estilo = '' ) {
	$pecas = array(
		1 => array( '250 0 232 217',   'M251 0 L481 2 L481 216 L250 214 Z M390 65 L445 66 L445 117 L390 115 Z', '#FF0000' ),
		2 => array( '0 200 232 234',   'M0 237 L231 202 L231 432 L0 432 Z M119 276 L174 275 L174 326 L119 326 Z', '#0096FF' ),
		3 => array( '298 220 232 218', 'M299 222 L527 221 L529 435 L300 436 Z M335 281 L390 280 L390 331 L335 331 Z', '#00D200' ),
		4 => array( '22 436 232 219',  'M22 442 L253 438 L253 653 L204 653 L204 537 L149 536 L149 653 L23 653 Z', '#FF0000' ),
		5 => array( '277 436 234 220', 'M278 438 L510 440 L508 654 L364 653 L364 537 L309 536 L309 653 L278 653 Z', '#F5C800' ),
		6 => array( '541 423 233 234', 'M542 424 L773 459 L773 655 L542 655 Z M599 504 L654 504 L654 555 L599 555 Z', '#0096FF' ),
	);
	if ( ! isset( $pecas[ $n ] ) ) {
		return '';
	}
	list( $caixa, $d, $cor ) = $pecas[ $n ];
	return '<svg class="atravessa ' . esc_attr( $classe ) . '"' . ( $estilo ? ' style="' . esc_attr( $estilo ) . '"' : '' ) . ' viewBox="' . esc_attr( $caixa ) . '" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path fill="' . esc_attr( $cor ) . '" fill-rule="evenodd" d="' . esc_attr( $d ) . '"/></svg>';
}

/* A "vila" sobre o telhado da Biblioteca: casas do logo de tamanhos diferentes, apoiadas na linha do telhado.
   Cada casa: peça do logo (1 a 6), posição (x, em % da largura da tela), largura (em % da largura) e se é "extra"
   (as extras somem no celular, onde só a casa vermelha fica). A altura vem da proporção de cada peça. */
function athis_casas_telhado() {
	$razao = array( 1 => 0.935, 2 => 1.009, 3 => 0.94, 4 => 0.944, 5 => 0.94, 6 => 1.004 );
	$vila  = array(
		array( 2, 1.4, 4.4, true ),    // azul, pequena
		array( 5, 5.4, 7.6, true ),    // amarela, grande
		array( 4, 14.2, 6.2, false ),  // vermelha (a casa original), média
		array( 3, 21.0, 4.2, true ),   // verde, pequena
		array( 6, 25.0, 8.2, true ),   // azul, grande
		array( 5, 82.5, 5.6, true ),   // amarela, na parte direita
		array( 1, 88.4, 7.4, true ),   // vermelha, na parte direita
	);
	$html = '';
	foreach ( $vila as $c ) {
		$html .= athis_casa_peca(
			$c[0],
			'teto' . ( $c[3] ? ' teto-extra' : '' ),
			sprintf( '--x:%s;--pw:%s;--r:%s', $c[1], $c[2], $razao[ $c[0] ] )
		);
	}
	return $html;
}

/* A casa do território, na cor dele. O formato muda conforme a cor, como as casas do logo:
   azul = telhado de uma água, vermelho = empena com janela redonda, verde = arco, amarelo = escada.
   Recebe a classe de cor (resultado de athis_cor_classe). */
function athis_casa_svg( $cor = 'cor-azul' ) {
	$formas = array(
		'cor-azul'     => 'M20 70 L200 34 L200 270 L92 270 L92 206 L52 206 L52 270 L20 270 Z M118 118 L168 118 L168 168 L118 168 Z',
		'cor-vermelho' => 'M20 270 V96 L110 24 L200 96 V270 H134 V206 H86 V270 Z M84 120 a26 26 0 1 0 52 0 a26 26 0 1 0 -52 0 Z',
		'cor-verde'    => 'M20 270 V120 A90 90 0 0 1 200 120 V270 H132 V208 A22 22 0 0 0 88 208 V270 Z M90 100 H130 V140 H90 Z',
		'cor-amarelo'  => 'M20 270 V160 H78 V98 H138 V34 H200 V270 H132 V208 H88 V270 Z M150 80 H182 V112 H150 Z',
	);
	$d = $formas[ $cor ] ?? $formas['cor-azul'];
	return '<svg class="terr-casa-svg" viewBox="0 0 240 270" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path class="casa" fill-rule="evenodd" d="' . esc_attr( $d ) . '"/></svg>';
}

/* Atributo style com a imagem de fundo (vazio se não houver imagem) */
function athis_bg_style( $url ) {
	return $url ? ' style="background-image:url(\'' . esc_url( $url ) . '\')"' : '';
}

/* Endereço do PDF do item: arquivo enviado ou, em dados antigos, o link colado */
function athis_pdf_url( $post_id ) {
	$id = absint( athis_meta( $post_id, 'arquivo_id' ) );
	if ( $id && 'application/pdf' === get_post_mime_type( $id ) ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			return $url;
		}
	}
	return athis_meta( $post_id, 'arquivo_url' );
}

/* Script do campo de PDF (só na tela de edição do Acervo) */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	$tela = get_current_screen();
	if ( ! $tela || 'acervo' !== $tela->post_type || ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'athis-admin-pdf', get_template_directory_uri() . '/assets/js/admin-pdf.js', array( 'jquery' ), ATHIS_VERSION, true );
} );

/* Ícone de download usado nos cards do acervo */
function athis_icone_download() {
	return '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>';
}

/* Projetos ou itens de acervo ligados a um território */
function athis_posts_do_territorio( $tipo, $territorio_id, $ordem = 'ASC' ) {
	return get_posts( array(
		'post_type'      => $tipo,
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => $ordem,
		'meta_key'       => '_athis_territorio_id',
		'meta_value'     => (int) $territorio_id,
	) );
}

/* Itens do acervo ligados a um projeto */
function athis_posts_do_projeto( $projeto_id ) {
	return get_posts( array(
		'post_type'      => 'acervo',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_key'       => '_athis_projeto_id',
		'meta_value'     => (int) $projeto_id,
	) );
}

/* Atualiza as URLs dos tipos de conteúdo quando a versão do tema muda */
add_action( 'init', function () {
	if ( get_option( 'athis_rewrite_version' ) !== ATHIS_VERSION ) {
		flush_rewrite_rules();
		update_option( 'athis_rewrite_version', ATHIS_VERSION );
	}
}, 99 );


/* Dados de exemplo para a apresentação */
require_once get_template_directory() . '/inc/demo-data.php';

/* Página de inscrições (links para formulários do Google) */
require_once get_template_directory() . '/inc/inscricoes.php';