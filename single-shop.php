<?php
/**
 * 店舗詳細テンプレート（カスタム投稿タイプ shop）
 *
 * @package Minorihp
 */

get_header();
$assets = get_template_directory_uri() . '/assets';

// 店舗データ配列（page-shop.phpと同じ）
$shop_data_map = array(
  'nishinasuno' => array(
    'name' => '西那須野店',
    'address_full' => '栃木県那須塩原市三区町510-2',
    'address_locality' => '那須塩原市',
    'address_region' => '栃木県',
    'postal_code' => '329-2745',
    'tel' => '0287-36-7043',
    'image' => 'ni1.jpg',
  ),
  'ishibashi' => array(
    'name' => '石橋店',
    'address_full' => '栃木県下野市薬師寺祇園原3379-3',
    'address_locality' => '下野市',
    'address_region' => '栃木県',
    'postal_code' => '329-0431',
    'tel' => '0285-44-3831',
    'image' => 'isi1.jpg',
  ),
  'moka' => array(
    'name' => '真岡店',
    'address_full' => '栃木県真岡市東郷20-2',
    'address_locality' => '真岡市',
    'address_region' => '栃木県',
    'postal_code' => '321-4304',
    'tel' => '0285-83-9696',
    'image' => 'mo1.jpg',
  ),
  'ootawara' => array(
    'name' => '大田原店',
    'address_full' => '栃木県大田原市美原1-3138-2',
    'address_locality' => '大田原市',
    'address_region' => '栃木県',
    'postal_code' => '324-0047',
    'tel' => '0287-23-3335',
    'image' => 'oo1.jpg',
  ),
  'ujiie' => array(
    'name' => '氏家店',
    'address_full' => '栃木県さくら市桜野1141-2',
    'address_locality' => 'さくら市',
    'address_region' => '栃木県',
    'postal_code' => '329-1312',
    'tel' => '028-681-1911',
    'image' => 'u1.jpg',
  ),
  'kanuma' => array(
    'name' => '鹿沼店',
    'address_full' => '栃木県鹿沼市上石川1457-1',
    'address_locality' => '鹿沼市',
    'address_region' => '栃木県',
    'postal_code' => '322-0015',
    'tel' => '0289-76-4445',
    'image' => 'ka1.jpg',
  ),
  'kyouwa' => array(
    'name' => '協和店',
    'address_full' => '茨城県筑西市新治1996-123',
    'address_locality' => '筑西市',
    'address_region' => '茨城県',
    'postal_code' => '309-1106',
    'tel' => '0296-21-7788',
    'image' => 'kyo1.jpg',
  ),
  'ichikai' => array(
    'name' => '市貝店',
    'address_full' => '栃木県芳賀郡市貝町赤羽3589-2',
    'address_locality' => '市貝町',
    'address_region' => '栃木県',
    'postal_code' => '321-3426',
    'tel' => '0285-67-4141',
    'image' => 'iti1.jpg',
  ),
  'interpark' => array(
    'name' => 'みのり花木センター インターパーク店',
    'address_full' => '栃木県宇都宮市平塚町307-1',
    'address_locality' => '宇都宮市',
    'address_region' => '栃木県',
    'postal_code' => '321-0918',
    'tel' => '028-656-7193',
    'image' => 'IP1.jpg',
  ),
);
?>

