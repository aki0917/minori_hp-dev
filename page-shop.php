<?php
/**
 * Template Name: 店舗一覧
 *
 * @package Minorihp
 */

get_header();
$assets = get_template_directory_uri() . '/assets';

$shops = array(
  array(
    'slug'    => 'nishinasuno',
    'name'    => '西那須野店',
    'address' => '〒329-2745<br>栃木県那須塩原市三区町510-2',
    'tel'     => '0287-36-7043',
    'image'   => 'ni1.jpg',
  ),
  array(
    'slug'    => 'ishibashi',
    'name'    => '石橋店',
    'address' => '〒329-0431<br>栃木県下野市薬師寺祇園原3379-3',
    'tel'     => '0285-44-3831',
    'image'   => 'isi1.jpg',
  ),
  array(
    'slug'    => 'moka',
    'name'    => '真岡店',
    'address' => '〒321-4304<br>栃木県真岡市東郷20-2',
    'tel'     => '0285-83-9696',
    'image'   => 'mo1.jpg',
  ),
  array(
    'slug'    => 'ootawara',
    'name'    => '大田原店',
    'address' => '〒324-0047<br>栃木県大田原市美原1-3138-2',
    'tel'     => '0287-23-3335',
    'image'   => 'oo1.jpg',
  ),
  array(
    'slug'    => 'ujiie',
    'name'    => '氏家店',
    'address' => '〒329-1312<br>栃木県さくら市桜野1141-2',
    'tel'     => '028-681-1911',
    'image'   => 'u1.jpg',
  ),
  array(
    'slug'    => 'kanuma',
    'name'    => '鹿沼店',
    'address' => '〒322-0015<br>栃木県鹿沼市上石川1457-1',
    'tel'     => '0289-76-4445',
    'image'   => 'ka1.jpg',
  ),
  array(
    'slug'    => 'kyouwa',
    'name'    => '協和店',
    'address' => '〒309-1106<br>茨城県筑西市新治1996-123',
    'tel'     => '0296-21-7788',
    'image'   => 'kyo1.jpg',
  ),
  array(
    'slug'    => 'ichikai',
    'name'    => '市貝店',
    'address' => '〒321-3426<br>栃木県芳賀郡市貝町赤羽3589-2',
    'tel'     => '0285-67-4141',
    'image'   => 'iti1.jpg',
  ),
  array(
    'slug'    => 'interpark',
    'name'    => 'みのり花木センター<br>インターパーク店',
    'address' => '〒321-0918<br>栃木県宇都宮市平塚町307-1',
    'tel'     => '028-656-7193',
    'image'   => 'IP1.jpg',
  ),
);

// 住所をパースする関数（テンプレート内で使用）
if ( ! function_exists( 'minorihp_parse_shop_address' ) ) {
  function minorihp_parse_shop_address( $address ) {
    $address = wp_strip_all_tags( $address );
    $parsed = array(
      'postalCode' => '',
      'addressLocality' => '',
      'addressRegion' => '',
      'streetAddress' => '',
    );
    
    // 郵便番号を抽出
    if ( preg_match( '/〒?(\d{3}-\d{4})/', $address, $matches ) ) {
      $parsed['postalCode'] = $matches[1];
      $address = preg_replace( '/〒?\d{3}-\d{4}\s*/', '', $address );
    }
    
    // 都道府県を抽出（都道府県名のパターンにマッチ）
    if ( preg_match( '/([^都道府県]*[都道府県])/', $address, $matches ) ) {
      $prefecture = trim( $matches[1] );
      $parsed['addressRegion'] = $prefecture;
      $address = str_replace( $prefecture, '', $address );
    }
    
    // 市区町村を抽出
    if ( preg_match( '/([^\d]+?[市区町村])/', $address, $matches ) ) {
      $parsed['addressLocality'] = trim( $matches[1] );
      $address = str_replace( $matches[1], '', $address );
    }
    
    // 残りを番地として設定
    $parsed['streetAddress'] = trim( $address );
    
    return $parsed;
  }
}

