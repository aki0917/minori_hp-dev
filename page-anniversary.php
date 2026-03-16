<?php
/**
 * Template Name: 4周年祭LP
 * Description: みのり花木センター インターパーク店 4周年祭ランディングページ
 *
 * @package Minorihp
 */

get_header();
$template_uri = get_template_directory_uri();
?>

<!-- ========================================
     4周年祭 LP
     ======================================== -->

<!-- ページ内ナビゲーション（固定） -->
<nav class="anniv-nav" id="annivNav" aria-label="ページ内ナビゲーション">
  <div class="anniv-nav__inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="anniv-nav__home">
      <span class="anniv-nav__home-text">サイトTOP</span>
    </a>
    <span class="anniv-nav__divider" aria-hidden="true"></span>
    <ul class="anniv-nav__list">
      <li class="anniv-nav__item"><a href="#anniv-hero" class="anniv-nav__link">TOP</a></li>
      <li class="anniv-nav__item"><a href="#anniv-exhibition" class="anniv-nav__link">展示・実演会</a></li>
      <li class="anniv-nav__item"><a href="#anniv-events" class="anniv-nav__link">イベント</a></li>
      <li class="anniv-nav__item"><a href="#anniv-sales" class="anniv-nav__link">特売情報</a></li>
      <li class="anniv-nav__item"><a href="#anniv-access" class="anniv-nav__link">アクセス</a></li>
    </ul>
  </div>
</nav>

