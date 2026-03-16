<?php
/**
 * FAQPage 構造化データ
 *
 * ■ 出力条件: FAQデータがセットされたページ（テンプレート側で呼び出し）
 * ■ E-E-A-T: 専門性（Expertise）・経験（Experience）
 * ■ AIO/AEO: 質問に対する直接回答としてAI・Google に選ばれる
 *
 * Q&A形式は AEO（Answer Engine Optimization）の最重要施策。
 * Google の AI Overviews や ChatGPT が回答ソースとして採用しやすい形式。
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FAQPage 構造化データを出力
 *
 * テンプレート側で FAQ 配列をセットしてから wp_footer で自動出力。
 *
 * 使い方（テンプレート内）:
 *   minorihp_set_faq_data( array(
 *     array( 'question' => '質問文', 'answer' => '回答文' ),
 *     array( 'question' => '質問文', 'answer' => '回答文' ),
 *   ) );
 */

/** @var array FAQデータの格納用 */
$GLOBALS['minorihp_faq_data'] = array();

/**
 * FAQデータをセット（テンプレートから呼び出す）
 *
 * @param array $faqs array of [ 'question' => string, 'answer' => string ]
 */
function minorihp_set_faq_data( $faqs ) {
	if ( ! is_array( $faqs ) || empty( $faqs ) ) {
		return;
	}
	$GLOBALS['minorihp_faq_data'] = $faqs;
}

/**
 * FAQPage 構造化データを出力
 */
function minorihp_schema_faq() {
	$faqs = $GLOBALS['minorihp_faq_data'];

	if ( empty( $faqs ) ) {
		return;
	}

	$main_entity = array();
	foreach ( $faqs as $faq ) {
		if ( empty( $faq['question'] ) || empty( $faq['answer'] ) ) {
			continue;
		}

		$answer_text = wp_strip_all_tags( $faq['answer'] );
		$answer_text = preg_replace( '/\s+/', ' ', $answer_text );
		$answer_text = trim( $answer_text );

		$main_entity[] = array(
			'@type'          => 'Question',
			'name'           => $faq['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $answer_text,
			),
		);
	}

	if ( empty( $main_entity ) ) {
		return;
	}

	$data = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main_entity,
	);

	minorihp_output_jsonld( $data );
}
