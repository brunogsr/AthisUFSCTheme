<?php
/**
 * Textos fixos do site, editáveis em Configurações > Textos do site.
 *
 * - O que está escrito aqui é o texto padrão (o mesmo que o site já mostrava).
 * - Campo apagado/vazio no painel volta a mostrar o texto padrão (nada fica em branco por acidente).
 * - Nos modelos, use athis_texto( 'chave' ); para trocar um texto, edite só o painel.
 * - Para criar um texto novo: acrescente uma linha em athis_textos_campos() e use a chave no modelo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Lista dos textos: chave => array( grupo, rótulo, padrão, tipo ). Tipos: text, area, html (aceita <strong>, <em>) */
function athis_textos_campos() {
	return array(
		// Início: capa
		'hero_tag'    => array( 'Início: capa', 'Etiqueta acima do título', 'Laboratório / Guarda-Chuva Institucional ATHIS UFSC', 'text' ),
		'hero_l1'     => array( 'Início: capa', 'Título, primeira linha', 'Arquitetura que escuta.', 'text' ),
		'hero_l2a'    => array( 'Início: capa', 'Título, segunda linha', 'Territórios que', 'text' ),
		'hero_l2b'    => array( 'Início: capa', 'Título, palavra em destaque (cor)', 'transformam.', 'text' ),
		'hero_texto'  => array( 'Início: capa', 'Texto de apresentação', 'O <strong>Programa ATHIS UFSC</strong> é o guarda-chuva institucional que abriga e articula diferentes frentes e territórios populares em Santa Catarina, unindo pesquisa, extensão e impacto social real.', 'html' ),
		'hero_btn1'   => array( 'Início: capa', 'Botão 1', 'Explorar Territórios', 'text' ),
		'hero_btn2'   => array( 'Início: capa', 'Botão 2', 'Nossa Missão', 'text' ),

		// Início: conceito
		'con_tag'     => array( 'Início: conceito', 'Etiqueta', 'Conceito', 'text' ),
		'con_titulo'  => array( 'Início: conceito', 'Título', 'Muito além da construção', 'text' ),
		'con_sub'     => array( 'Início: conceito', 'Subtítulo', 'A Assessoria Técnica em Habitação de Interesse Social (ATHIS) é um direito e uma ferramenta de transformação socioespacial gerida pela UFSC.', 'area' ),
		'k1_titulo'   => array( 'Início: conceito', 'Card 1, título', 'Escuta Ativa', 'text' ),
		'k1_texto'    => array( 'Início: conceito', 'Card 1, texto', 'Processos participativos onde a comunidade é a protagonista das decisões sobre o seu próprio território.', 'area' ),
		'k2_titulo'   => array( 'Início: conceito', 'Card 2, título', 'Projetos Integrados', 'text' ),
		'k2_texto'    => array( 'Início: conceito', 'Card 2, texto', 'Da regularização fundiária ao projeto arquitetônico, atuamos de forma multidisciplinar sob um mesmo programa guarda-chuva.', 'area' ),
		'k3_titulo'   => array( 'Início: conceito', 'Card 3, título', 'Impacto Escalonável', 'text' ),
		'k3_texto'    => array( 'Início: conceito', 'Card 3, texto', 'Uma plataforma modular que permite integrar novos territórios e comunidades parceiras à rede ATHIS UFSC.', 'area' ),

		// Início: atlas
		'atlas_tag'    => array( 'Início: Atlas de Territórios', 'Etiqueta', 'O Guarda-Chuva ATHIS', 'text' ),
		'atlas_titulo' => array( 'Início: Atlas de Territórios', 'Título', 'Atlas de Territórios', 'text' ),
		'atlas_sub'    => array( 'Início: Atlas de Territórios', 'Subtítulo', 'Comunidades parceiras onde a UFSC desenvolve frentes de atuação e projetos integrados de longo prazo.', 'area' ),
		'atlas_exp_t'  => array( 'Início: Atlas de Territórios', 'Casa aberta, título', 'Estrutura Escalável', 'text' ),
		'atlas_exp_p'  => array( 'Início: Atlas de Territórios', 'Casa aberta, texto', 'O hub ATHIS UFSC foi desenhado para abraçar novas comunidades parceiras. Nossa rede está pronta para integrar, diagnosticar e atuar em futuros territórios catarinenses.', 'area' ),

		// Início: ecossistema
		'eco_titulo'  => array( 'Início: Ecossistema', 'Título', 'Ecossistema ATHIS UFSC', 'text' ),
		'eco_sub'     => array( 'Início: Ecossistema', 'Subtítulo', 'Visualização do hub de projetos estruturados sob seus respectivos territórios.', 'area' ),
		'eco_legenda' => array( 'Início: Ecossistema', 'Legenda', 'Cada casa é um território e cada janela é um projeto: quanto mais projetos, mais alta a casa.', 'area' ),

		// Início: vitrine e biblioteca
		'vit_tag'     => array( 'Início: Vitrine e Biblioteca', 'Vitrine, etiqueta', 'Portfólio Ativo', 'text' ),
		'vit_titulo'  => array( 'Início: Vitrine e Biblioteca', 'Vitrine, título', 'Vitrine de Experiências', 'text' ),
		'vit_sub'     => array( 'Início: Vitrine e Biblioteca', 'Vitrine, subtítulo', 'Filtre as obras, diagnósticos e projetos por território de atuação.', 'area' ),
		'lib_tag'     => array( 'Início: Vitrine e Biblioteca', 'Biblioteca, etiqueta', 'Hub de Documentos', 'text' ),
		'lib_titulo'  => array( 'Início: Vitrine e Biblioteca', 'Biblioteca, título', 'Biblioteca Integrada', 'text' ),
		'lib_sub'     => array( 'Início: Vitrine e Biblioteca', 'Biblioteca, subtítulo', 'Acesse a produção acadêmica, diagnósticos e relatórios estruturados por território.', 'area' ),

		// Inscrições
		'insc_lead'   => array( 'Inscrições', 'Texto abaixo do título', 'Escolha como quer participar do ATHIS UFSC. Cada opção abre um formulário do Google em uma nova aba.', 'area' ),
		'insc_voluntario_titulo' => array( 'Inscrições', 'Opção azul, título', 'Seja um voluntário', 'text' ),
		'insc_voluntario_texto'  => array( 'Inscrições', 'Opção azul, texto', 'Quero colaborar com as ações do programa nos territórios.', 'area' ),
		'insc_bolsas_titulo'     => array( 'Inscrições', 'Opção amarela, título', 'Edital de bolsas', 'text' ),
		'insc_bolsas_texto'      => array( 'Inscrições', 'Opção amarela, texto', 'Inscrição para as bolsas do programa ATHIS UFSC.', 'area' ),
		'insc_apoio_titulo'      => array( 'Inscrições', 'Opção vermelha, título', 'Apoie um projeto', 'text' ),
		'insc_apoio_texto'       => array( 'Inscrições', 'Opção vermelha, texto', 'Quero apoiar um projeto em andamento em um território.', 'area' ),
		'insc_comunidade_titulo' => array( 'Inscrições', 'Opção verde, título', 'Indique uma comunidade', 'text' ),
		'insc_comunidade_texto'  => array( 'Inscrições', 'Opção verde, texto', 'Conheço uma comunidade que pode integrar a rede ATHIS UFSC.', 'area' ),

		// Rodapé
		'rod_desc'    => array( 'Rodapé', 'Descrição ao lado do logo', 'Plataforma Institucional em Arquitetura, Urbanismo e Assessoria Técnica. Universidade Federal de Santa Catarina.', 'area' ),
		'rod_email'   => array( 'Rodapé', 'E-mail de contato', 'athis@contato.ufsc.br', 'text' ),
		'rod_cidade'  => array( 'Rodapé', 'Cidade e país', 'Florianópolis, SC - Brasil', 'text' ),
	);
}

