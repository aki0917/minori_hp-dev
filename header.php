<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CDN接続の事前確立（ページ速度改善） -->
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

  <!-- GSAPを先読み: 全ページ使用するためheadで前倒しダウンロード開始 -->
  <!-- URLはfunctions.phpのwp_enqueue_scriptで指定したバージョンと一致させる -->
  <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js?ver=3.12.5" crossorigin>
  <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js?ver=3.12.5" crossorigin>
  <?php if ( is_front_page() ) : ?>
  <link rel="preload" as="script" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js?ver=11.0.0" crossorigin>
  <?php endif; ?>

  <!-- LCP改善: トップページのヒーロー画像を最優先で先読み（WebP優先） -->
  <?php if ( is_front_page() ) : ?>
  <link rel="preload" as="image"
    href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/top-hero.webp' ); ?>"
    imagesrcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/sp_top.webp' ); ?> 768w, <?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/top-hero.webp' ); ?> 1920w"
    imagesizes="(max-width: 768px) 100vw, 100vw"
    fetchpriority="high"
    type="image/webp">
  <link rel="preload" as="image"
    href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/top-hero.jpg' ); ?>"
    imagesrcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/sp_top.jpg' ); ?> 768w, <?php echo esc_url( get_template_directory_uri() . '/assets/img/hero/top-hero.jpg' ); ?> 1920w"
    imagesizes="(max-width: 768px) 100vw, 100vw"
    fetchpriority="high">
  <?php endif; ?>
  
  <!-- meta description（ページ種別ごとに出し分け） -->
  <?php if ( is_front_page() || is_home() ) : ?>
    <meta name="description" content="農家の店みのりは、農業資材・農薬・肥料・種苗・園芸用品を扱う専門店です。栃木県・茨城県に9店舗を展開し、プロ農家から家庭菜園まで幅広く対応しています。">
  <?php elseif ( is_post_type_archive( 'news' ) ) : ?>
    <meta name="description" content="農家の店みのりの最新ニュース一覧です。セール・イベント・新商品情報など店舗からの最新情報をお届けします。">
  <?php elseif ( is_post_type_archive( 'blog' ) ) : ?>
    <meta name="description" content="農家の店みのりのブログ一覧です。農業・園芸・ガーデニングに役立つ情報を発信しています。">
  <?php else : ?>
    <meta name="description" content="<?php echo esc_attr( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ), 30 ) ); ?>">
  <?php endif; ?>
  
  <?php wp_head(); ?>
  
  <!-- OGP -->
  <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
  <meta property="og:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
  <meta property="og:description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ?: '農業資材、農薬、肥料、機械など生産資材から、野菜・花の種や苗を扱う大型の専門店。栃木県、茨城県に9店舗を展開しており、取り扱いアイテム数は3万点以上です。' ); ?>">
  <meta property="og:url" content="<?php echo esc_url( get_permalink() ?: home_url() ); ?>">
  <meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
  <meta property="og:image" content="<?php echo esc_url( get_template_directory_uri() . '/assets/img/common/logo-1.png' ); ?>">
  <meta property="og:locale" content="ja_JP">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ?: '農業資材、農薬、肥料、機械など生産資材から、野菜・花の種や苗を扱う大型の専門店。栃木県、茨城県に9店舗を展開しており、取り扱いアイテム数は3万点以上です。' ); ?>">
  <meta name="twitter:image" content="<?php echo esc_url( get_template_directory_uri() . '/assets/img/common/logo-1.png' ); ?>">
  
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/aaa1.ico' ); ?>">
  <link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/aaa1.ico' ); ?>">
  
  <!-- 構造化データ: Organization / WebSite / BlogPosting は schema-loader.php で wp_head に自動出力 -->
  
  <!-- BreadcrumbList（パンくず）: トップページ以外で出力 -->
  <?php
  $breadcrumbs = array();

  if ( ! is_front_page() ) {
    $breadcrumbs[] = array(
      '@type'    => 'ListItem',
      'position' => 1,
      'name'     => 'ホーム',
      'item'     => home_url( '/' ),
    );

    if ( is_post_type_archive( 'news' ) ) {
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 2,
        'name'     => 'ニュース',
        'item'     => get_post_type_archive_link( 'news' ),
      );
    } elseif ( is_post_type_archive( 'blog' ) ) {
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 2,
        'name'     => 'ブログ',
        'item'     => get_post_type_archive_link( 'blog' ),
      );
    } elseif ( is_singular( 'news' ) ) {
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 2,
        'name'     => 'ニュース',
        'item'     => get_post_type_archive_link( 'news' ),
      );
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 3,
        'name'     => get_the_title(),
        'item'     => get_permalink(),
      );
    } elseif ( is_singular( 'blog' ) ) {
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 2,
        'name'     => 'ブログ',
        'item'     => get_post_type_archive_link( 'blog' ),
      );
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 3,
        'name'     => get_the_title(),
        'item'     => get_permalink(),
      );
    } elseif ( is_singular() ) {
      $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 2,
        'name'     => get_the_title(),
        'item'     => get_permalink(),
      );
    }
  }

  if ( ! empty( $breadcrumbs ) ) :
  ?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": <?php echo wp_json_encode( $breadcrumbs ); ?>
  }
  </script>
  <?php endif; ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  
  <header class="l-header" role="banner">
    <div class="l-header__inner">
      <?php if ( is_front_page() ) : ?>
      <h1 class="l-header__logo">
      <?php else : ?>
      <p class="l-header__logo">
      <?php endif; ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="農家の店みのりFARM &amp; GARDEN ホーム">
          <?php echo minorihp_get_picture_tag(
            get_template_directory_uri() . '/assets/img/common/logo-1.png',
            '農家の店みのりFARM &amp; GARDEN',
            array( 'width' => '927', 'height' => '269', 'loading' => '', 'fetchpriority' => '', 'decoding' => 'async' )
          ); ?>
        </a>
      <?php if ( is_front_page() ) : ?>
      </h1>
      <?php else : ?>
      </p>
      <?php endif; ?>
      <button class="l-header__toggle" type="button" aria-controls="global-nav" aria-expanded="false" aria-label="メニューを開く">
        <span class="l-header__toggle-bar"></span>
        <span class="l-header__toggle-bar"></span>
        <span class="l-header__toggle-bar"></span>
      </button>
      <div class="l-header__overlay" aria-hidden="true"></div>
      <nav id="global-nav" class="l-header__nav" role="navigation" aria-label="グローバルナビゲーション">
        <?php
        wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'l-header__nav-list',
          'fallback_cb'    => 'minorihp_fallback_menu',
        ) );
        ?>
        <div class="l-header__nav-social">
          <div class="l-header__nav-social-group">
            <div class="l-header__nav-social-label">みのり各店</div>
            <a href="<?php echo esc_url( 'https://www.instagram.com/noukanomiseminori/' ); ?>" target="_blank" rel="noopener noreferrer" class="l-header__nav-social-link" aria-label="Instagram">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_instagram.svg' ); ?>" alt="Instagram" width="24" height="24">
            </a>
          </div>
          <div class="l-header__nav-social-group">
            <div class="l-header__nav-social-label">インターパーク店</div>
            <div class="l-header__nav-social-links">
              <a href="<?php echo esc_url( 'https://www.instagram.com/minori_kaboku_interpark/' ); ?>" target="_blank" rel="noopener noreferrer" class="l-header__nav-social-link" aria-label="Instagram">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_instagram.svg' ); ?>" alt="Instagram" width="24" height="24">
              </a>
              <a href="#" class="l-header__nav-social-link" aria-label="LINE">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_line.svg' ); ?>" alt="LINE" width="24" height="24">
              </a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <?php if ( is_front_page() ) : ?>
  <aside class="social social--left">
    <div class="social__label">みのり各店</div>
    <a href="<?php echo esc_url( 'https://www.instagram.com/noukanomiseminori/' ); ?>" target="_blank" rel="noopener noreferrer" class="social__link" aria-label="Instagram">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_instagram.svg' ); ?>" alt="Instagram" width="24" height="24">
    </a>
  </aside>

  <aside class="social social--right">
    <div class="social__label">インターパーク店</div>
    <a href="<?php echo esc_url( 'https://www.instagram.com/minori_kaboku_interpark/' ); ?>" target="_blank" rel="noopener noreferrer" class="social__link" aria-label="Instagram">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_instagram.svg' ); ?>" alt="Instagram" width="24" height="24">
    </a>
    <a href="<?php echo esc_url( 'https://lin.ee/Ri3brQ9' ); ?>" target="_blank" rel="noopener noreferrer" class="social__link" aria-label="LINE">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/icon_line.svg' ); ?>" alt="LINE" width="24" height="24">
    </a>
  </aside>
  <?php endif; ?>

