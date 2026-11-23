<?php
/**
 * Página "Inscrições" (/inscricoes/).
 *
 * - A página é criada sozinha (uma vez) e usa o modelo page-inscricoes.php.
 * - Cada opção da página leva a um formulário do Google. Os links ficam em
 *   Configurações > Inscrições ATHIS, para quem edita o site colar sem mexer em código.
 * - Opção sem link aparece como "Em breve" (nada quebra).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* As opções da página. Para criar mais uma, basta acrescentar uma linha aqui
   (o campo para colar o link aparece sozinho no painel).
   ATENÇÃO: os títulos e textos abaixo são provisórios, a confirmar com a faculdade. */
function athis_inscricoes_opcoes() {
	return array(
		'voluntario' => array(
			'titulo' => 'Seja um voluntário',
			'texto'  => 'Quero colaborar com as ações do programa nos territórios.',
			'cor'    => 'cor-azul',
		),
		'bolsas'     => array(
			'titulo' => 'Edital de bolsas',
			'texto'  => 'Inscrição para as bolsas do programa ATHIS UFSC.',
			'cor'    => 'cor-amarelo',
		),
		'apoio'      => array(
			'titulo' => 'Apoie um projeto',
			'texto'  => 'Quero apoiar um projeto em andamento em um território.',
			'cor'    => 'cor-vermelho',
		),
		'comunidade' => array(
			'titulo' => 'Indique uma comunidade',
			'texto'  => 'Conheço uma comunidade que pode integrar a rede ATHIS UFSC.',
			'cor'    => 'cor-verde',
		),
	);
}

/* Link (formulário do Google) de uma opção; vazio se ainda não foi preenchido */
function athis_inscricao_url( $chave ) {
	$urls = get_option( 'athis_inscricoes_urls', array() );
	return ( is_array( $urls ) && ! empty( $urls[ $chave ] ) ) ? esc_url_raw( $urls[ $chave ] ) : '';
}

/* Endereço da página de inscrições (o botão do menu e do rodapé usam este) */
function athis_inscricoes_pagina_url() {
	return home_url( '/inscricoes/' );
}

/* Cria a página "Inscrições" se ainda não existir (roda antes do ajuste das regras de URL) */
add_action( 'init', function () {
	if ( get_option( 'athis_inscricoes_pagina_criada' ) ) {
		return;
	}
	if ( ! get_page_by_path( 'inscricoes' ) ) {
		wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Inscrições',
			'post_name'   => 'inscricoes',
		) );
	}
	update_option( 'athis_inscricoes_pagina_criada', '1' );
}, 98 );

/* Tela no painel: Configurações > Inscrições ATHIS */
add_action( 'admin_menu', function () {
	add_options_page( 'Inscrições ATHIS', 'Inscrições ATHIS', 'manage_options', 'athis-inscricoes', 'athis_inscricoes_tela' );
} );

add_action( 'admin_init', function () {
	register_setting( 'athis_inscricoes_grupo', 'athis_inscricoes_urls', array(
		'type'              => 'array',
		'sanitize_callback' => function ( $entrada ) {
			$limpo = array();
			foreach ( array_keys( athis_inscricoes_opcoes() ) as $chave ) {
				$limpo[ $chave ] = isset( $entrada[ $chave ] ) ? esc_url_raw( trim( $entrada[ $chave ] ), array( 'https' ) ) : '';
			}
			return $limpo;
		},
	) );
} );

function athis_inscricoes_tela() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>Inscrições ATHIS</h1>';
	echo '<p>Cole abaixo o link de cada formulário do Google. A página <a href="' . esc_url( athis_inscricoes_pagina_url() ) . '" target="_blank" rel="noopener">Inscrições</a> mostra uma opção para cada campo. Campo vazio aparece no site como "Em breve".</p>';
	echo '<form method="post" action="options.php">';
	settings_fields( 'athis_inscricoes_grupo' );
	echo '<table class="form-table" role="presentation">';
	foreach ( athis_inscricoes_opcoes() as $chave => $o ) {
		printf(
			'<tr><th scope="row"><label for="insc_%1$s">%2$s</label></th><td><input type="url" class="large-text" id="insc_%1$s" name="athis_inscricoes_urls[%1$s]" value="%3$s" placeholder="https://forms.gle/..."><p class="description">%4$s</p></td></tr>',
			esc_attr( $chave ),
			esc_html( $o['titulo'] ),
			esc_attr( athis_inscricao_url( $chave ) ),
			esc_html( $o['texto'] )
		);
	}
	echo '</table>';
	submit_button( 'Salvar links' );
	echo '</form></div>';
}
