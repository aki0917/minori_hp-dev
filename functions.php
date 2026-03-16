<?php
/**
 * 農家の店みのり FARM & GARDEN テーマの機能
 *
 * @package Minorihp
 */

// テーマのセットアップ
function minorihp_setup() {
    // テーマの翻訳機能を有効化
    load_theme_textdomain( 'minorihp', get_template_directory() . '/languages' );

    // 自動フィードリンクを有効化
    add_theme_support( 'automatic-feed-links' );

    // タイトルタグのサポート
    add_theme_support( 'title-tag' );

    // アイキャッチ画像のサポート
    add_theme_support( 'post-thumbnails' );

    // HTML5マークアップのサポート
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // カスタムロゴのサポート
    add_theme_support( 'custom-logo', array(
        'height'      => 56,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'minorihp_setup' );

// トップページのtitleをカスタマイズ
function minorihp_custom_title( $title_parts ) {
  if ( is_front_page() || is_home() ) {
    $title_parts['title'] = '農業資材・農薬・肥料の専門店｜農家の店みのり｜栃木・茨城';
    $title_parts['site'] = '';
  } elseif ( is_page_template( 'page-shop.php' ) ) {
    $title_parts['title'] = '店舗一覧｜農業資材・農薬・肥料の専門店｜農家の店みのり｜栃木・茨城';
    $title_parts['site'] = '';
  } elseif ( is_page_template( 'page-anniversary.php' ) ) {
    $title_parts['title'] = '4周年祭｜みのり花木センター インターパーク店｜2026年3月14日・15日';
    $title_parts['site'] = '';
  }
  return $title_parts;
}
add_filter( 'document_title_parts', 'minorihp_custom_title' );

// スタイルシートとスクリプトの読み込み
function minorihp_scripts() {
    // テーマのスタイルシート（style.css はテーマヘッダーのみ）
    wp_enqueue_style( 'minorihp-style', get_stylesheet_uri(), array(), '1.0.0' );

    // メインCSS（@import チェーンを廃止し直接読み込み → LCP改善）
    wp_enqueue_style( 'minorihp-main-style', get_template_directory_uri() . '/css/style.css', array( 'minorihp-style' ), '1.0.0' );

    // Swiper: トップページのみ読み込む（スライダーはトップページ専用）
    if ( is_front_page() ) {
        wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );
        wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );
    }

    // GSAP: ヘッダーアニメーション・スクロール制御で全ページ必要
    wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
    wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );

    // テーマのJavaScript
    wp_enqueue_script( 'minorihp-main', get_template_directory_uri() . '/js/main.js', array( 'gsap', 'gsap-scrolltrigger' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'minorihp_scripts' );

// ページごとの追加スクリプト
// ※ shop-detail.js は静的HTML用の上書きスクリプトのため、WP化後は読み込まない
function minorihp_page_scripts() {
    if ( is_page_template( 'page-shop.php' ) ) {
        // 必要になったらここで専用スクリプトを読み込む
    }

    // 4周年祭 告知バナー用CSS（トップページ）
    if ( is_front_page() ) {
        wp_enqueue_style( 'minorihp-anniv-banner', get_template_directory_uri() . '/css/anniv-banner.css', array( 'minorihp-style' ), '1.0.0' );
        // CLS対策CSS（トップページのみ）
        wp_enqueue_style( 'minorihp-cls-fix', get_template_directory_uri() . '/css/cls-fix.css', array( 'minorihp-main-style' ), '1.0.0' );
    }

    // 4周年祭LPページ用CSS
    if ( is_page_template( 'page-anniversary.php' ) ) {
        wp_enqueue_style( 'minorihp-anniversary', get_template_directory_uri() . '/css/anniversary.css', array( 'minorihp-style' ), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'minorihp_page_scripts' );

// ========================================
// パフォーマンス最適化
// ========================================

/**
 * Swiper CSS を非レンダリングブロック化（print media トリック）
 * スクロール以下のカルーセル用CSSのためFCPをブロックさせない
 */
function minorihp_nonblocking_styles( $html, $handle ) {
    if ( 'swiper' === $handle ) {
        $html = str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $html );
    }
    return $html;
}
add_filter( 'style_loader_tag', 'minorihp_nonblocking_styles', 10, 2 );

/**
 * Instagram embed.js に async 属性を付与
 * サードパーティスクリプトがメインスレッドをブロックしないようにする
 */
function minorihp_script_attributes( $tag, $handle, $src ) {
    if ( 'instagram-embed' === $handle ) {
        return str_replace( ' src=', ' async src=', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'minorihp_script_attributes', 10, 3 );

// カスタム投稿タイプ: 店舗情報
function minorihp_register_post_types() {
    // 店舗情報
    $shop_labels = array(
        'name'               => '店舗',
        'singular_name'      => '店舗',
        'menu_name'          => '店舗',
        'name_admin_bar'     => '店舗',
        'add_new'            => '新規追加',
        'add_new_item'       => '店舗を追加',
        'new_item'           => '新規店舗',
        'edit_item'          => '店舗を編集',
        'view_item'          => '店舗を表示',
        'all_items'          => '店舗一覧',
        'search_items'       => '店舗を検索',
        'not_found'          => '店舗が見つかりません',
        'not_found_in_trash' => 'ゴミ箱に店舗はありません',
    );

    register_post_type(
        'shop',
        array(
            'labels'             => $shop_labels,
            'public'             => true,
            'has_archive'        => false,
            'show_in_rest'       => true,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-store',
            'rewrite'            => array( 'slug' => 'shop', 'with_front' => false ),
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
            'publicly_queryable' => true,
            'show_ui'            => true,
        )
    );

    // お知らせ
    $news_labels = array(
        'name'               => 'お知らせ',
        'singular_name'      => 'お知らせ',
        'menu_name'          => 'お知らせ',
        'name_admin_bar'     => 'お知らせ',
        'add_new'            => '新規追加',
        'add_new_item'       => 'お知らせを追加',
        'new_item'           => '新規お知らせ',
        'edit_item'          => 'お知らせを編集',
        'view_item'          => 'お知らせを表示',
        'all_items'          => 'お知らせ一覧',
        'search_items'       => 'お知らせを検索',
        'not_found'          => 'お知らせが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にお知らせはありません',
    );

    register_post_type(
        'news',
        array(
            'labels'             => $news_labels,
            'public'             => true,
            'has_archive'        => 'news',
            'show_in_rest'       => true,
            'menu_position'      => 21,
            'menu_icon'          => 'dashicons-megaphone',
            'rewrite'            => array( 'slug' => 'news', 'with_front' => false ),
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'publicly_queryable' => true,
            'show_ui'            => true,
            'taxonomies'         => array( 'category' ),
        )
    );

    // ブログ（SEO記事）
    $blog_labels = array(
        'name'               => 'ブログ',
        'singular_name'      => 'ブログ',
        'menu_name'          => 'ブログ',
        'name_admin_bar'     => 'ブログ',
        'add_new'            => '新規追加',
        'add_new_item'       => 'ブログを追加',
        'new_item'           => '新規ブログ',
        'edit_item'          => 'ブログを編集',
        'view_item'          => 'ブログを表示',
        'all_items'          => 'ブログ一覧',
        'search_items'       => 'ブログを検索',
        'not_found'          => 'ブログが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にブログはありません',
    );

    register_post_type(
        'blog',
        array(
            'labels'             => $blog_labels,
            'public'             => true,
            'has_archive'        => 'blog',
            'show_in_rest'       => true,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-edit',
            'rewrite'            => array( 'slug' => 'blog', 'with_front' => false ),
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'publicly_queryable' => true,
            'show_ui'            => true,
            'taxonomies'         => array( 'category' ),
        )
    );
}
add_action( 'init', 'minorihp_register_post_types' );

// メニューの登録
function minorihp_menus() {
    register_nav_menus( array(
        'primary' => __( 'プライマリーメニュー', 'minorihp' ),
    ) );
}
add_action( 'init', 'minorihp_menus' );

/**
 * グローバルナビの現在ページにアクティブクラスを付与
 *
 * - WordPress が自動で付ける `current-menu-item` や
 *   `current_page_item`, `current-menu-ancestor` などのクラスを元に
 *   独自クラス `is-active` を追加します。
 * - CSS では `.l-header__nav-item.is-active .l-header__nav-link::after`
 *   によって下線を表示するため、このクラスが付けば
 *   各ページ滞在時に下線が出るようになります。
 */
function minorihp_primary_nav_active_class( $classes, $item, $args ) {
    // ヘッダーのプライマリーメニュー以外には影響させない
    if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $classes;
    }

    $current_classes = array(
        'current-menu-item',
        'current_page_item',
        'current-menu-parent',
        'current_page_parent',
        'current-menu-ancestor',
        'current_page_ancestor',
        'current-post-ancestor',
        'current-post-parent',
        'current-post-type-archive',
    );

    if ( array_intersect( $current_classes, $classes ) ) {
        $classes[] = 'is-active';
    }

    return $classes;
}
add_filter( 'nav_menu_css_class', 'minorihp_primary_nav_active_class', 10, 3 );

// フォールバックメニュー（メニューが設定されていない場合）
function minorihp_fallback_menu() {
    // 各リンクごとに「現在ページかどうか」を判定
    $is_home_active  = is_front_page();
    $is_about_active = is_page( 'about' ) || is_page_template( 'page-about.php' );
    $is_shop_active  = is_page( 'shop' ) || is_page_template( 'page-shop.php' ) || is_singular( 'shop' );
    $is_news_active  = is_post_type_archive( 'news' ) || is_singular( 'news' );
    $is_blog_active  = is_post_type_archive( 'blog' ) || is_singular( 'blog' );
    ?>
    <ul class="l-header__nav-list">
        <li class="l-header__nav-item <?php echo $is_home_active ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="l-header__nav-link" <?php echo $is_home_active ? 'aria-current="page"' : ''; ?>>トップ</a>
        </li>
        <li class="l-header__nav-item <?php echo $is_about_active ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="l-header__nav-link" <?php echo $is_about_active ? 'aria-current="page"' : ''; ?>>会社概要</a>
        </li>
        <li class="l-header__nav-item <?php echo $is_news_active ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="l-header__nav-link" <?php echo $is_news_active ? 'aria-current="page"' : ''; ?>>お知らせ</a>
        </li>
        <li class="l-header__nav-item <?php echo $is_blog_active ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="l-header__nav-link" <?php echo $is_blog_active ? 'aria-current="page"' : ''; ?>>ブログ</a>
        </li>
        <li class="l-header__nav-item <?php echo $is_shop_active ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="l-header__nav-link" <?php echo $is_shop_active ? 'aria-current="page"' : ''; ?>>店舗一覧</a>
        </li>
        <li class="l-header__nav-item">
            <a href="<?php echo esc_url( 'https://kkminori-recruit.jp/-/top/' ); ?>" target="_blank" rel="noopener noreferrer" class="l-header__nav-link">募集要項</a>
        </li>
    </ul>
    <?php
}

/**
 * Instagram 投稿の埋め込み HTML を取得するヘルパー
 *
 * Instagram Graph API やトークンは一切使わず、
 * Instagram公式の埋め込みコード＋`embed.js` だけで表示します。
 * （＝oEmbed APIも使わない、安全でシンプルな方式）
 *
 * @param string $url Instagram の投稿 URL（例: https://www.instagram.com/p/XXXX/）
 * @return string 埋め込み用 HTML。失敗時は false。
 */
if ( ! function_exists( 'minorihp_get_instagram_embed' ) ) {
	function minorihp_get_instagram_embed( $url ) {
		if ( empty( $url ) ) {
			return false;
		}
		
		// URLを正規化（末尾のスラッシュを削除）
		$url = rtrim( $url, '/' );
		
		// Instagramの埋め込みコードを生成（Instagram公式の埋め込み形式）
		$embed_code = sprintf(
			'<blockquote class="instagram-media" data-instgrm-permalink="%s/" data-instgrm-version="14" style="background:#FFF;border:0;border-radius:3px;box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15);margin:1px;max-width:540px;min-width:326px;padding:0;width:99.375%%;width:-webkit-calc(100%% - 2px);width:calc(100%% - 2px);">
				<div style="padding:16px;">
					<a href="%s/" style="background:#FFFFFF;line-height:0;padding:0;text-align:center;text-decoration:none;width:100%%;" target="_blank" rel="noopener noreferrer">
						<div style="display:flex;flex-direction:row;align-items:center;">
							<div style="background-color:#F4F4F4;border-radius:50%%;flex-grow:0;height:40px;margin-right:14px;width:40px;"></div>
							<div style="display:flex;flex-direction:column;flex-grow:1;justify-content:center;">
								<div style="background-color:#F4F4F4;border-radius:4px;flex-grow:0;height:14px;margin-bottom:6px;width:100px;"></div>
								<div style="background-color:#F4F4F4;border-radius:4px;flex-grow:0;height:14px;width:60px;"></div>
							</div>
						</div>
						<div style="padding:19%% 0;"></div>
						<div style="display:block;height:50px;margin:0 auto 12px;width:50px;">
							<svg width="50px" height="50px" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
								<g fill="#000"><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.997 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.997 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.853 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.853 570.966,40.831 570.82,37.631"/></g></g></svg>
						</div>
					</a>
				</div>
			</blockquote>',
			esc_url( $url ),
			esc_url( $url )
		);
		
		return $embed_code;
	}
}

/**
 * Instagram 埋め込み用の公式スクリプトを読み込む
 * トップページのみ読み込む（Instagram埋め込みはトップページ専用）
 */
function minorihp_enqueue_instagram_embed_script() {
	if ( is_front_page() ) {
		wp_enqueue_script( 'instagram-embed', 'https://www.instagram.com/embed.js', array(), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'minorihp_enqueue_instagram_embed_script' );

require_once get_template_directory() . '/inc/structured-data/schema-loader.php';

/**
 * WebP対応の <picture> タグ HTML を返す。
 *
 * 同じパスに .webp ファイルが存在する場合は <source type="image/webp"> を追加する。
 * ファイルが存在しない場合は通常の <img> タグのみを返す。
 *
 * @param string $src  元画像の URL（JPG / PNG）
 * @param string $alt  alt テキスト
 * @param array  $args {
 *   @type string $class         CSS クラス名
 *   @type string $loading       loading 属性（デフォルト: 'lazy'、空文字で省略）
 *   @type string $decoding      decoding 属性（デフォルト: 'async'）
 *   @type string $fetchpriority fetchpriority 属性（デフォルト: 'low'、空文字で省略）
 *   @type string $width         width 属性
 *   @type string $height        height 属性
 * }
 * @return string HTML
 */
function minorihp_get_picture_tag( $src, $alt, $args = array() ) {
    $defaults = array(
        'class'         => '',
        'loading'       => 'lazy',
        'decoding'      => 'async',
        'fetchpriority' => 'low',
        'width'         => '',
        'height'        => '',
    );
    $args = wp_parse_args( $args, $defaults );

    $webp_src  = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $src );
    $webp_path = str_replace(
        get_template_directory_uri(),
        get_template_directory(),
        $webp_src
    );
    $has_webp = file_exists( $webp_path );

    $attrs  = $args['class']         ? ' class="'         . esc_attr( $args['class'] )         . '"' : '';
    $attrs .= $args['loading']       ? ' loading="'       . esc_attr( $args['loading'] )       . '"' : '';
    $attrs .= $args['decoding']      ? ' decoding="'      . esc_attr( $args['decoding'] )      . '"' : '';
    $attrs .= $args['fetchpriority'] ? ' fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"' : '';
    $attrs .= $args['width']         ? ' width="'         . esc_attr( $args['width'] )         . '"' : '';
    $attrs .= $args['height']        ? ' height="'        . esc_attr( $args['height'] )        . '"' : '';

    $img_tag = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '"' . $attrs . '>';

    if ( $has_webp ) {
        return '<picture>'
            . '<source srcset="' . esc_url( $webp_src ) . '" type="image/webp">'
            . $img_tag
            . '</picture>';
    }

    return $img_tag;
}

