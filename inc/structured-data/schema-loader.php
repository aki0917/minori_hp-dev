<?php
/**
 * 構造化データ ローダー
 *
 * 全スキーマファイルを読み込み、wp_head / wp_footer にフックする。
 *
 * ═══════════════════════════════════════════════════════════════
 *  構造化データ設計ルール（E-E-A-T × AIO/AEO/GEO 対応）
 * ═══════════════════════════════════════════════════════════════
 *
 *  スキーマ        | 出力場所         | 出力タイミング        | E-E-A-T         | AIO
 *  ─────────────────┼──────────────────┼───────────────────────┼─────────────────┼──────────
 *  Organization    | 全ページ         | wp_head               | 信頼性・権威性   | GEO
 *  WebSite         | 全ページ         | wp_head               | 信頼性           | AEO
 *  BreadcrumbList  | 全ページ(※)     | wp_head               | 信頼性           | AEO
 *  BlogPosting     | 投稿詳細         | wp_head               | 経験・専門性     | GEO
 *  FAQPage         | FAQ有ページ      | wp_footer             | 専門性           | AEO
 *  HowTo           | HowTo有ページ    | wp_footer             | 経験・専門性     | AEO
 *
 *  ※ BreadcrumbList は header.php に残置（PHPロジックが位置依存のため）
 *
 * ─────────────────────────────────────────────────────────────
 *  @id によるグラフ連結:
 *    Organization (@id: /#organization)
 *       ↑ publisher として参照
 *    WebSite      (@id: /#website)
 *       ↑ isPartOf として参照
 *    BlogPosting  (@id: /path/#blogposting)
 *
 *  → 全てが @id で繋がることで、Google・AI が
 *    「誰が」「どのサイトで」「何を発信しているか」を一貫して理解する。
 * ═══════════════════════════════════════════════════════════════
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$structured_data_dir = get_template_directory() . '/inc/structured-data/';

require_once $structured_data_dir . 'schema-organization.php';
require_once $structured_data_dir . 'schema-website.php';
require_once $structured_data_dir . 'schema-blogposting.php';
require_once $structured_data_dir . 'schema-faq.php';
require_once $structured_data_dir . 'schema-howto.php';

/**
 * JSON-LD を <script> タグとして出力するユーティリティ
 *
 * @param array $data 構造化データ配列
 */
function minorihp_output_jsonld( $data ) {
	if ( empty( $data ) ) {
		return;
	}
	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
	echo "\n" . '</script>' . "\n";
}

/**
 * wp_head で出力するスキーマ（全ページ共通 + 条件付き）
 */
function minorihp_structured_data_head() {
	minorihp_schema_organization();
	minorihp_schema_website();
	minorihp_schema_blogposting();
}
add_action( 'wp_head', 'minorihp_structured_data_head', 5 );

/**
 * wp_footer で出力するスキーマ（テンプレートからデータセット後）
 *
 * FAQ / HowTo はテンプレート内でデータをセットしてから
 * wp_footer のタイミングで出力する。これにより
 * テンプレートの任意の場所でデータを定義できる。
 */
function minorihp_structured_data_footer() {
	minorihp_schema_faq();
	minorihp_schema_howto();
}
add_action( 'wp_footer', 'minorihp_structured_data_footer', 5 );