/* Devolve o texto (já editado ou o padrão). Sem escape: no modelo use esc_html( athis_texto( 'x' ) ) */
function athis_texto( $chave ) {
	$campos = athis_textos_campos();
	if ( ! isset( $campos[ $chave ] ) ) {
		return '';
	}
	$salvos = get_option( 'athis_textos', array() );
	$valor  = ( is_array( $salvos ) && isset( $salvos[ $chave ] ) ) ? trim( $salvos[ $chave ] ) : '';
	return '' !== $valor ? $valor : $campos[ $chave ][2];
}

/* Versão para campos "html": só permite <strong> e <em> */
function athis_texto_html( $chave ) {
	return wp_kses( athis_texto( $chave ), array( 'strong' => array(), 'em' => array() ) );
}

/* Tela no painel: Configurações > Textos do site */
add_action( 'admin_menu', function () {
	add_options_page( 'Textos do site', 'Textos do site', 'manage_options', 'athis-textos', 'athis_textos_tela' );
} );

add_action( 'admin_init', function () {
	register_setting( 'athis_textos_grupo', 'athis_textos', array(
		'type'              => 'array',
		'sanitize_callback' => function ( $entrada ) {
			$limpo = array();
			foreach ( athis_textos_campos() as $chave => $c ) {
				$v = isset( $entrada[ $chave ] ) ? ( is_string( $entrada[ $chave ] ) ? $entrada[ $chave ] : '' ) : '';
				if ( 'html' === $c[3] ) {
					$limpo[ $chave ] = wp_kses( $v, array( 'strong' => array(), 'em' => array() ) );
				} elseif ( 'area' === $c[3] ) {
					$limpo[ $chave ] = sanitize_textarea_field( $v );
				} else {
					$limpo[ $chave ] = sanitize_text_field( $v );
				}
			}
			return $limpo;
		},
	) );
} );

