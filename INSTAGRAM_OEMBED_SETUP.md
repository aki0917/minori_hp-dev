# Instagram oEmbed実装ガイド

## 概要

Instagram Graph APIを使わず、Instagram公式oEmbedを使用して投稿を表示する実装です。

**メリット：**
- ✅ トークン管理不要
- ✅ Meta仕様変更の影響を受けにくい
- ✅ セキュリティリスクが低い
- ✅ 実装がシンプル
- ✅ メンテナンスが容易

## ACFフィールド設定

### フィールドグループの作成

1. WordPress管理画面にログイン
2. 「カスタムフィールド」→「フィールドグループを追加」をクリック
3. フィールドグループ名を「Instagram表示設定」に設定

### 表示ルールの設定

- **表示条件**: 固定ページ = トップページ（または `front-page.php` を使用するページ）

### フィールド定義

#### メインアカウント用フィールド

**フィールド①**
- **ラベル**: Instagram 投稿 URL ①（メイン）
- **フィールド名**: `instagram_post_url_main_1`
- **タイプ**: URL
- **必須**: いいえ

**フィールド②**
- **ラベル**: Instagram 投稿 URL ②（メイン）
- **フィールド名**: `instagram_post_url_main_2`
- **タイプ**: URL
- **必須**: いいえ

**フィールド③**
- **ラベル**: Instagram 投稿 URL ③（メイン）
- **フィールド名**: `instagram_post_url_main_3`
- **タイプ**: URL
- **必須**: いいえ

#### インターパーク店アカウント用フィールド

**フィールド④**
- **ラベル**: Instagram 投稿 URL ①（インターパーク店）
- **フィールド名**: `instagram_post_url_interpark_1`
- **タイプ**: URL
- **必須**: いいえ

**フィールド⑤**
- **ラベル**: Instagram 投稿 URL ②（インターパーク店）
- **フィールド名**: `instagram_post_url_interpark_2`
- **タイプ**: URL
- **必須**: いいえ

**フィールド⑥**
- **ラベル**: Instagram 投稿 URL ③（インターパーク店）
- **フィールド名**: `instagram_post_url_interpark_3`
- **タイプ**: URL
- **必須**: いいえ

### フィールドの順序

フィールドを以下の順序で配置することを推奨：

1. Instagram 投稿 URL ①（メイン）
2. Instagram 投稿 URL ②（メイン）
3. Instagram 投稿 URL ③（メイン）
4. Instagram 投稿 URL ①（インターパーク店）
5. Instagram 投稿 URL ②（インターパーク店）
6. Instagram 投稿 URL ③（インターパーク店）

## 実装の詳細

### ファイル構成

```
front-page.php                    # トップページテンプレート（Instagramセクション）
scss/object/project/_instagram.scss # Instagramセクションのスタイル
```

### PHP実装

`front-page.php`のInstagramセクションでは、以下のように実装されています：

```php
<?php
// メインアカウントの投稿URLを取得
$main_urls = array();
if ( function_exists( 'get_field' ) ) {
  $main_urls = array_filter( array(
    get_field( 'instagram_post_url_main_1' ),
    get_field( 'instagram_post_url_main_2' ),
    get_field( 'instagram_post_url_main_3' ),
  ) );
}
?>

<?php if ( ! empty( $main_urls ) ) : ?>
  <div class="p-instagram__list">
    <?php foreach ( $main_urls as $url ) : ?>
      <?php
      // Instagram公式oEmbedを使用して埋め込みコードを取得
      $embed_code = wp_oembed_get( $url );
      if ( $embed_code ) :
        ?>
        <div class="p-instagram__item">
          <?php echo $embed_code; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
```

### CSS実装

oEmbed用のスタイルは `scss/object/project/_instagram.scss` に追加されています：

```scss
// oEmbed用のリスト（Instagram公式埋め込み）
&__list {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: $spacing-medium;
  margin-bottom: $spacing-xl;

  @include up(tab) {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: $spacing-large;
    margin-bottom: $spacing-xxl;
  }

  @include up(pc) {
    gap: $spacing-xl;
  }
}

&__item {
  // oEmbed用のスタイル（Instagram公式埋め込みiframe）
  iframe {
    width: 100% !important;
    max-width: 100%;
    border-radius: 12px;
    display: block;

    @include up(tab) {
      border-radius: 16px;
    }
  }
}
```

## 運用方法

### 1. Instagram投稿のURLを取得

1. InstagramアプリまたはWebブラウザで投稿を開く
2. 投稿のURLをコピー
   - 形式: `https://www.instagram.com/p/XXXX/`
   - リールも可: `https://www.instagram.com/reel/XXXX/`

### 2. WordPress管理画面でURLを設定

1. WordPress管理画面にログイン
2. 「固定ページ」→「トップページ」を編集
3. ACFフィールド「Instagram表示設定」セクションを開く
4. 各フィールドに投稿URLを貼り付け
5. 「更新」をクリック

### 3. 表示確認

1. トップページにアクセス
2. Instagramセクションに投稿が表示されることを確認

## 注意事項

### 投稿URLの形式

- ✅ 有効な形式: `https://www.instagram.com/p/XXXX/`
- ✅ リール: `https://www.instagram.com/reel/XXXX/`
- ❌ 非公開アカウントの投稿は表示されません
- ❌ 削除された投稿は表示されません

### 表示されない場合の確認事項

1. **URLが正しいか確認**
   - URLが `https://www.instagram.com/p/XXXX/` の形式か確認
   - 末尾のスラッシュ（`/`）はあってもなくても可

2. **投稿が公開されているか確認**
   - 非公開アカウントの投稿は表示されません
   - 投稿が削除されていないか確認

3. **ACFフィールドが正しく設定されているか確認**
   - フィールド名が正しいか確認
   - 表示ルールが正しく設定されているか確認

4. **キャッシュをクリア**
   - WordPressのキャッシュプラグインをクリア
   - ブラウザのキャッシュをクリア

### oEmbedの制限

- Instagram公式oEmbedで取得されるiframeのサイズやスタイルは、Instagram側で制御されます
- レスポンシブ対応は自動的に行われます
- カスタムスタイルの適用は限定的です

## クライアント説明用コメント

Instagram投稿の表示については、セキュリティと安定性を優先し、Instagram公式の埋め込み機能を使用しています。これにより、仕様変更や不具合の影響を最小限に抑えています。

## 将来拡張（必要になったら）

- Smash Balloon などAPIプラグインの検討
- 専用API用Instagramアカウントの新設
- 投稿数の増減（現在は各アカウント3件）

※ 本構成は差し替え前提で安全に運用可能です。

## 完了条件

- ✅ トップページにInstagram投稿が表示される
- ✅ 管理画面からURLを変更すると即反映される
- ✅ API / トークンを一切使用していない
- ✅ 2つのアカウント（メイン・インターパーク店）に対応

## 参考リンク

- [WordPress oEmbed ドキュメント](https://wordpress.org/support/article/embeds/)
- [Instagram oEmbed エンドポイント](https://www.instagram.com/developer/embedding/)
