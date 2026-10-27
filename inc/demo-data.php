<?php
/**
 * Dados de exemplo para a apresentação do esboço.
 *
 * Em Ferramentas > "Dados de exemplo ATHIS" há dois botões:
 *  - Carregar: cria 2 territórios, 5 projetos e 4 itens de acervo (baseados no protótipo)
 *  - Apagar: remove somente o que foi criado por este carregamento
 *
 * Os nomes de autores, números e imagens são fictícios/ilustrativos e
 * devem ser substituídos por dados reais antes de ir ao ar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function athis_unsplash( $id, $w = 1000 ) {
	return 'https://images.unsplash.com/' . $id . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=' . $w . '&q=80';
}

function athis_demo_dados() {
	return array(
		'territorios' => array(
			array(
				'slug'    => 'frei-damiao',
				'titulo'  => 'Comunidade Frei Damião',
				'resumo'  => 'Um território vibrante focado em regularização urbana, infraestrutura, desenvolvimento de galpões comunitários e requalificação da escola local.',
				'img'     => athis_unsplash( 'photo-1480714378408-67cf0d13bc1b' ),
				'meta'    => array(
					'localidade'  => 'Palhoça / SC',
					'destaque_1'  => '👥 12 mil habitantes',
					'destaque_2'  => '🗺️ 75 hectares',
					'texto_botao' => 'Explorar território e frentes',
					'visual'      => 'azul',
				),
			),
			array(
				'slug'    => 'vidal-martins',
				'titulo'  => 'Quilombo Vidal Martins',
				'resumo'  => 'Território ancestral em mediação de conflito socioambiental com o Parque Estadual do Rio Vermelho. Foco em arquitetura vernacular e cartografia social.',
				'img'     => athis_unsplash( 'photo-1544385561-5742eb55d040' ),
				'meta'    => array(
					'localidade'  => 'Florianópolis / SC',
					'destaque_1'  => '👥 31 famílias',
					'destaque_2'  => '🌳 Proteção Ambiental',
					'texto_botao' => 'Explorar território e projetos',
					'visual'      => 'cinza',
				),
			),
		),
		'projetos'    => array(
			array( 'Escola Comunitária Frei Damião', 'Reforma emergencial e ampliação dos espaços pedagógicos utilizando técnicas construtivas mistas.', 'frei-damiao', 'Concluído', 'Ver projeto completo', 'photo-1577495508048-b635879837f1' ),
			array( 'Cartografia Social e Territorial', 'Mapeamento colaborativo identificando os limites ancestrais e zonas de uso comunitário sobrepostas ao parque.', 'vidal-martins', 'Diagnóstico', 'Acompanhar projeto', 'photo-1518531933037-91b2f5f229cc' ),
			array( 'Galpão Semente', 'Projeto participativo de um centro de triagem e geração de renda para a cooperativa local de reciclagem.', 'frei-damiao', 'Em andamento', 'Acompanhar obras', 'photo-1600585154340-be6161a56a0c' ),
			array( 'Habitação Sustentável', 'Diretrizes construtivas usando arquitetura de terra e madeira, respeitando as normas ambientais da região.', 'vidal-martins', 'Em andamento', 'Ver pranchas', 'photo-1498064434914-1e5b18fb2046' ),
			array( 'Rua Antônio de Souza', 'Projeto de urbanização e saneamento ecológico focado na mitigação de riscos de enchente no bairro.', 'frei-damiao', 'Em andamento', 'Acompanhar projeto', 'photo-1513694203232-719a280e022f' ),
		),
		'acervo'      => array(
			array( 'Infraestrutura Verde em Assentamentos Informais', '', 'frei-damiao', 'TCC', 2025, 'Maria Eduarda Silva (exemplo)', 'Prof. Dr. João Pedro (exemplo)' ),
			array( 'Relatório Antropológico RTID INCRA/UFSC', 'Identificação e delimitação do território tradicional quilombola.', 'vidal-martins', 'Pesquisa', 2024, '', '' ),
			array( 'Guia de Saneamento Ecológico Básico', 'Material gráfico distribuído nas oficinas da comunidade.', 'frei-damiao', 'Cartilha', 2024, '', '' ),
			array( 'Ensaio Projetual Vidal Martins', 'Alternativas de moradia de baixo impacto ambiental no Rio Vermelho.', 'vidal-martins', 'TCC', 2025, '', '' ),
		),
	);
}

/* Página em Ferramentas */
add_action( 'admin_menu', function () {
	add_management_page( 'Dados de exemplo ATHIS', 'Dados de exemplo ATHIS', 'manage_options', 'athis-demo', 'athis_demo_pagina' );
} );

