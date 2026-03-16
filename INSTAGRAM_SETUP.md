# Instagramフィード実装ガイド（Smash Balloon使用）

## プラグインのインストール手順

1. WordPress管理画面にログイン
2. 「プラグイン」→「新規追加」をクリック
3. 検索バーに「Smash Balloon Instagram Feed」または「Social Photo Feed」と入力
4. 「今すぐインストール」をクリック
5. インストール後、「有効化」をクリック

## プラグインの設定手順

### 1. プラグインのセットアップ
1. WordPress管理画面のメニューから「Instagram Feed」をクリック
2. 「Connect an Instagram Account」をクリック
3. Instagramアカウントに接続（Facebookアカウント経由）
4. 最初のフィードを作成

### 2. フィードの設定
- 表示する投稿数: 6-12件推奨
- レイアウト: Grid（グリッド）を選択
- カラム数: 3列（デスクトップ）、2列（タブレット）、1列（モバイル）

### 3. 複数アカウントの設定
- **無料版の場合**: 1つのフィードのみ作成可能
- **有料版の場合**: 複数のフィードを作成可能（各アカウント用にフィードを作成）

## 実装方法

### 方法1: ショートコードを使用（推奨）

`front-page.php`でショートコードを使用してフィードを表示します。

```php
<?php echo do_shortcode('[instagram-feed]'); ?>
```

複数のフィードを表示する場合（有料版）:
```php
<?php echo do_shortcode('[instagram-feed feed=1]'); ?>  <!-- メインアカウント -->
<?php echo do_shortcode('[instagram-feed feed=2]'); ?>  <!-- インターパーク店 -->
```

### 方法2: ウィジェットを使用

「外観」→「ウィジェット」からInstagramフィードウィジェットを追加することも可能です。

## 無料版での対応方法

無料版では1つのフィードのみ作成可能ですが、以下の方法で対応できます：

### オプション1: メインアカウントのみ表示
- `noukanomiseminori`アカウントのみ表示
- インターパーク店は「もっと見る」リンクのみ

### オプション2: 2つのフィードを作成（手動切り替え）
- プラグイン設定で2つのフィードを作成
- プラグイン設定画面で手動でアカウントを切り替えてフィードを作成

## カスタマイズ

### CSSでのスタイリング
既存の`.p-instagram__grid`クラス内にフィードが表示されるため、プラグインのデフォルトスタイルと既存のCSSが競合する可能性があります。

必要に応じて以下のようなCSSを追加：
```css
.p-instagram__grid .sb-instagram-feed {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

@media (max-width: 768px) {
  .p-instagram__grid .sb-instagram-feed {
    grid-template-columns: repeat(2, 1fr);
  }
}
```

## 注意事項

- Instagram APIの利用制限に注意
- プラグインの更新を定期的に確認
- キャッシュプラグインを使用している場合、フィードの更新が反映されるまで時間がかかる場合あり

