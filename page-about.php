<?php
/**
 * Template Name: 会社概要
 *
 * @package Minorihp
 */

get_header();
$assets = get_template_directory_uri() . '/assets';
?>

<main class="l-main">
  <?php while ( have_posts() ) : the_post(); ?>
  <section class="p-about">
    <div class="p-about__inner">
      <div class="p-about__grid">
        <?php
        $about_images = array(
          'about-item1.jpg',
          'about-item2.jpg',
          'about-item3.jpg',
          'about-item4.jpg',
          'about-item5.jpg',
          'about-item6.jpg',
        );
        foreach ( $about_images as $filename ) :
        ?>
          <div class="p-about__item">
            <?php echo minorihp_get_picture_tag(
              $assets . '/img/about/' . $filename,
              '企業理念イメージ',
              array( 'class' => 'p-about__image', 'width' => '600', 'height' => '450' )
            ); ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="p-about__overlay">
        <h2 class="p-about__title">企業理念</h2>
        <p class="p-about__text">
         『超スローフード宣言』つくる・育てるよろこび、安心・安全のよろこび、美味しいよろこびを提案します。
        </p>
      </div>
    </div>
  </section>

  <section class="p-about-message">
    <div class="p-about-message__inner">
      <h2 class="p-about-message__title c-sec-title">超スローフード宣言とは</h2>
      <div class="p-about-message__content">
        <p class="p-about-message__text">
          超スローフード宣言は、弊社が大切にしている理念です。<br>
          タネ・苗から育てた野菜が食卓に並び、その美味しさを家族みんなで味わい、楽しむ<br>
          つくる・育てるよろこび、安心・安全なのよろこび、美味しいよろこびを提案します。
        </p>
        <p class="p-about-message__text">
          私たちは、農業を通じて自然と向き合い、<br>
          時間をかけて丁寧に育てることで、本当の美味しさを追求しています。<br>
          それは単なるスピードや効率ではなく、<br>
          一つひとつのプロセスを大切にする「超スロー」なアプローチです。
        </p>
        <p class="p-about-message__text">
          安心・安全な食材を提供することは、私たちの使命です。<br>
          そして、その食材を使った料理が、<br>
          家族や大切な人との時間をより豊かにしてくれることを願っています。
        </p>
      </div>
    </div>
  </section>

  <section class="p-about-info">
    <div class="p-about-info__inner">
      <h2 class="p-about-info__title c-sec-title">会社概要</h2>
      <div class="p-about-info__content">
        <table class="p-about-info__table">
          <tbody>
            <tr>
              <th>会社名</th>
              <td>株式会社みのり</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td>〒324-0047<br>栃木県大田原市美原1-3138-2</td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><a href="tel:0287-23-2211">0287-23-2211</a></td>
            </tr>
            <tr>
              <th>設立</th>
              <td>1992年4月</td>
            </tr>
            <tr>
              <th>事業内容</th>
              <td>農業資材、農薬、肥料、機械など生産資材の販売<br>野菜・花の種や苗の販売<br>園芸・ガーデニング関連商品の販売</td>
            </tr>
            <tr>
              <th>店舗数</th>
              <td>9店舗（栃木県・茨城県）</td>
            </tr>
            <tr>
              <th>取り扱い商品数</th>
              <td>30,000点以上</td>
            </tr>
            <tr>
              <th>代表者</th>
              <td>代表取締役 郡司 健</td>
            </tr>
            <tr>
              <th>資本金</th>
              <td>3300万円</td>
            </tr>
            <tr>
              <th>従業員数</th>
              <td>約120名</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="p-about-eaat">
    <div class="p-about-eaat__bg">
      <?php echo minorihp_get_picture_tag(
        $assets . '/img/about/about-item1.jpg',
        '農家の店みのり 店舗・農業イメージ',
        array( 'class' => 'p-about-eaat__bg-image', 'width' => '1920', 'height' => '1080' )
      ); ?>
    </div>
    <div class="p-about-eaat__inner">
      <div class="p-about-eaat__item">
        <h3 class="p-about-eaat__subtitle">私たちについて</h3>
        <p class="p-about-eaat__text">
          「農家の店みのり」は、地域の農家さんや家庭菜園を楽しむ皆さまの"頼れる相談相手"として、長年この土地でお店を続けてきました。
        </p>
        <p class="p-about-eaat__text">
          当社では、お客さまのニーズと専門知識をと備えたスタッフの経験をもとに、最適な資材をご提案、販売できる体制を整えています。
        </p>
        <p class="p-about-eaat__text">
          勤続経験20年以上の多様な経験と知識を持っているベテランスタッフをはじめ、毒劇物取扱責任者、販売士2級・グリーンアドバイザーの資格を取得しているスタッフまで多数在籍しています。
        </p>
        <p class="p-about-eaat__text">
          野菜栽培、果樹、花きなど、それぞれの専門分野に精通したスタッフが、お客様のご要望に合わせて最適なアドバイスをいたします。
        </p>
      </div>

      <div class="p-about-eaat__item">
        <h3 class="p-about-eaat__subtitle">お店の強み</h3>
        <p class="p-about-eaat__text">
          当店は、大型量販店とは異なり、農業資材・園芸用品に特化した専門店です。
        </p>
        <p class="p-about-eaat__text">
          肥料・土・苗・農具などを幅広く取り扱うだけでなく、「どれを選べば良いか迷ってしまう」というお客様に対しても、経験豊富なスタッフが目的や環境に合わせて丁寧にアドバイスいたします。
        </p>
        <p class="p-about-eaat__text">
          地域の気候や土壌に合わせた"実践的なアドバイス"ができるのは、長年この地域で営業してきた当社ならではの強みです。
        </p>
      </div>

      <div class="p-about-eaat__item">
        <h3 class="p-about-eaat__subtitle">お客様への価値</h3>
        <p class="p-about-eaat__text">
          農家の店みのりでは、初心者の園芸ユーザーからプロの農家さんまで、幅広いお客様にご利用いただいています。
        </p>
        <p class="p-about-eaat__text">
          「初めて野菜を育てるけど何を買えばいい？」「土の改良方法が知りたい」「この苗に合う肥料は？」など、どんなご相談でも歓迎です。
        </p>
        <p class="p-about-eaat__text">
          商品を販売するだけでなく、"育てる楽しさと成功体験" をサポートするお店として、地域の皆さまの豊かな暮らしのお手伝いをしてまいります。
        </p>
      </div>
    </div>
  </section>

  <section class="p-about-history">
    <div class="p-about-history__inner">
      <h2 class="p-about-history__title c-sec-title">沿革</h2>
      <div class="p-about-history__content">
        <ul class="p-about-history__list">
          <?php
          $history_items = array(
            array( 'year' => '1992年', 'text' => '株式会社みのりを創立' ),
            array(
              'year' => '1992年4月',
              'text' => '栃木県那須塩原市に西那須野店オープン',
              'image' => 'ni1.jpg',
            ),
            array(
              'year' => '1995年2月',
              'text' => '栃木県下野市に石橋店オープン',
              'image' => 'isi1.jpg',
            ),
            array(
              'year' => '1998年2月',
              'text' => '栃木県真岡市に真岡店オープン',
              'image' => 'mo1.jpg',
            ),
            array(
              'year' => '1998年3月',
              'text' => '栃木県大田原市に大田原店オープン',
              'image' => 'oo1.jpg',
            ),
            array(
              'year' => '1998年3月',
              'text' => '栃木県さくら市に氏家店オープン',
              'image' => 'u1.jpg',
            ),
            array(
              'year' => '1999年8月',
              'text' => '栃木県鹿沼市に鹿沼店オープン',
              'image' => 'ka1.jpg',
            ),
            array(
              'year' => '2001年8月',
              'text' => '茨城県筑西市に協和店オープン',
              'image' => 'kyo1.jpg',
            ),
            array(
              'year' => '2002年4月',
              'text' => '栃木県市貝町に市貝店オープン',
              'image' => 'iti1.jpg',
            ),
            array(
              'year' => '2023年',
              'text' => '栃木県宇都宮市にみのり花木センター<br>インターパーク店オープン',
              'image' => 'IP1.jpg',
            ),
          );

          foreach ( $history_items as $item ) :
            $image_html = '';
            if ( isset( $item['image'] ) ) {
              $image_html = '<div class="p-about-history__image-wrapper">'
                . minorihp_get_picture_tag(
                    $assets . '/img/shop/' . $item['image'],
                    '店舗写真',
                    array( 'class' => 'p-about-history__image', 'width' => '600', 'height' => '400' )
                  )
                . '</div>';
            }
          ?>
          <li class="p-about-history__item">
            <div class="p-about-history__content-wrapper">
              <div class="p-about-history__text-wrapper">
                <span class="p-about-history__year"><?php echo esc_html( $item['year'] ); ?></span>
                <span class="p-about-history__text"><?php echo wp_kses_post( $item['text'] ); ?></span>
              </div>
              <?php echo $image_html; ?>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>

