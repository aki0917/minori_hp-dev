<?php
/**
 * WebSite 構造化データ
 *
 * ■ 出力条件: 全ページ共通
 * ■ E-E-A-T: 信頼性（Trustworthiness）
 * ■ AIO/AEO: サイトリンク検索ボックス表示、サイト全体の認識向上
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WebSite 構造化データを出力
 *
 * SearchAction を含むことで Google 検索結果にサイト内検索ボックスが
 * 表示される可能性がある。AEO 観点でもサイトの構造認識に寄与。
 */
function minorihp_schema_website() {
	$site_url = 'https://www.noukanomiseminori.com';

	$data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'@id'             => $site_url . '/#website',
		'name'            => '農家の店みのりFARM & GARDEN',
		'url'             => $site_url,
		'publisher'       => array(
			'@id' => $site_url . '/#organization',
		),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $site_url . '/?s={search_term_string}',
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	minorihp_output_jsonld( $data );
}
