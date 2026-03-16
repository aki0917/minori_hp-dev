<?php
/**
 * フロントページテンプレート
 * トップページ専用のテンプレート
 *
 * @package Minorihp
 */

get_header();
?>

<?php
// テンプレートディレクトリのURIを取得
$template_uri = get_template_directory_uri();
?>

<section class="l-hero">
  <div class="l-hero-bg">
    <picture>
      <source
        media="(max-width: 768px)"
        srcset="<?php echo esc_url( $template_uri . '/assets/img/hero/sp_top.webp' ); ?>"
        type="image/webp"
      >
      <source
        media="(max-width: 768px)"
        srcset="<?php echo esc_url( $template_uri . '/assets/img/hero/sp_top.jpg' ); ?>"
      >
      <source
        srcset="<?php echo esc_url( $template_uri . '/assets/img/hero/top-hero.webp' ); ?>"
        type="image/webp"
      >
      <img
        src="<?php echo esc_url( $template_uri . '/assets/img/hero/top-hero.jpg' ); ?>"
        alt="農家の店みのり FARM &amp; GARDEN 店舗外観"
        decoding="async"
        fetchpriority="high"
        width="1920"
        height="1080">
    </picture>
  </div>
  <div class="l-hero__content" aria-label="みのりFARM &amp; GARDEN コンセプトコピー">
    <p class="l-hero__copy">
      つくる・育てるよろこび、<br>安心・安全のよろこび、<br>美味しいよろこびを提案します。
    </p>
  </div>
</section>

<div class="l-scroll-indicator">
  <div class="l-hero-scroll">
    <div class="l-hero-scroll__mouse"></div>
    <div class="l-hero-scroll__text">
      <span class="l-hero-scroll__letter">s</span>
      <span class="l-hero-scroll__letter">c</span>
      <span class="l-hero-scroll__letter">r</span>
      <span class="l-hero-scroll__letter">o</span>
      <span class="l-hero-scroll__letter">l</span>
      <span class="l-hero-scroll__letter">l</span>
    </div>
  </div>
</div>

<!-- 4周年祭 告知バナー（ヒーロー直下） -->
<?php
$anniversary_page = get_page_by_path( 'anniversary' );
$anniversary_url  = $anniversary_page ? get_permalink( $anniversary_page ) : home_url( '/anniversary/' );
?>
<a href="<?php echo esc_url( $anniversary_url ); ?>" class="p-anniv-banner" aria-label="4周年祭特設ページへ">
  <div class="p-anniv-banner__inner">
    <div class="p-anniv-banner__badge">
      <span class="p-anniv-banner__badge-num">4</span>
      <span class="p-anniv-banner__badge-text">周年</span>
    </div>
    <div class="p-anniv-banner__body">
      <p class="p-anniv-banner__title">
        <span class="p-anniv-banner__title-main">みのり花木センター インターパーク店</span>
        <span class="p-anniv-banner__title-event">4周年祭 開催！</span>
      </p>
      <p class="p-anniv-banner__meta">
        <span class="p-anniv-banner__date">2026年 3/14<small>(土)</small>・15<small>(日)</small></span>
        <span class="p-anniv-banner__sep">｜</span>
        <span class="p-anniv-banner__highlights">展示会・イベント・特売</span>
      </p>
    </div>
    <span class="p-anniv-banner__cta">
      詳しく見る<span class="p-anniv-banner__cta-arrow" aria-hidden="true">→</span>
    </span>
  </div>
</a>