<main class="anniv-main">

  <!-- ============================================
       ヒーローセクション
       ============================================ -->
  <section class="anniv-hero" id="anniv-hero">
    <div class="anniv-hero__bg-image" aria-hidden="true"></div>
    <div class="anniv-hero__bg-overlay" aria-hidden="true"></div>
    <div class="anniv-hero__bg">
      <div class="anniv-hero__petals" aria-hidden="true">
        <span class="anniv-hero__petal anniv-hero__petal--1"></span>
        <span class="anniv-hero__petal anniv-hero__petal--2"></span>
        <span class="anniv-hero__petal anniv-hero__petal--3"></span>
        <span class="anniv-hero__petal anniv-hero__petal--4"></span>
        <span class="anniv-hero__petal anniv-hero__petal--5"></span>
        <span class="anniv-hero__petal anniv-hero__petal--6"></span>
        <span class="anniv-hero__petal anniv-hero__petal--7"></span>
        <span class="anniv-hero__petal anniv-hero__petal--8"></span>
      </div>
      <div class="anniv-hero__confetti" aria-hidden="true">
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--1"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--2"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--3"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--4"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--5"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--6"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--7"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--8"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--9"></span>
        <span class="anniv-hero__confetti-piece anniv-hero__confetti-piece--10"></span>
      </div>
    </div>
    <div class="anniv-hero__content">
      <p class="anniv-hero__store">みのり花木センター インターパーク店</p>
      <h1 class="anniv-hero__title">
        <span class="anniv-hero__title-num">4</span>
        <span class="anniv-hero__title-text">周年祭</span>
      </h1>
      <div class="anniv-hero__date">
        <div class="anniv-hero__date-main">
          <span class="anniv-hero__date-month">3</span>
          <span class="anniv-hero__date-slash">/</span>
          <span class="anniv-hero__date-days">14<small>（土）</small>・15<small>（日）</small></span>
        </div>
        <div class="anniv-hero__date-time">(土)9:00〜16:00</div>
        <div class="anniv-hero__date-time">(日)9:00〜15:00</div>
        <p class="anniv-hero__date-note">※店舗営業は 9:00〜18:00</p>
      </div>
      <div class="anniv-hero__badges">
        <span class="anniv-hero__badge anniv-hero__badge--lottery">大抽選会</span>
        <span class="anniv-hero__badge anniv-hero__badge--food">屋台グルメ</span>
        <span class="anniv-hero__badge anniv-hero__badge--sale">超特価セール</span>
      </div>
      <a href="#anniv-exhibition" class="anniv-hero__scroll" aria-label="下にスクロール">
        <span class="anniv-hero__scroll-arrow"></span>
      </a>
    </div>
  </section>

  <!-- ウェーブ区切り -->
  <div class="anniv-wave" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60" preserveAspectRatio="none">
      <path fill="#FFF8E1" d="M0,20 C240,60 480,0 720,30 C960,60 1200,0 1440,20 L1440,60 L0,60 Z"/>
    </svg>
  </div>

  <!-- ============================================
       イベント概要
       ============================================ -->
  <section class="anniv-overview" id="anniv-overview">
    <div class="anniv-overview__inner">
      <h2 class="anniv-section-title">
        <span class="anniv-section-title__en">ANNIVERSARY</span>
        <span class="anniv-section-title__ja">おかげさまで4周年</span>
      </h2>
      <p class="anniv-overview__text">
        みのり花木センター インターパーク店は、おかげさまで4周年を迎えることができました。<br>
        日頃のご愛顧に感謝を込めて、<strong>展示・実演会</strong>や<strong>大抽選会</strong>、<strong>超特価セール</strong>、<strong>屋台グルメ</strong>など、<br class="anniv-u-pc">
        楽しいイベントを2日間にわたって開催いたします。<br>
        ぜひご家族・ご友人お誘い合わせの上、お越しください！
      </p>
      <div class="anniv-overview__highlights">
        <div class="anniv-overview__highlight">
          <div class="anniv-overview__highlight-icon">🌸</div>
          <h3 class="anniv-overview__highlight-title">両日各200名様</h3>
          <p class="anniv-overview__highlight-text">花苗プレゼント <br>※1000円以上のお買い上げでプレゼント<br>なくなり次第終了となります。</p>
        </div>
        <div class="anniv-overview__highlight">
          <div class="anniv-overview__highlight-icon">🎁</div>
          <h3 class="anniv-overview__highlight-title">大抽選会</h3>
          <p class="anniv-overview__highlight-text">豪華賞品が当たる！</p>
        </div>
        <div class="anniv-overview__highlight">
          <div class="anniv-overview__highlight-icon">🍖</div>
          <h3 class="anniv-overview__highlight-title">屋台多数出店</h3>
          <p class="anniv-overview__highlight-text">グルメも充実！</p>
        </div>
      </div>
    </div>
  </section>

  <!-- フォトバナー -->
  <div class="anniv-photo-banner anniv-photo-banner--bara">
    <div class="anniv-photo-banner__bg" aria-hidden="true"></div>
    <div class="anniv-photo-banner__overlay" aria-hidden="true"></div>
    <div class="anniv-photo-banner__content">
      <p class="anniv-photo-banner__text">楽しいイベント盛りだくさん！</p>
      <p class="anniv-photo-banner__sub">大抽選会・縁日・屋台グルメ</p>
    </div>
  </div>

  <!-- ============================================
       わくわくイベント
       ============================================ -->
  <section class="anniv-section anniv-events" id="anniv-events">
    <div class="anniv-section__inner">
      <h2 class="anniv-section-title">
        <span class="anniv-section-title__en">EVENTS</span>
        <span class="anniv-section-title__ja">わくわくイベント</span>
      </h2>

      <div class="anniv-events__grid">

        <!-- 大抽選会 -->
        <div class="anniv-event-card anniv-event-card--featured anniv-rainbow-border">
          <div class="anniv-event-card__ribbon">目玉</div>
          <h3 class="anniv-event-card__title">🎯 大抽選会</h3>
          <p class="anniv-event-card__subtitle">豪華賞品が当たる！！</p>
          <p class="anniv-event-card__text">各店舗で配布される案内状、または当日1,000円（税込）以上のお買い上げレシートで抽選に参加できます。</p>
          <p class="anniv-event-card__note">※詳細はInstagramでもご確認いただけます</p>
        </div>

        <!-- じゃんけん大会 -->
        <div class="anniv-event-card">
          <h3 class="anniv-event-card__title">✊ じゃんけん大会</h3>
          <div class="anniv-event-card__time">14:30 開始</div>
          <p class="anniv-event-card__text">どなたでも参加可能！<br>勝ち残った方には豪華賞品をプレゼント！</p>
          <p class="anniv-event-card__note">※雨天中止の場合あり</p>
        </div>

        <!-- 縁日 -->
        <div class="anniv-event-card">
          <h3 class="anniv-event-card__title">🏮 縁日</h3>
          <p class="anniv-event-card__text">楽しい縁日イベント盛りだくさん！<br>お子さまも楽しめます。</p>
        </div>

        <!-- みやどん -->
        <div class="anniv-event-card">
          <h3 class="anniv-event-card__title">⭐ みやどんがやってくる！</h3>
          <p class="anniv-event-card__text">うつのみや花火大会公式キャラクター<br>「みやどん」が遊びに来ます！</p>
        </div>

        <!-- ポニー -->
        <div class="anniv-event-card">
          <h3 class="anniv-event-card__title">🐴 ポニー引き馬・おやつあげ</h3>
          <p class="anniv-event-card__text">お子さまに大人気！<br>かわいいポニーに乗ったり、おやつをあげたりできます。</p>
          <p class="anniv-event-card__note">※15日（日）のみとなります</p>
        </div>

        <!-- 花苗プレゼント -->
        <div class="anniv-event-card anniv-event-card--highlight anniv-rainbow-border">
          <h3 class="anniv-event-card__title">🌸 花苗プレゼント</h3>
          <p class="anniv-event-card__subtitle">両日各200名様</p>
          <p class="anniv-event-card__text">※1000円以上のお買い上げでプレゼント<br>なくなり次第終了となります。</p>
        </div>

      </div>

      <!-- グルメ -->
      <div class="anniv-food">
        <h3 class="anniv-food__title">
          <span class="anniv-food__title-icon">🍽</span>
          グルメ・屋台
        </h3>
        <div class="anniv-food__grid">
          <div class="anniv-food__item">
            <div class="anniv-food__item-name">豚汁</div>
            <div class="anniv-food__item-detail">約200食｜1杯100円</div>
            <div class="anniv-food__item-note">11:00提供開始（先着順）</div>
            <div class="anniv-food__item-note">※当日のお買い上げレシート持参で<br>1杯無料(お一人様1杯まで)<br>なくなり次第終了となります。</div>
          </div>
          <div class="anniv-food__item">
            <div class="anniv-food__item-name">おかあさん食堂ほし野</div>
            <div class="anniv-food__item-detail">かけそば・かけうどん <br> カレー・焼きそば・フランクフルト</div>
          </div>
          <div class="anniv-food__item">
            <div class="anniv-food__item-name">鮎の塩焼き</div>
            <div class="anniv-food__item-detail">焼きたてをお楽しみいただけます</div>
          </div>
          <div class="anniv-food__item">
            <div class="anniv-food__item-name">屋台多数出店！</div>
            <div class="anniv-food__item-detail">その他にもお楽しみがいっぱい</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ウェーブ区切り -->
  <div class="anniv-wave" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60" preserveAspectRatio="none">
      <path fill="#FCE4EC" d="M0,20 C240,50 480,10 720,35 C960,55 1200,15 1440,30 L1440,60 L0,60 Z"/>
    </svg>
  </div>

  <!-- ============================================
       特売情報
       ============================================ -->
  <section class="anniv-section anniv-sales" id="anniv-sales">
    <div class="anniv-section__inner">
      <h2 class="anniv-section-title">
        <span class="anniv-section-title__en">SPECIAL SALE</span>
        <span class="anniv-section-title__ja">特売情報</span>
      </h2>

      <div class="anniv-sales__grid">

        <!-- 花・観葉・多肉 -->
        <div class="anniv-sale-card">
          <div class="anniv-sale-card__tag">お宝発見！</div>
          <h3 class="anniv-sale-card__title">花・観葉・多肉</h3>
          <p class="anniv-sale-card__text">超特価品販売！目玉商品のPOPが目印！</p>
          <ul class="anniv-sale-card__list">
            <li><strong>希少品</strong>：多肉・サボテン・アガベ</li>
            <li>観葉植物限定販売</li>
          </ul>
        </div>

        <!-- 花木・盆栽 -->
        <div class="anniv-sale-card">
          <h3 class="anniv-sale-card__title">花木・盆栽</h3>
          <ul class="anniv-sale-card__list">
            <li>ドライガーデン（アガベ、ソテツ）</li>
            <li>オリーブなどシンボルツリー販売</li>
            <li>季節の花木、盆栽各種販売</li>
            <li>豊富な品揃え</li>
          </ul>
        </div>

        <!-- 及川クレマチス -->
        <div class="anniv-sale-card anniv-sale-card--limited">
          <div class="anniv-sale-card__tag">数量限定</div>
          <h3 class="anniv-sale-card__title">及川クレマチス</h3>
          <p class="anniv-sale-card__text">14日（土） 8:50より東側入場口にて整理券30枚配布</p>
          <p class="anniv-sale-card__sub">※購入は整理券1枚につき1点まで</p>
          <p class="anniv-sale-card__sub">※詳細はインスタグラムでお知らせします</p>
          </p>
        </div>

        <!-- クリスマスローズ -->
        <div class="anniv-sale-card anniv-sale-card--limited">
          <div class="anniv-sale-card__tag">数量限定</div>
          <h3 class="anniv-sale-card__title">クリスマスローズ</h3>
          <p class="anniv-sale-card__text">超特価販売！在庫限りの特別価格でご提供</p>
          <p class="anniv-sale-card__sub">※当社指定品・なくなり次第終了</p>
        </div>

        <!-- 切花 -->
        <div class="anniv-sale-card anniv-sale-card--price">
          <h3 class="anniv-sale-card__title">切花</h3>
          <p class="anniv-sale-card__text">切花バイキング</p>
          <div class="anniv-sale-card__price">
            <span class="anniv-sale-card__price-old">通常 5本 450円</span>
            <span class="anniv-sale-card__price-arrow">→</span>
            <span class="anniv-sale-card__price-new">周年祭特別価格 <strong>5本 400円</strong></span>
          </div>
        </div>

        <!-- ガーデン用品 -->
        <div class="anniv-sale-card">
          <h3 class="anniv-sale-card__title">ガーデン用品</h3>
          <p class="anniv-sale-card__text">期間中は超わくわく価格の商品も多数販売！</p>
          <ul class="anniv-sale-card__list">
            <li>オシャレ鉢・ガーデン雑貨</li>
            <li>専用培養土・園芸肥料</li>
          </ul>
        </div>

        <!-- 肥料・農薬・機械 -->
        <div class="anniv-sale-card">
          <h3 class="anniv-sale-card__title">肥料・農薬・機械</h3>
          <p class="anniv-sale-card__text">プロから家庭菜園まで</p>
          <ul class="anniv-sale-card__list">
            <li>野菜・水稲用肥料</li>
            <li>農薬</li>
            <li>管理機や噴霧器など</li>
          </ul>
        </div>

        <!-- 直売所コーナー -->
        <div class="anniv-sale-card anniv-sale-card--market">
          <div class="anniv-sale-card__tag">目玉</div>
          <h3 class="anniv-sale-card__title">直売所コーナー</h3>
          <ul class="anniv-sale-card__list">
            <li><strong>数量限定</strong> イートミ-サンドイッチ出張販売</li>
            <li><strong>ひとみいちご農園</strong>とちあいか・とちおとめ販売</li>
            <li><strong>大人気</strong> 古山さんの打ちたてそば販売</li>
            <li>野菜の詰め放題 <strong>1回500円</strong></li>
            <li>千本松牧場 商品詰合せ</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- フォトバナー -->
  <div class="anniv-photo-banner anniv-photo-banner--flower">
    <div class="anniv-photo-banner__bg" aria-hidden="true"></div>
    <div class="anniv-photo-banner__overlay" aria-hidden="true"></div>
    <div class="anniv-photo-banner__content">
      <p class="anniv-photo-banner__text">見て、触れて、体験しよう！</p>
      <p class="anniv-photo-banner__sub">展示・実演会・出展多数</p>
    </div>
  </div>

    <!-- ============================================
       展示・実演会・出展内容
       ============================================ -->
       <section class="anniv-section anniv-exhibition" id="anniv-exhibition">
    <div class="anniv-section__inner">
      <h2 class="anniv-section-title">
        <span class="anniv-section-title__en">EXHIBITION</span>
        <span class="anniv-section-title__ja">展示・実演会・出展内容</span>
      </h2>

      <!-- 機械・自動車 -->
      <div class="anniv-category">
        <h3 class="anniv-category__title">
          <span class="anniv-category__icon">🚗</span>
          機械・自動車
        </h3>
        <div class="anniv-category__grid">
          <div class="anniv-card">
            <div class="anniv-card__header">栃木トヨペット / Honda Cars 栃木</div>
            <p class="anniv-card__text">新車・中古車展示販売</p>
            <p class="anniv-card__note">※ホンダカーズは14日のみとなります</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">TOYOTA L&amp;F</div>
            <p class="anniv-card__text">トヨタフォークリフト展示販売</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">ジャパンアグリサービス</div>
            <p class="anniv-card__text">農業用ドローン展示販売</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">TAKEI</div>
            <p class="anniv-card__text">トラクターなど大型機械展示販売</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">シンセイ</div>
            <p class="anniv-card__text">ハンディチェーンソー・紙マルチ・新商品の販売・紹介</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">YAMABIKO</div>
            <p class="anniv-card__text">バッテリー式草刈機・芝刈り機</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">KOSHIN</div>
            <p class="anniv-card__text">噴霧器など各種小型機械</p>
          </div>
        </div>
        <p class="anniv-category__note">※その他、ハンディエリソーや紐マルチ、新商品の販売・紹介など多数展示・販売（雨天中止の場合あり）</p>
      </div>

      <!-- サービス事業 -->
      <div class="anniv-category">
        <h3 class="anniv-category__title">
          <span class="anniv-category__icon">🔧</span>
          サービス事業
        </h3>
        <div class="anniv-category__grid">
          <div class="anniv-card">
            <div class="anniv-card__header">住まいの相談</div>
            <p class="anniv-card__text">湿気・結露対策相談、シロアリ防除・防腐・防カビ</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">物置・建物</div>
            <p class="anniv-card__text">物置・コンテナハウス・仮設トイレ・2重ガラスの紹介</p>
          </div>
        </div>
      </div>

      <!-- 種苗・園芸 -->
      <div class="anniv-category">
        <h3 class="anniv-category__title">
          <span class="anniv-category__icon">🌱</span>
          種苗・園芸相談会
        </h3>
        <div class="anniv-category__grid">
          <div class="anniv-card">
            <div class="anniv-card__header">タキイ厳選カンキツ苗販売</div>
            <p class="anniv-card__text">厳選されたタキイのカンキツ苗を特別価格で販売</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">タキイオリジナル花苗販売</div>
            <p class="anniv-card__text">タキイオリジナルの花苗をご用意</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">みのり×タキイ コラボ商品</div>
            <p class="anniv-card__text">植物を環境に強く育てる液肥<br>「ぐんぐん育つみのりくん」</p>
          </div>
          <div class="anniv-card anniv-card--accent">
            <div class="anniv-card__header">園芸相談会</div>
            <p class="anniv-card__text">薬品や肥料などガーデニングのお悩み相談会<br>お気軽にご相談ください！</p>
          </div>
        </div>
      </div>

      <!-- 店内ブース -->
      <div class="anniv-category">
        <h3 class="anniv-category__title">
          <span class="anniv-category__icon">🏪</span>
          店内ブース
        </h3>
        <div class="anniv-category__grid">
          <div class="anniv-card">
            <div class="anniv-card__header">ガーデン管理用品</div>
            <p class="anniv-card__text">ガーデニングに必要な管理用品を多数展示</p>
          </div>
          <div class="anniv-card">
            <div class="anniv-card__header">作業用ウェア</div>
            <p class="anniv-card__text">農作業・ガーデニングに最適な作業着</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ウェーブ区切り -->
  <div class="anniv-wave" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60" preserveAspectRatio="none">
      <path fill="#E0F2F1" d="M0,40 C180,10 360,50 540,30 C720,10 900,50 1080,25 C1260,5 1380,45 1440,30 L1440,60 L0,60 Z"/>
    </svg>
  </div>

  <!-- ============================================
       店舗情報・アクセス
       ============================================ -->
  <section class="anniv-section anniv-access" id="anniv-access">
    <div class="anniv-section__inner">
      <h2 class="anniv-section-title">
        <span class="anniv-section-title__en">ACCESS</span>
        <span class="anniv-section-title__ja">店舗情報・アクセス</span>
      </h2>

      <div class="anniv-access__content">
        <div class="anniv-access__info">
          <div class="anniv-access__store-name">
            <span class="anniv-access__brand">みのり花木センター</span>
            <h3>花木センター インターパーク店</h3>
            <p class="anniv-access__former">（旧：うつのみや 緑花木センター）</p>
          </div>
          <dl class="anniv-access__details">
            <div class="anniv-access__detail-row">
              <dt>住所</dt>
              <dd>〒321-0918 栃木県宇都宮市平塚町307-1</dd>
            </div>
            <div class="anniv-access__detail-row">
              <dt>電話</dt>
              <dd><a href="tel:028-656-7193">028-656-7193</a></dd>
            </div>
            <div class="anniv-access__detail-row">
              <dt>イベント開催日</dt>
              <dd>2026年3月14日（土）・15日（日）</dd>
            </div>
            <div class="anniv-access__detail-row">
              <dt>イベント時間</dt>
              <dd>(土)9:00〜16:00</dd>
              <dd>(日)9:00〜15:00</dd>
            </div>
            <div class="anniv-access__detail-row">
              <dt>店舗営業時間</dt>
              <dd>14日 9:00〜18:00 ／ 15日 9:00〜18:00</dd>
            </div>
          </dl>
          <div class="anniv-access__sns">
            <a href="https://www.instagram.com/minori_kaboku_interpark/" target="_blank" rel="noopener noreferrer" class="anniv-access__sns-link anniv-access__sns-link--instagram">
              <img src="<?php echo esc_url( $template_uri . '/assets/icon/icon_instagram.svg' ); ?>" alt="Instagram" width="24" height="24">
              <span>Instagram</span>
            </a>
            <a href="https://lin.ee/Ri3brQ9" target="_blank" rel="noopener noreferrer" class="anniv-access__sns-link anniv-access__sns-link--line">
              <img src="<?php echo esc_url( $template_uri . '/assets/icon/icon_line.svg' ); ?>" alt="LINE" width="24" height="24">
              <span>LINE</span>
            </a>
          </div>
        </div>
        <div class="anniv-access__map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3207.5264813661656!2d139.9127583753004!3d36.4931513849485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601f5c6b1dfc6595%3A0xaf4c3be535042198!2z44CM44G_44Gu44KK44CN6Iqx5pyo44K744Oz44K_44O8IOOCpOODs-OCv-ODvOODkeODvOOCr-W6lw!5e0!3m2!1sja!2sjp!4v1771224768615!5m2!1sja!2sjp" 
            width="100%"
            height="400"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="みのり花木センター インターパーク店 地図"
          ></iframe>
        </div>
      </div>
    </div>
  </section>
  

  <!-- ウェーブ区切り -->
  <div class="anniv-wave" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60" preserveAspectRatio="none">
      <path fill="#2E7D32" d="M0,25 C240,55 480,5 720,35 C960,60 1200,10 1440,30 L1440,60 L0,60 Z"/>
    </svg>
  </div>

  <!-- ============================================
       CTA（コール トゥ アクション）
       ============================================ -->
  <section class="anniv-cta">
    <div class="anniv-cta__inner">
      <h2 class="anniv-cta__title">ご来場お待ちしております！</h2>
      <p class="anniv-cta__date">
        2026年 <strong>3月14日（土）・15日（日）</strong>
        <br>(土)9:00〜16:00<br>(日)9:00〜15:00
      </p>
      <div class="anniv-cta__buttons">
        <a href="https://www.instagram.com/minori_kaboku_interpark/" target="_blank" rel="noopener noreferrer" class="anniv-cta__button anniv-cta__button--instagram">
          Instagramで最新情報をチェック
        </a>
        <a href="tel:028-656-7193" class="anniv-cta__button anniv-cta__button--tel">
          お問い合わせ 028-656-7193
        </a>
      </div>
    </div>
  </section>

