<?php
/**
 * Organization 構造化データ
 *
 * ■ 出力条件: 全ページ共通
 * ■ E-E-A-T: 信頼性（Trustworthiness）・権威性（Authoritativeness）
 * ■ AIO/GEO: 組織の実在性をAIに認識させ、引用・参照の信頼源として評価される
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Organization 構造化データを出力
 */
function minorihp_schema_organization() {
	$site_url = 'https://www.noukanomiseminori.com';
	$logo_url = $site_url . '/wp-content/themes/minorihp-theme/assets/img/common/logo-1.png';

	$data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'Organization',
		'@id'             => $site_url . '/#organization',
		'name'            => '株式会社みのり',
		'legalName'       => '株式会社みのり',
		'alternateName'   => '農家の店みのりFARM & GARDEN',
		'url'             => $site_url,
		'logo'            => array(
			'@type'   => 'ImageObject',
			'url'     => $logo_url,
			'width'   => 200,
			'height'  => 56,
		),
		'description'     => '農業資材、農薬、肥料、機械など生産資材から、野菜・花の種や苗を扱う大型の専門店。栃木県、茨城県に9店舗を展開しており、取り扱いアイテム数は3万点以上です。',
		'address'         => array(
			'@type'           => 'PostalAddress',
			'postalCode'      => '324-0047',
			'addressRegion'   => '栃木県',
			'addressLocality' => '大田原市',
			'streetAddress'   => '美原1-3138-2',
			'addressCountry'  => 'JP',
		),
		'telephone'       => '0287-23-2211',
		'foundingDate'    => '1992-04',
		'numberOfEmployees' => array(
			'@type' => 'QuantitativeValue',
			'value' => 120,
		),
		'knowsAbout'      => array(
			'農業資材販売',
			'園芸用品',
			'土壌診断',
			'施肥設計',
			'農薬適正使用',
		),
		'founder'         => array(
			'@type'    => 'Person',
			'name'     => '郡司 健',
			'jobTitle' => '代表取締役',
		),
		'employee'        => array(
			array(
				'@type'       => 'Person',
				'jobTitle'    => '販売スタッフ',
				'description' => '勤続20年以上。毒劇物取扱責任者、販売士2級・グリーンアドバイザー保有のベテランスタッフが在籍。',
			),
		),
		'areaServed'      => array(
			array( '@type' => 'State', 'name' => '栃木県' ),
			array( '@type' => 'State', 'name' => '茨城県' ),
		),
		'sameAs'          => array(
			'https://www.instagram.com/noukanomiseminori/',
			'https://www.rakuten.co.jp/kminori/',
			'https://store.shopping.yahoo.co.jp/noyaku-com/',
			'https://www.amazon.co.jp/s?i=merchant-items&me=A2EFHFKX98OBK5',
		),
	);

	minorihp_output_jsonld( $data );
}