function athis_demo_pagina() {
	$feito = isset( $_GET['feito'] ) ? sanitize_key( $_GET['feito'] ) : '';
	echo '<div class="wrap"><h1>Dados de exemplo ATHIS</h1>';
	if ( 'carregado' === $feito ) {
		echo '<div class="notice notice-success"><p>Dados de exemplo carregados.</p></div>';
	} elseif ( 'apagado' === $feito ) {
		echo '<div class="notice notice-success"><p>Dados de exemplo removidos.</p></div>';
	}
	echo '<p>Cria 2 territórios, 5 projetos e 4 itens de acervo baseados no protótipo, para apresentar o esboço. Nomes, números e imagens são ilustrativos.</p>';

	foreach ( array( 'carregar' => 'Carregar dados de exemplo', 'apagar' => 'Apagar dados de exemplo' ) as $acao => $rotulo ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:12px;">';
		echo '<input type="hidden" name="action" value="athis_demo_' . esc_attr( $acao ) . '">';
		wp_nonce_field( 'athis_demo_' . $acao );
		submit_button( $rotulo, 'carregar' === $acao ? 'primary' : 'secondary', 'submit', false );
		echo '</form>';
	}
	echo '</div>';
}

function athis_demo_apagar_tudo() {
	$ids = get_posts( array(
		'post_type'      => array( 'territorio', 'projeto', 'acervo' ),
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_key'       => '_athis_demo',
		'meta_value'     => '1',
	) );
	foreach ( $ids as $id ) {
		wp_delete_post( $id, true );
	}
}

add_action( 'admin_post_athis_demo_apagar', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sem permissão.' );
	}
	check_admin_referer( 'athis_demo_apagar' );
	athis_demo_apagar_tudo();
	wp_safe_redirect( admin_url( 'tools.php?page=athis-demo&feito=apagado' ) );
	exit;
} );

add_action( 'admin_post_athis_demo_carregar', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Sem permissão.' );
	}
	check_admin_referer( 'athis_demo_carregar' );

	// Evita duplicar: limpa o que já veio de um carregamento anterior
	athis_demo_apagar_tudo();

	$dados     = athis_demo_dados();
	$terr_ids  = array();

	foreach ( $dados['territorios'] as $t ) {
		$id = wp_insert_post( array(
			'post_type'    => 'territorio',
			'post_status'  => 'publish',
			'post_title'   => $t['titulo'],
			'post_name'    => $t['slug'],
			'post_excerpt' => $t['resumo'],
		) );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		$terr_ids[ $t['slug'] ] = $id;
		update_post_meta( $id, '_athis_demo', '1' );
		update_post_meta( $id, '_athis_img_exemplo', $t['img'] );
		foreach ( $t['meta'] as $chave => $valor ) {
			update_post_meta( $id, '_athis_' . $chave, $valor );
		}
	}

	foreach ( $dados['projetos'] as $p ) {
		$id = wp_insert_post( array(
			'post_type'    => 'projeto',
			'post_status'  => 'publish',
			'post_title'   => $p[0],
			'post_excerpt' => $p[1],
			'post_content' => $p[1],
		) );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_athis_demo', '1' );
		update_post_meta( $id, '_athis_img_exemplo', athis_unsplash( $p[5], 800 ) );
		update_post_meta( $id, '_athis_territorio_id', $terr_ids[ $p[2] ] ?? 0 );
		update_post_meta( $id, '_athis_status', $p[3] );
		update_post_meta( $id, '_athis_texto_link', $p[4] );
	}

	foreach ( $dados['acervo'] as $a ) {
		$id = wp_insert_post( array(
			'post_type'    => 'acervo',
			'post_status'  => 'publish',
			'post_title'   => $a[0],
			'post_excerpt' => $a[1],
		) );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_athis_demo', '1' );
		update_post_meta( $id, '_athis_territorio_id', $terr_ids[ $a[2] ] ?? 0 );
		update_post_meta( $id, '_athis_tipo', $a[3] );
		update_post_meta( $id, '_athis_ano', $a[4] );
		update_post_meta( $id, '_athis_autoria', $a[5] );
		update_post_meta( $id, '_athis_orientacao', $a[6] );
	}

	wp_safe_redirect( admin_url( 'tools.php?page=athis-demo&feito=carregado' ) );
	exit;
} );