</main>

<!-- ページ内スムーススクロール -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // スムーススクロール
  document.querySelectorAll('.anniv-nav__link, .anniv-hero__scroll').forEach(function(link) {
    link.addEventListener('click', function(e) {
      var href = this.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        var target = document.querySelector(href);
        if (target) {
          var navHeight = document.querySelector('.anniv-nav') ? document.querySelector('.anniv-nav').offsetHeight : 0;
          var top = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
          window.scrollTo({ top: top, behavior: 'smooth' });
        }
      }
    });
  });

  // スクロール時のアクティブ状態
  var nav = document.getElementById('annivNav');
  var sections = document.querySelectorAll('.anniv-section, .anniv-hero, .anniv-events');
  var navLinks = document.querySelectorAll('.anniv-nav__link');

  function onScroll() {
    var scrollPos = window.pageYOffset;
    var navHeight = nav ? nav.offsetHeight : 0;
    var offset = navHeight + 100;

    sections.forEach(function(section) {
      var top = section.offsetTop - offset;
      var bottom = top + section.offsetHeight;
      var id = section.getAttribute('id');
      if (scrollPos >= top && scrollPos < bottom) {
        navLinks.forEach(function(link) {
          link.classList.remove('is-active');
          if (link.getAttribute('href') === '#' + id) {
            link.classList.add('is-active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // フェードインアニメーション
  var observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.anniv-card, .anniv-event-card, .anniv-sale-card, .anniv-food__item, .anniv-overview__highlight').forEach(function(el) {
    observer.observe(el);
  });
});
</script>

<?php
get_footer();
