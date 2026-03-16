<?php
/**
 * BlogPosting 構造化データ
 *
 * ■ 出力条件: 投稿詳細ページ（single.php / single-news.php）
 * ■ E-E-A-T: 経験（Experience）・専門性（Expertise）
 * ■ AIO/GEO: AIによる引用・参照の対象となり、著者・組織の専門性を示す
 *
 * publisher に Organization を @id 参照することで
 * 「誰が発信しているか」をAI・検索エンジンに明示 → E-E-A-T の信頼性・権威性
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BlogPosting 構造化データを出力
 *
 * is_singular() が true のとき（投稿詳細・カスタム投稿詳細）に自動出力。
 * publisher は Organization の @id を参照し、グラフを構成する。
 */
function minorihp_schema_blogposting() {
	if ( ! is_singular() ) {
		return;
	}

	if ( is_page() ) {
		return;
	}

	$site_url = 'https://www.noukanomiseminori.com';

	$post_id   = get_the_ID();
	$title     = get_the_title( $post_id );
	$permalink = get_permalink( $post_id );
	$excerpt   = get_the_excerpt( $post_id );
	$content   = wp_strip_all_tags( get_the_content( null, false, $post_id ) );
	$content   = wp_trim_words( $content, 100, '...' );

	$date_published = get_the_date( 'c', $post_id );
	$date_modified  = get_the_modified_date( 'c', $post_id );

	$image = '';
	if ( has_post_thumbnail( $post_id ) ) {
		$image = get_the_post_thumbnail_url( $post_id, 'full' );
	}

	$data = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'BlogPosting',
		'@id'              => $permalink . '#blogposting',
		'mainEntityOfPage' => array(
			'@type' => 'WebPage',
			'@id'   => $permalink,
		),
		'headline'         => $title,
		'description'      => $excerpt ?: $content,
		'datePublished'    => $date_published,
		'dateModified'     => $date_modified,
		'author'           => array(
			'@id' => $site_url . '/#organization',
		),
		'publisher'        => array(
			'@id' => $site_url . '/#organization',
		),
		'isPartOf'         => array(
			'@id' => $site_url . '/#website',
		),
	);

	if ( $image ) {
		$data['image'] = array(
			'@type' => 'ImageObject',
			'url'   => $image,
		);
	}

	minorihp_output_jsonld( $data );
}
