#!/bin/bash
# WordPressテーマディレクトリにファイルを同期するスクリプト

THEME_DIR="$HOME/Local Sites/minorihpwp/app/public/wp-content/themes/minorihp-theme"
SOURCE_DIR="$(pwd)"

echo "テーマファイルを同期しています..."

# 必要なファイルとディレクトリをコピー
rsync -av --exclude='node_modules' --exclude='.git' \
  --exclude='*.html' \
  --exclude='THEME_SETUP.md' \
  --exclude='WORDPRESS_SETUP.md' \
  "$SOURCE_DIR/" "$THEME_DIR/"

# WordPressテーマに必要なファイルをコピー
cp -f style.css functions.php index.php "$THEME_DIR/" 2>/dev/null || true

echo "同期が完了しました！"
echo "テーマディレクトリ: $THEME_DIR"