// 実際のCPT投稿を取得（1回だけ）
$shop_posts = get_posts( array(
  'post_type'      => 'shop',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
) );

// スラッグをキーにした配列を作成
$shop_posts_by_slug = array();
foreach ( $shop_posts as $post ) {
  $shop_posts_by_slug[ $post->post_name ] = $post;
}

// 構造化データ用の店舗リストを準備
$structured_shops = array();
foreach ( $shops as $index => $shop ) {
  $parsed_address = minorihp_parse_shop_address( $shop['address'] );
  
  // 実際の投稿があればそのパーマリンクを使用、なければ固定リンク
  if ( isset( $shop_posts_by_slug[ $shop['slug'] ] ) ) {
    $detail_url = get_permalink( $shop_posts_by_slug[ $shop['slug'] ]->ID );
  } else {
    $detail_url = home_url( '/shop/' . $shop['slug'] . '/' );
  }
  
  $shop_name_clean = wp_strip_all_tags( $shop['name'] );
  
  $structured_shops[] = array(
    '@type' => 'ListItem',
    'position' => $index + 1,
    'item' => array(
      '@type' => 'GardenStore',
      'name' => '農家の店みのりFARM & GARDEN ' . $shop_name_clean,
      'image' => esc_url( $assets . '/img/shop/' . $shop['image'] ),
      'url' => esc_url( $detail_url ),
      'address' => array(
        '@type' => 'PostalAddress',
        'streetAddress' => $parsed_address['streetAddress'],
        'addressLocality' => $parsed_address['addressLocality'],
        'addressRegion' => $parsed_address['addressRegion'],
        'postalCode' => $parsed_address['postalCode'],
        'addressCountry' => 'JP',
      ),
      'telephone' => $shop['tel'],
      'parentOrganization' => array(
        '@type' => 'Organization',
        'name' => '株式会社みのり',
      ),
    ),
  );
}
?>

<!-- 店舗一覧ページ用の構造化データ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "店舗一覧",
  "description": "農家の店みのりFARM & GARDENの店舗一覧。栃木県・茨城県に9店舗を展開しています。",
  "numberOfItems": <?php echo count( $structured_shops ); ?>,
  "itemListElement": <?php echo wp_json_encode( $structured_shops, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?>
}
</script>

<main class="l-main">
  <?php while ( have_posts() ) : the_post(); ?>
  <section class="p-shop">
    <div class="p-shop__inner">
      <h1 class="p-shop__title c-sec-title">
        <span class="u-visually-hidden">栃木県・茨城県の農業資材専門店 </span>店舗一覧
      </h1>
      <p class="p-shop__description">
        栃木県・茨城県に9店舗を展開しています。お近くの店舗をご利用ください。
      </p>
      <ul class="p-shop__list">
        <?php 
        // $shop_posts_by_slug は上で既に取得済み
        foreach ( $shops as $shop ) :
          // 実際の投稿があればそのパーマリンクを使用、なければ固定リンク
          if ( isset( $shop_posts_by_slug[ $shop['slug'] ] ) ) {
            $detail_link = get_permalink( $shop_posts_by_slug[ $shop['slug'] ]->ID );
          } else {
            $detail_link = home_url( '/shop/' . $shop['slug'] . '/' );
          }
        ?>
        <li class="p-shop__item">
          <a href="<?php echo esc_url( $detail_link ); ?>" class="p-shop__card">
            <div class="p-shop__image-wrapper">
              <?php echo minorihp_get_picture_tag(
                $assets . '/img/shop/' . $shop['image'],
                $shop['name'],
                array( 'class' => 'p-shop__image', 'loading' => 'lazy', 'width' => '600', 'height' => '400' )
              ); ?>
            </div>
            <div class="p-shop__content">
              <h3 class="p-shop__name"><?php echo wp_kses_post( $shop['name'] ); ?></h3>
              <p class="p-shop__address"><?php echo wp_kses_post( $shop['address'] ); ?></p>
              <p class="p-shop__tel">TEL: <span><?php echo esc_html( $shop['tel'] ); ?></span></p>
            </div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>