<main class="l-main">  
  <section id="about-intro" class="p-about-intro" aria-labelledby="about-intro-title">
    <div class="p-about-intro__inner">
      <h2 id="about-intro-title" class="p-about-intro__title">農家の店みのり FARM &amp; GARDEN</h2>
      <p class="p-about-intro__text">
        農業資材、農薬、肥料、機械など生産資材から、野菜・花の種や苗を扱う大型の専門店です。<br>さらにFARM&amp;GARDENストアとして、園芸、ガーデニング関連商品の取り扱いを充実し、プロの農家さんから家庭菜園愛好家、ガーデナーまで幅広いニーズにお応えします。栃木県、茨城県に9店舗を展開しており、取り扱いアイテム数は3万点以上です。
      </p>
    </div>
  </section>

  <?php
  // ニュースセクション（最新3件を表示）
  // カスタム投稿タイプ「news」を対象にする
  $news_query = new WP_Query( array(
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
  ) );
  ?>
  <section id="news" class="p-news" aria-labelledby="news-title">
    <div class="p-news__inner">
      <h2 id="news-title" class="p-news__title c-sec-title">NEWS</h2>
      <?php if ( $news_query->have_posts() ) : ?>
        <ul class="p-news__list">
          <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
            <li class="p-news__item">
              <a class="p-news__link" href="<?php the_permalink(); ?>">
                <time class="p-news__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
                <?php
                $categories = get_the_category();
                $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'お知らせ';
                ?>
                <span class="p-news__cat"><?php echo esc_html( $cat_name ); ?></span>
                <span class="p-news__text"><?php the_title(); ?></span>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else : ?>
        <ul class="p-news__list">
          <li class="p-news__item">
            <a class="p-news__link" href="#">
              <time class="p-news__date" datetime="2025-10-30">2025.10.30</time>
              <span class="p-news__cat">お知らせ</span>
              <span class="p-news__text">test</span>
            </a>
          </li>
        </ul>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <p class="p-news__more"><a class="c-button" href="<?php echo esc_url( home_url( '/news' ) ); ?>">もっと見る</a></p>
    </div>
  </section>

  <?php
  // 6つの特徴セクション
  $features = array(
    array(
      'image' => 'item3.png',
      'title' => '種子',
      'subtitle' => '日本初、タネの美術館「シードギャラリー」',
      'text' => '「シードギャラリー」は文字通り、野菜・花のタネを美術品・工芸品に見立てたタネの美術館。2000を超えるアイテムの品ぞろえ。種をまいてから収穫まで、数か月先のよろこびを描いていただく「超スローフード宣言」の入口です。店頭に並んだ新鮮な苗は、それ自身が安心安全、美味しさ、作りやすさを追求した「厳選素材」です。',
      'alt' => '種苗',
    ),
    array(
      'image' => 'item5.jpg',
      'title' => '野菜苗',
      'subtitle' => 'メーカ-苗から当社オリジナル苗まで',
      'text' => '当社の野菜苗は、メーカー、品種を厳選しこだわりの苗を販売しています。取り扱い品種は100種類以上で地域一番の品ぞろえが魅力です。夏野菜苗をはじめ、葉物野菜苗、ネギ苗、タマネギ苗など季節ごとに売り場に鮮度の良い苗が並びます。',
      'alt' => '野菜苗',
    ),
    array(
      'image' => 'item1.png',
      'title' => '肥料',
      'subtitle' => '農業の基本は土づくり',
      'text' => '有機肥料から化成肥料まで作物にあった最適な肥料をお客様との会話の中で見極めおすすめします。土壌診断も承っております。',
      'alt' => '肥料',
    ),
    array(
      'image' => 'item2.png',
      'title' => '農業資材',
      'subtitle' => '作物の能力を最大に引き出す副資材',
      'text' => '気候、生育条件によって異なる作物の能力を最大限に引き出すためには、効率的な資材の活用が欠かせません。気候、作物、コストに応じた最適な資材を提案します。',
      'alt' => '農業資材',
    ),
    array(
      'image' => 'item4.jpg',
      'title' => '農薬',
      'subtitle' => '作物の薬を処方する植物のドクター',
      'text' => '農薬は、食物生産に必要不可欠で価値のある薬です。正しい選び方、使い方等、お客様のご相談に応じています。',
      'alt' => '農薬',
    ),
    array(
      'image' => 'item6.jpg',
      'title' => '園芸（ガーデニング）',
      'subtitle' => '家庭菜園から趣味の園芸まで幅広くご提案',
      'text' => '季節の花苗、鉢花をはじめ、観葉・多肉植物、さらに店舗によっては、人気の品種や珍しい品種まで取り扱っています。園芸用土、プランター、小鉢、雑貨なども豊富にご用意。ガーデニングの楽しみや喜びのイメージが膨らんでいきます。',
      'alt' => '肥料',
    ),
  );
  ?>
  <section id="items" class="p-items" aria-labelledby="items-title">
    <div class="p-items__inner">
      <h2 id="items-title" class="c-sec-title">6つの特徴</h2>
      <div class="p-items__content">
        <?php foreach ( $features as $feature ) : ?>
          <article class="p-items__item">
            <?php echo minorihp_get_picture_tag(
              $template_uri . '/assets/img/top/' . $feature['image'],
              $feature['alt'],
              array( 'class' => 'p-items__image', 'width' => '400', 'height' => '300' )
            ); ?>
            <div class="p-items__body">
              <h3 class="p-items__item-title"><?php echo esc_html( $feature['title'] ); ?></h3>
              <h4 class="p-items__item-sub"><?php echo esc_html( $feature['subtitle'] ); ?></h4>
              <p class="p-items__item-text"><?php echo esc_html( $feature['text'] ); ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php
  // みのりオリジナル商品セクション
  $products = array(
    array(
      'image' => 'minori-or888.png',
      'title' => 'NM液肥8号',
      'subtitle' => '作物別に最適化したブレンド',
      'text' => '窒素・りん酸・加里の成分が8%並びです。各作物の元肥に幅広く使用できます。りん酸・加里不足圃場への追肥にも適しています。',
      'link' => 'https://item.rakuten.co.jp/kminori/1008855/',
    ),
    array(
      'image' => 'minori-or11210.png',
      'title' => 'NM液肥N-1PK20号',
      'subtitle' => '土づくりを手軽に',
      'text' => 'NM液肥N1-PK20号：りん酸・加里の補給に優れた肥料です。1%のアンモニア窒素が作物の活力に貢献します。',
      'link' => 'https://item.rakuten.co.jp/kminori/1008856/',
    ),
    array(
      'image' => 'minori-or1058.png',
      'title' => 'NM液肥 10号 10-5-8',
      'subtitle' => '植物本来の力を引き出す',
      'text' => '窒素成分に対し、りん酸・加里成分を低く抑えトマト・イチゴ・ハウス栽培作物の追肥に適した成分バランスになっています。',
      'link' => 'https://item.rakuten.co.jp/kminori/1008854/',
    ),
    array(
      'image' => 'minori-or1566.png',
      'title' => 'NM液肥 15号 15-6-6',
      'subtitle' => '植物本来の力を引き出す',
      'text' => 'NM液肥15号：窒素成分を高めた液肥です。長期栽培作物の果菜類など茎葉部の生育に効果を発揮します。',
      'link' => 'https://item.rakuten.co.jp/kminori/1008853/',
    ),
    array(
      'image' => 'minori-bo.png',
      'title' => 'みのりバイオ',
      'subtitle' => '菌のチカラで土を元気に!!',
      'text' => '野菜づくりは、土づくりから!!菌のチカラで土を元気に!!野菜活き活き!!、芝生も活き活き!!',
      'link' => 'https://item.rakuten.co.jp/kminori/1008143/',
    ),
    array(
      'image' => 'herbs.jpg',
      'title' => 'ハーブ・ニート',
      'subtitle' => '葉から入って根まで枯らす！',
      'text' => 'あらゆる雑草を根まで枯らす！農耕地（水田・畑・麦・果樹等）の他、家周り、駐車場等にも使用できる。',
      'link' => 'https://item.rakuten.co.jp/kminori/1008898/',
    ),
    array(
      'image' => 'minorikun.png',
      'title' => 'みのりくん(8-3-4-1)',
      'subtitle' => 'みのり×タキイ種苗',
      'text' => 'みのり×タキイ種苗のアミノ酸入り有機液肥『ぐんぐん育つみのりくん』',
      'link' => 'https://item.rakuten.co.jp/kminori/1008916/',
    ),
  );
  ?>
  <section id="originals" class="p-originals" aria-labelledby="originals-title">
    <div class="p-items__inner">
      <h2 id="originals-title" class="c-sec-title">みのりオリジナル商品</h2>
      <ul class="p-items-card__list">
        <?php foreach ( $products as $product ) : ?>
          <li class="p-items-card__card">
            <?php echo minorihp_get_picture_tag(
              $template_uri . '/assets/img/products/' . $product['image'],
              '肥料',
              array( 'class' => 'p-items__image', 'width' => '300', 'height' => '300' )
            ); ?>
            <h3 class="p-items-card__card-title"><?php echo esc_html( $product['title'] ); ?></h3>
            <p class="p-items-card__card-sub"><?php echo esc_html( $product['subtitle'] ); ?></p>
            <p class="p-items-card__card-text"><?php echo esc_html( $product['text'] ); ?></p>
            <p class="p-items-card__card-cta"><a href="<?php echo esc_url( $product['link'] ); ?>" target="_blank" rel="noopener noreferrer" class="c-button">詳しく見る</a></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php
  // サービス事業セクション
  $services = array(
    array(
      'class' => 'p-services__petal--1',
      'title' => '農業機械 販売紹介',
      'modal_title' => '農業機械 販売紹介',
      'modal_image' => 'services-item6.png',
      'modal_body' => 'クボタのトラクター、クボタコンバインなどの農業機械各種販売紹介<br>※対象店舗:石橋店・真岡店・市貝店・インターパーク店',
    ),
    array(
      'class' => 'p-services__petal--2',
      'title' => '乗用車販売紹介',
      'modal_title' => '自動車 販売紹介',
      'modal_image' => 'services-item2.png',
      'modal_body' => '・新車販売紹介<br>・中古車販売紹介<br>・車検、メンテナンス紹介<br>※店舗により取り扱いメーカーが異なります',
    ),
    array(
      'class' => 'p-services__petal--3',
      'title' => 'フォークリフト<br>販売紹介',
      'modal_title' => 'フォークリフト販売紹介',
      'modal_image' => 'services-item3.png',
      'modal_body' => '・フォークリフト新車・中古車販売紹介<br>・フォークリフト、玉掛小型移動式クレーンの技能講習紹介<br>・重量、中軽量ラックの販売紹介',
    ),
    array(
      'class' => 'p-services__petal--4',
      'title' => '不快害虫、害獣<br>駆除紹介',
      'modal_title' => '不快害虫、害獣駆除紹介',
      'modal_image' => 'services-item7.png',
      'modal_body' => '・ハチ・ゴキブリ・ゲジゲジ<br>・ケムシなどの不快害虫<br>・ネズミ・コウモリ・タヌキ<br>・イノシシ・ハクビシンなどの害獣駆除、予防',
    ),
    array(
      'class' => 'p-services__petal--5',
      'title' => '農業用ハウス施工',
      'modal_title' => '農業用ハウス施工',
      'modal_image' => 'services-item8.jpg',
      'modal_body' => '・連棟ハウス<br>・ガラス温室',
    ),
    array(
      'class' => 'p-services__petal--6',
      'title' => '庭木管理・外構',
      'modal_title' => '庭木管理・外構',
      'modal_image' => 'services-item5.png',
      'modal_body' => 'デザインから施工、<br>日本庭園・イングリッシュガーデンなど<br>各種承ります。',
    ),
    array(
      'class' => 'p-services__petal--7',
      'title' => '子供部屋や作業用スペース',
      'modal_title' => '子供部屋や作業用のくつろぎスペースに',
      'modal_image' => 'services-item4.jpg',
      'modal_body' => '・ログ風ハウス<br>・スーパーハウス<br>・コンテナハウスなど<br>ご相談、お見積もり承ります',
    ),
  );
  ?>
  <section id="services" class="p-services" aria-labelledby="services-title">
    <div class="p-services__inner">
      <h2 id="originals-title" class="c-sec-title">みのりサービス事業</h2>
      <div class="p-services__flower">
        <div class="p-services__center">
          <h2 id="services-title" class="p-services__title">お客様の生活をサポート</h2>
        </div>
        <ul class="p-services__petals">
          <?php foreach ( $services as $service ) : ?>
            <li class="p-services__petal <?php echo esc_attr( $service['class'] ); ?>">
              <div class="p-services__petal-content" 
                   data-modal-title="<?php echo esc_attr( $service['modal_title'] ); ?>"
                   data-modal-image="<?php echo esc_url( $template_uri . '/assets/img/services/' . $service['modal_image'] ); ?>"
                   data-modal-body="<?php echo esc_attr( $service['modal_body'] ); ?>">
                <h3 class="p-services__petal-title"><?php echo wp_kses_post( $service['title'] ); ?></h3>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

  <?php
  // お取引についてセクション
  $faqs = array(
    array(
      'question' => '大口注文の最低購入条件はありますか？',
      'answer' => '肥料:パレット単位以上（目安:20kg 50~60袋程度）<br>農薬:10ケース以上とさせていただきます。条件に満たない場合は、弊社のネットショップをご利用ください。',
    ),
    array(
      'question' => '楽天市場、Yahoo!ショッピングから購入できますか？',
      'answer' => '購入可能です。但し、ECモールによって価格が異なる場合がございます。',
    ),
    array(
      'question' => 'フォークリフトがない場合は、宅配便で納品できますか？',
      'answer' => '可能です。※肥料などパレット単位の場合は、フォークリフトが必要となる場合がございます。',
    ),
    array(
      'question' => '店舗での引き取りは可能でしょうか？',
      'answer' => 'ご指定いただければ、弊社店舗に限り対応可能です。弊社ネットショップご利用の場合は、店舗受け取りはできません。',
    ),
    array(
      'question' => '購入代金のお支払い方法は？',
      'answer' => '銀行（楽天銀行・ゆうちょ銀行）への振り込み（前払い）となります。<br>クレジットのご使用の場合は、弊社ネットショップからの購入となります',
    ),
    array(
      'question' => 'キャンセルはできますか？',
      'answer' => '大口ご注文のキャンセルはご入金前までとさせていただきます。<br>ご入金確認後のキャンセルはご遠慮ください。',
    ),
  );
  ?>
  <section id="info" class="p-info" aria-labelledby="info-title">
    <div class="p-info__inner">
      <div class="p-info__flow">
        <h2 id="info-title" class="c-sec-title">お取引について</h2>
        <div class="p-info__flow-steps">
          <div class="p-info__flow-step">
            <div class="p-info__flow-left">
              <div class="p-info__flow-number">01</div>
              <div class="p-info__flow-line"></div>
            </div>
            <div class="p-info__flow-content">
              <h3 class="p-info__flow-title">お問い合わせ</h3>
              <p class="p-info__flow-text">『購入、相談はこちらから』をクリックしてお問い合わせください。また、お近くの店舗でもご相談可能です。※商材募集はサイト下部の各種お取引からご相談ください。</p>
            </div>
          </div>
          <div class="p-info__flow-step">
            <div class="p-info__flow-left">
              <div class="p-info__flow-number">02</div>
              <div class="p-info__flow-line"></div>
            </div>
            <div class="p-info__flow-content">
              <h3 class="p-info__flow-title">見積もり</h3>
              <p class="p-info__flow-text">お客様のご要望に基づき、詳細な見積もりを作成いたします。</p>
            </div>
          </div>
          <div class="p-info__flow-step">
            <div class="p-info__flow-left">
              <div class="p-info__flow-number">03</div>
              <div class="p-info__flow-line"></div>
            </div>
            <div class="p-info__flow-content">
              <h3 class="p-info__flow-title">ご注文</h3>
              <p class="p-info__flow-text">見積もり内容をご確認いただき、ご納得いただけましたらご注文をお受けいたします。</p>
            </div>
          </div>
          <div class="p-info__flow-step">
            <div class="p-info__flow-left">
              <div class="p-info__flow-number">04</div>
            </div>
            <div class="p-info__flow-content">
              <h3 class="p-info__flow-title">納品</h3>
              <p class="p-info__flow-text">ご指定の場所へ配送会社が納品いたします。納品後も、商品の使用方法やご不明点など、お気軽にご相談ください。</p>
            </div>
          </div>
        </div>
        <div class="p-info__flow-cta">
          <a href="<?php echo esc_url( 'https://docs.google.com/forms/d/e/1FAIpQLSfnFdZuG51rfBCrjZxhDQHSpdluXFUm-l2KpDrQQ0NSWaHupw/viewform' ); ?>" target="_blank" rel="noopener noreferrer" class="c-button c-button--large">購入・相談はこちら</a>
        </div>
      </div>

      <div class="p-info__faq">
        <h2 class="c-sec-title">よくある質問</h2>
        <div class="p-info__faq-list">
          <?php foreach ( $faqs as $faq ) : ?>
            <div class="p-info__faq-item" aria-expanded="false">
              <button class="p-info__faq-question" type="button" aria-expanded="false">
                <span class="p-info__faq-question-text"><?php echo esc_html( $faq['question'] ); ?></span>
                <span class="p-info__faq-icon">+</span>
              </button>
              <div class="p-info__faq-answer">
                <p class="p-info__faq-answer-text"><?php echo wp_kses_post( $faq['answer'] ); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php
  // Instagramセクション（Instagram公式oEmbed使用）
  // セキュリティと安定性を優先し、Instagram公式の埋め込み機能を使用しています。
  // これにより、仕様変更や不具合の影響を最小限に抑えています。
  
  // フロントページに設定された固定ページのIDを取得
  $front_page_id = get_option( 'page_on_front' );
  if ( ! $front_page_id ) {
    // フロントページが固定ページに設定されていない場合、0を返す
    $front_page_id = 0;
  }
  ?>
  <section id="instagram" class="p-instagram" aria-labelledby="instagram-title">
    <div class="p-instagram__inner">
      <h2 id="instagram-title" class="p-instagram__title c-sec-title">Instagram</h2>
      
      <?php
      // メインアカウントの投稿URLを取得
      $main_urls = array();
      if ( function_exists( 'get_field' ) && $front_page_id ) {
        $url1 = get_field( 'instagram_post_url_main_1', $front_page_id );
        $url2 = get_field( 'instagram_post_url_main_2', $front_page_id );
        $url3 = get_field( 'instagram_post_url_main_3', $front_page_id );
        $main_urls = array_filter( array( $url1, $url2, $url3 ) );
      }
      ?>
      
      <?php if ( ! empty( $main_urls ) ) : ?>
        <div class="p-instagram__list">
          <?php foreach ( $main_urls as $url ) : ?>
            <?php
            // Instagram公式oEmbed APIを直接呼び出し
            $embed_code = minorihp_get_instagram_embed( $url );
            if ( $embed_code ) :
              ?>
              <div class="p-instagram__item">
                <?php echo $embed_code; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      
      <p class="p-instagram__more">
        <a class="c-button" href="<?php echo esc_url( 'https://www.instagram.com/noukanomiseminori/' ); ?>" target="_blank" rel="noopener noreferrer">Instagramでもっと見る</a>
      </p>

      <h3 class="p-instagram__subtitle c-sec-title">インターパーク店</h3>
      
      <?php
      // インターパーク店アカウントの投稿URLを取得
      $interpark_urls = array();
      if ( function_exists( 'get_field' ) && $front_page_id ) {
        $interpark_urls = array_filter( array(
          get_field( 'instagram_post_url_interpark_1', $front_page_id ),
          get_field( 'instagram_post_url_interpark_2', $front_page_id ),
          get_field( 'instagram_post_url_interpark_3', $front_page_id ),
        ) );
      }
      ?>
      
      <?php if ( ! empty( $interpark_urls ) ) : ?>
        <div class="p-instagram__list">
          <?php foreach ( $interpark_urls as $url ) : ?>
            <?php
            // Instagram公式oEmbed APIを直接呼び出し
            $embed_code = minorihp_get_instagram_embed( $url );
            if ( $embed_code ) :
              ?>
              <div class="p-instagram__item">
                <?php echo $embed_code; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      
      <p class="p-instagram__more">
        <a class="c-button" href="<?php echo esc_url( 'https://www.instagram.com/minori_kaboku_interpark/' ); ?>" target="_blank" rel="noopener noreferrer">Instagramでもっと見る</a>
      </p>
    </div>
  </section>

  <?php
  // ファーマーズカードセクション
  $benefits = array(
    array(
      'number' => '①',
      'title' => 'みのり賞の進呈',
      'text' => 'お買い物(税抜き200円)ごとに1ポイントずつ加算され<br>合計1000ポイントで「みのり賞」を進呈！',
    ),
    array(
      'number' => '②',
      'title' => '土壌診断（有料）',
      'text' => '正確な施肥設計のために土壌診断を行います。<br>またその結果に対する商品のアドバイスも行います。',
    ),
    array(
      'number' => '③',
      'title' => '購入商品の履歴印字サービス',
      'text' => 'お買い物の都度カードをご提示ください。<br>申告などに必要な商品購入一覧を、年1回に限り無償にて提供させていただきます。',
    ),
    array(
      'number' => '④',
      'title' => '使用済み農業用ビニール・農薬空きボトル引き取り（有料）',
      'text' => '同等商品のお買い上げを条件とさせていただきます。<br>農薬は使い切り洗浄してお持ちください。',
    ),
  );
  ?>
  <section id="farmers-card" class="p-farmers-card" aria-labelledby="farmers-card-title">
    <div class="p-farmers-card__inner">
      <div class="p-farmers-card__header">
        <div class="p-farmers-card__intro">
          <h2 id="farmers-card-title" class="c-sec-title">ファーマーズカード</h2>
          <p class="p-farmers-card__description">
            農家さんにうれしいさまざまな特典のある専用会員カードです。<br>
            お買い物の際は、忘れずにご提示ください。<br>
            <span class="p-farmers-card__note">※申し込みはお近くの店舗にお問い合わせください。</span>
          </p>
        </div>
      </div>
      <div class="p-farmers-card__benefits">
        <?php foreach ( $benefits as $benefit ) : ?>
          <div class="p-farmers-card__benefit">
            <span class="p-farmers-card__card-label">FARMER'S CARD</span>
            <div class="p-farmers-card__benefit-content">
              <div class="p-farmers-card__benefit-image">
                <?php echo minorihp_get_picture_tag(
                  $template_uri . '/assets/img/top/mascot.png',
                  'みのりカードマスコット',
                  array( 'width' => '200', 'height' => '200' )
                ); ?>
              </div>
              <div class="p-farmers-card__benefit-text-wrapper">
                <div class="p-farmers-card__benefit-number"><?php echo esc_html( $benefit['number'] ); ?></div>
                <h3 class="p-farmers-card__benefit-title"><?php echo esc_html( $benefit['title'] ); ?></h3>
                <p class="p-farmers-card__benefit-text"><?php echo wp_kses_post( $benefit['text'] ); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<?php minorihp_set_faq_data( $faqs ); ?>

