# WordPress化 作業リスト

## ✅ 完了した作業

1. ✅ ローカル環境のセットアップ（Local by Flywheel）
2. ✅ WordPressのインストール
3. ✅ テーマディレクトリの準備
4. ✅ 基本的なテーマファイルの作成
   - style.css（テーマ情報ヘッダー付き）
   - functions.php（テーマ機能の定義）
   - header.php（ヘッダーテンプレート）
   - footer.php（フッターテンプレート）
   - index.php（メインテンプレート）
   - front-page.php（トップページ専用テンプレート）
5. ✅ プラグインのインストール
   - WP Multibyte Patch
   - Classic Editor
6. ✅ GitHubへのコミット・プッシュ

## 📋 次の作業（優先順位順）

### 優先度：高

#### 1. ページテンプレートの作成
- [ ] **page-about.php** - 会社概要ページ
  - about.htmlをWordPressテンプレートに変換
  - 固定ページとして作成

- [ ] **page-news.php** または **archive.php** - お知らせ一覧ページ
  - news.htmlをWordPressテンプレートに変換
  - 投稿一覧を表示

- [ ] **single.php** - お知らせ詳細ページ
  - news-detail.htmlをWordPressテンプレートに変換
  - 個別投稿を表示

- [ ] **page-shop.php** - 店舗一覧ページ
  - shop.htmlをWordPressテンプレートに変換
  - 店舗一覧を表示

- [ ] **single-shop.php** - 店舗詳細ページ
  - shop-detail.htmlをWordPressテンプレートに変換
  - 個別店舗を表示

#### 2. WordPress管理画面での設定
- [ ] **メニューの作成・設定**
  - 「外観」→「メニュー」でメニューを作成
  - プライマリーメニューに割り当て
  - メニュー項目：トップ、会社概要、お知らせ、店舗一覧、募集要項

- [ ] **固定ページの作成**
  - 会社概要ページ
  - 店舗一覧ページ（必要に応じて）

#### 3. カスタム投稿タイプ・カスタムフィールド
- [ ] **カスタム投稿タイプの作成**
  - 店舗情報用のカスタム投稿タイプ（Custom Post Type UI使用）
  - または、ACFで固定ページとして管理

- [ ] **Advanced Custom Fields（ACF）の設定**
  - 店舗情報のカスタムフィールド（住所、電話番号、営業時間など）
  - 商品情報のカスタムフィールド（必要に応じて）

### 優先度：中

#### 4. 機能の実装
- [ ] **お知らせ機能の実装**
  - 投稿カテゴリーの設定（お知らせ、イベント、採用など）
  - 投稿タグの設定（必要に応じて）
  - 投稿一覧の表示（front-page.phpのニュースセクション）

- [ ] **Instagram連携の実装**
  - Instagram API連携
  - または、埋め込みコードの動的生成

- [ ] **お問い合わせフォームの実装**
  - Contact Form 7のインストール・設定
  - フォームの作成・配置

#### 5. SEO・最適化
- [x] **SEO設定**
  - Yoast SEOのインストール・設定 ✅
  - メタタグ、OGP、構造化データの確認 ✅
  - サイトマップの設定 ✅
  - header.phpの手動OGP/メタタグをYoast SEOに統合 ✅
  - タイトル・メタディスクリプションの最適化 ✅

- [ ] **画像パスの確認・修正**
  - すべての画像パスが`get_template_directory_uri()`を使用しているか確認
  - 相対パスを絶対パスに変換

### 優先度：低

#### 6. 動作確認・テスト
- [ ] **JavaScriptの動作確認**
  - main.jsの動作確認
  - shop-detail.jsの動作確認
  - about-text-animations.jsの動作確認
  - WordPress環境での動作確認

- [ ] **レスポンシブデザインの確認**
  - モバイル、タブレット、デスクトップでの表示確認
  - メニューの動作確認

- [ ] **クロスブラウザテスト**
  - Chrome、Firefox、Safari、Edgeでの動作確認

#### 7. パフォーマンス最適化
- [ ] **画像の最適化**
  - 画像の圧縮
  - WebP形式への変換（必要に応じて）

- [ ] **キャッシュ設定**
  - WP Super Cacheのインストール・設定
  - または、W3 Total Cache

## 📝 作業の進め方

### 次のステップ（推奨順序）

1. **メニューの設定**（すぐにできる）
   - WordPress管理画面でメニューを作成
   - プライマリーメニューに割り当て

2. **会社概要ページの作成**
   - page-about.phpを作成
   - 固定ページを作成してテンプレートを割り当て

3. **お知らせ機能の実装**
   - 投稿カテゴリーの設定
   - archive.phpとsingle.phpの作成
   - テスト投稿の作成

4. **店舗情報の実装**
   - カスタム投稿タイプまたは固定ページで管理
   - ACFでカスタムフィールドを設定
   - page-shop.phpとsingle-shop.phpの作成

5. **その他の機能**
   - Instagram連携
   - お問い合わせフォーム
   - SEO設定

## 🔧 技術的な注意点

- すべての画像パスは`get_template_directory_uri()`を使用
- リンクは`home_url()`や`get_permalink()`を使用
- エスケープ処理（`esc_url()`, `esc_attr()`, `esc_html()`）を適切に使用
- カスタム投稿タイプのスラッグは英語で設定

## 📚 参考資料

- WORDPRESS_SETUP.md - WordPress化のセットアップガイド
- THEME_SETUP.md - テーマディレクトリの準備手順
- RECOMMENDED_PLUGINS.md - 推奨プラグイン一覧


ページテンプレートの作成（about.html, news.html, shop.html等をWordPressテンプレートに変換）
会社概要ページテンプレート（page-about.php）の作成
お知らせ一覧ページテンプレート（archive.php または page-news.php）の作成
お知らせ詳細ページテンプレート（single.php）の作成
店舗一覧ページテンプレート（page-shop.php）の作成
店舗詳細ページテンプレート（single-shop.php）の作成
WordPress管理画面でメニューを作成・設定（プライマリーメニュー）
カスタム投稿タイプの作成（店舗情報など）
Advanced Custom Fields（ACF）の設定（店舗情報、商品情報などのカスタムフィールド）
お知らせ機能の実装（投稿タイプ、カテゴリー、タグの設定）
Instagram連携の実装（API連携または埋め込み）
お問い合わせフォームの実装（Contact Form 7の設定）
SEO設定（Yoast SEOの設定、構造化データの確認）
画像パスの確認・修正（get_template_directory_uri()の使用確認）
JavaScriptの動作確認・修正（WordPress環境での動作確認）
レスポンシブデザインの動作確認
クロスブラウザテスト（Chrome, Firefox, Safari, Edge）
パフォーマンス最適化（画像最適化、キャッシュ設定など）