function athis_textos_tela() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>Textos do site</h1>';
	echo '<p>Edite os textos fixos do site. Campo vazio mostra o texto padrão. Nos textos longos, <code>&lt;strong&gt;</code> deixa em negrito.</p>';
	echo '<form method="post" action="options.php">';
	settings_fields( 'athis_textos_grupo' );

	$grupo_atual = '';
	foreach ( athis_textos_campos() as $chave => $c ) {
		if ( $c[0] !== $grupo_atual ) {
			if ( '' !== $grupo_atual ) {
				echo '</table>';
			}
			$grupo_atual = $c[0];
			echo '<h2>' . esc_html( $grupo_atual ) . '</h2><table class="form-table" role="presentation">';
		}
		$salvos = get_option( 'athis_textos', array() );
		$valor  = ( is_array( $salvos ) && isset( $salvos[ $chave ] ) ) ? $salvos[ $chave ] : '';
		printf( '<tr><th scope="row"><label for="txt_%1$s">%2$s</label></th><td>', esc_attr( $chave ), esc_html( $c[1] ) );
		if ( 'text' === $c[3] ) {
			printf( '<input type="text" class="large-text" id="txt_%1$s" name="athis_textos[%1$s]" value="%2$s" placeholder="%3$s">', esc_attr( $chave ), esc_attr( $valor ), esc_attr( $c[2] ) );
		} else {
			printf( '<textarea class="large-text" rows="3" id="txt_%1$s" name="athis_textos[%1$s]" placeholder="%3$s">%2$s</textarea>', esc_attr( $chave ), esc_textarea( $valor ), esc_attr( $c[2] ) );
		}
		echo '</td></tr>';
	}
	echo '</table>';
	submit_button( 'Salvar textos' );
	echo '</form></div>';
}