<!-- 4周年祭 フローティングバナー（画面下部固定） -->
<div class="p-anniv-float" id="annivFloat">
  <button class="p-anniv-float__close" id="annivFloatClose" type="button" aria-label="バナーを閉じる">&times;</button>
  <a href="<?php echo esc_url( $anniversary_url ); ?>" class="p-anniv-float__link">
    <span class="p-anniv-float__icon" aria-hidden="true">🎉</span>
    <span class="p-anniv-float__text">
      <strong>みのり花木センター インターパーク店4周年祭</strong>
      <span>3/14(土)・15(日) 開催</span>
    </span>
    <span class="p-anniv-float__btn">詳細はこちら</span>
  </a>
</div>
<script>
(function(){
  var STORAGE_KEY = 'annivFloatClosed';
  var floatEl = document.getElementById('annivFloat');
  var closeBtn = document.getElementById('annivFloatClose');
  if (!floatEl || !closeBtn) return;

  if (sessionStorage.getItem(STORAGE_KEY)) {
    floatEl.style.display = 'none';
    return;
  }

  var scrollThreshold = 300;
  var shown = false;

  function checkScroll() {
    if (shown) return;
    if (window.scrollY > scrollThreshold) {
      floatEl.classList.add('is-visible');
      shown = true;
    }
  }
  window.addEventListener('scroll', checkScroll, {passive: true});
  checkScroll();

  closeBtn.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    floatEl.classList.add('is-hidden');
    sessionStorage.setItem(STORAGE_KEY, '1');
  });
})();
</script>

<?php
get_footer();

