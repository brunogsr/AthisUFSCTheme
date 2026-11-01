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

define( 'ATHIS_VERSION', '0.3' );
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
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'athis-style', get_stylesheet_uri(), array( 'athis-fonte-inter' ), ATHIS_VERSION );
	wp_enqueue_script( 'athis-filtros', get_template_directory_uri() . '/assets/js/filters.js', array(), ATHIS_VERSION, true );
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
				'visual'      => array( 'label' => 'Cor do card', 'type' => 'select', 'options' => array( 'azul' => 'Azul', 'cinza' => 'Cinza escuro' ) ),
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
				$valor = absint( $bruto );
				break;
			case 'number':
				$valor = ( '' === $bruto ) ? '' : max( $campo['min'], min( $campo['max'], absint( $bruto ) ) );
				break;
			case 'url':
				$valor = esc_url_raw( $bruto );
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

/* Atualiza as URLs dos tipos de conteúdo quando a versão do tema muda */
add_action( 'init', function () {
	if ( get_option( 'athis_rewrite_version' ) !== ATHIS_VERSION ) {
		flush_rewrite_rules();
		update_option( 'athis_rewrite_version', ATHIS_VERSION );
	}
}, 99 );

/* Dados de exemplo para a apresentação */
require_once get_template_directory() . '/inc/demo-data.php';