<main class="l-main">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php
    $post_id = get_the_ID();
    // デバッグ用（一時的）
    // echo '<!-- Post ID: ' . $post_id . ', Slug: ' . get_post_field( 'post_name', $post_id ) . ', Title: ' . get_the_title() . ' -->';
    $shop_name        = function_exists( 'get_field' ) ? ( get_field( 'shop_name', $post_id ) ?: get_the_title() ) : get_the_title();
    $shop_image       = function_exists( 'get_field' ) ? get_field( 'shop_image', $post_id ) : '';
    $shop_address     = function_exists( 'get_field' ) ? ( get_field( 'shop_address', $post_id ) ?: '' ) : '';
    $shop_tel         = function_exists( 'get_field' ) ? ( get_field( 'shop_tel', $post_id ) ?: '' ) : '';
    $shop_hours       = function_exists( 'get_field' ) ? ( get_field( 'shop_hours', $post_id ) ?: '' ) : '';
    $shop_map_iframe  = function_exists( 'get_field' ) ? get_field( 'shop_map_iframe', $post_id ) : '';
    $shop_features    = function_exists( 'get_field' ) ? get_field( 'shop_features', $post_id ) : '';
    $shop_feature_img = function_exists( 'get_field' ) ? get_field( 'shop_feature_image', $post_id ) : '';
    
    // スラッグから店舗データを取得
    $shop_slug = get_post_field( 'post_name', $post_id );
    $shop_data = isset( $shop_data_map[ $shop_slug ] ) ? $shop_data_map[ $shop_slug ] : null;
    
    // 構造化データ用のデータを準備（ACFフィールドがあれば優先、なければ配列から取得）
    $structured_name = '農家の店みのり ' . ( $shop_data ? $shop_data['name'] : $shop_name );
    $structured_image = '';
    $structured_address_full = $shop_address ? wp_strip_all_tags( $shop_address ) : ( $shop_data ? $shop_data['address_full'] : '' );
    $structured_address_locality = $shop_data ? $shop_data['address_locality'] : '';
    $structured_address_region = $shop_data ? $shop_data['address_region'] : '';
    $structured_postal_code = $shop_data ? $shop_data['postal_code'] : '';
    $structured_tel = $shop_tel ?: ( $shop_data ? $shop_data['tel'] : '' );
    $structured_url = get_permalink();

    $image_url = '';
    if ( is_array( $shop_image ) && isset( $shop_image['url'] ) ) {
      $image_url = $shop_image['url'];
    } elseif ( is_string( $shop_image ) && ! empty( $shop_image ) ) {
      $image_url = $shop_image;
    } else {
      $image_url = $assets . '/img/shop/ni1.jpg';
    }
    
    // 構造化データ用の画像URLを設定（店舗データから取得）
    if ( $shop_data && isset( $shop_data['image'] ) ) {
      // 指示に従い、店舗スラッグを含むパス形式で設定
      $structured_image = home_url( '/shop/' . $shop_slug . '/' . $shop_data['image'] );
    } else {
      $structured_image = $image_url;
    }

    $feature_image_url = '';
    if ( is_array( $shop_feature_img ) && isset( $shop_feature_img['url'] ) ) {
      $feature_image_url = $shop_feature_img['url'];
    } elseif ( is_string( $shop_feature_img ) && ! empty( $shop_feature_img ) ) {
      $feature_image_url = $shop_feature_img;
    }

    // マップ埋め込み: 優先 1) iframe入力 2) 住所で自動埋め込み 3) デフォルト
    if ( $shop_map_iframe ) {
      $map_iframe = $shop_map_iframe;
    } elseif ( $shop_address ) {
      $encoded_address = rawurlencode( wp_strip_all_tags( $shop_address ) );
      $map_src = sprintf( 'https://www.google.com/maps?q=%s&z=15&output=embed', $encoded_address );
      $map_iframe = sprintf(
        '<iframe id="shopMap" src="%s" width="100%%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        esc_url( $map_src )
      );
    } else {
      $map_iframe = '<iframe id="shopMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3203.5!2d140.0!3d36.8!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzYsNDgsMC4wIE4gMTQwLDAwLDAuMCBF!5e0!3m2!1sja!2sjp!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }
    ?>
    
    <!-- LocalBusiness構造化データ -->
    <?php if ( $structured_address_full && $structured_tel ) : ?>
    <script type="application/ld+json">
    <?php
    $local_business_data = array(
      '@context' => 'https://schema.org',
      '@type' => 'LocalBusiness',
      'name' => $structured_name,
      'image' => $structured_image,
      'address' => array(
        '@type' => 'PostalAddress',
        'streetAddress' => $structured_address_full,
        'addressLocality' => $structured_address_locality,
        'addressRegion' => $structured_address_region,
        'postalCode' => $structured_postal_code,
        'addressCountry' => 'JP',
      ),
      'telephone' => $structured_tel,
      'url' => $structured_url,
    );
    echo wp_json_encode( $local_business_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
    ?>
    </script>
    <?php endif; ?>
    <article class="p-shop-detail">
      <div class="p-shop-detail__inner">
        <div class="p-shop-detail__breadcrumb">
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">店舗一覧</a> &gt; <span id="shopName"><?php echo esc_html( $shop_name ); ?></span>
        </div>

        <header class="p-shop-detail__header">
          <h1 class="p-shop-detail__title" id="shopTitle"><?php echo esc_html( $shop_name ); ?></h1>
          <div class="p-shop-detail__image">
            <img id="shopMainImage" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $shop_name ); ?>" decoding="async" fetchpriority="high" width="800" height="600">
          </div>
        </header>

        <div class="p-shop-detail__content">
          <section class="p-shop-detail__info">
            <h2 class="p-shop-detail__section-title">店舗情報</h2>
            <dl class="p-shop-detail__info-list">
              <dt>住所</dt>
              <dd id="shopAddress"><?php echo wp_kses_post( $shop_address ?: '住所情報は準備中です。' ); ?></dd>

              <dt>電話番号</dt>
              <dd>
                <?php if ( $shop_tel ) : ?>
                  <a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $shop_tel ) ); ?>" id="shopTel"><?php echo esc_html( $shop_tel ); ?></a>
                <?php else : ?>
                  <span id="shopTel">電話番号は準備中です。</span>
                <?php endif; ?>
              </dd>

              <dt>営業時間</dt>
              <dd id="shopHours"><?php echo wp_kses_post( $shop_hours ?: '営業時間は準備中です。' ); ?></dd>
            </dl>
          </section>

          <section class="p-shop-detail__map">
            <h2 class="p-shop-detail__section-title">地図</h2>
            <div class="p-shop-detail__map-wrapper">
              <?php echo $map_iframe; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
          </section>

          <section class="p-shop-detail__features">
            <h2 class="p-shop-detail__section-title">店舗の特徴</h2>
            <div id="shopFeatures">
              <?php
              if ( $shop_features ) {
                echo wp_kses_post( $shop_features );
              } else {
                ?>
                <p>
                  店舗の詳細情報は現在準備中です。公開までしばらくお待ちください。
                </p>
                <?php
              }
              ?>
            </div>
            <?php if ( $feature_image_url ) : ?>
            <div class="p-shop-detail__features-image">
              <img src="<?php echo esc_url( $feature_image_url ); ?>" alt="<?php echo esc_attr( $shop_name ); ?>" loading="lazy" decoding="async" fetchpriority="low" width="800" height="600">
            </div>
            <?php endif; ?>
          </section>
        </div>

        <div class="p-shop-detail__back">
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="c-button">店舗一覧に戻る</a>
        </div>
      </div>
    </article>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>

