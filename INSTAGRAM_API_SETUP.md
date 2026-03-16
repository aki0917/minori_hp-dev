# Instagram Graph API実装ガイド

## 概要

Instagram Graph APIを使用して、2つのInstagramアカウントの投稿をサイトに表示します。

## 必要な準備

### 1. Instagramアカウントの準備
- Instagramアカウントを「ビジネス」または「クリエーター」アカウントに変更
  - 設定 → アカウント → プロフェッショナルアカウントに切り替え

### 2. Facebook開発者アカウントの作成
1. [Facebook開発者](https://developers.facebook.com/)にアクセス
2. 「開始する」をクリックして開発者アカウントを作成
3. Facebookアカウントでログイン

### 3. Facebookアプリの作成
1. 開発者ダッシュボードで「マイアプリ」→「アプリを作成」
2. アプリの種類を選択（「ビジネス」推奨）
3. アプリ名、連絡先メールアドレスを入力
4. 「アプリを作成」をクリック

### 4. Instagram Graph APIの設定（重要：製品名を確認）

**⚠️ 重要な注意点**: 製品名は必ず「**Instagram Graph API**」を追加してください。「Instagram」だけでは不十分です。

1. アプリダッシュボードで「製品を追加」をクリック
2. 製品一覧から「**Instagram Graph API**」を選択して追加
   - 「Instagram Basic Display API」（終了済み）や単に「Instagram」とは別物です
   - 必ず「Instagram Graph API」という名前の製品を選択してください
3. 「基本設定」で以下を設定：
   - プラットフォームを追加 → 「ウェブサイト」
   - サイトURLを入力（例: `https://yourdomain.com` または開発中は `https://localhost`）
4. 「Instagram Graph API」の「基本設定」タブで：
   - 「Instagram App ID」と「Instagram App Secret」を確認（必要に応じて）
   - ただし、Instagram Graph APIでは、基本的にFacebookページのアクセストークンを使用するため、これらは必須ではありません
5. **FacebookページとInstagramアカウントの接続**を確認：
   - InstagramアカウントがFacebookページに接続されている必要があります
   - Facebookページの設定 → Instagram → アカウントを接続

### 5. アクセストークンの取得

#### 方法1: Graph API Explorerを使用（推奨・開発用）

**重要**: `instagram_business_account`を取得するには、**必ずページトークンを使用する必要があります**。

1. [Graph API Explorer](https://developers.facebook.com/tools/explorer/)にアクセス
2. 右上の「アプリを選択」で作成したアプリ（例: `minori`）を選択
3. **「ユーザーまたはページ」ドロップダウンをクリック**
   - ここで重要なのは、**ページ名を選択すること**
   - 「農家の店みのりFARM&Garden」のようなページ名を選択
   - **個人のユーザー名を選択しないこと**
4. 「アクセストークン」をクリックして必要な権限を選択：
   - `pages_show_list` - ページのリストを取得
   - `pages_read_engagement` - ページの投稿を読み取る
   - （注: `instagram_basic`権限は2024年12月に終了。現在は不要）
5. 「アクセストークンを生成」をクリック
6. 生成された**ページのアクセストークン**をコピー

**ページトークンの確認方法**:
- 生成されたトークンをGraph API Explorerに入力
- 「ユーザーまたはページ」ドロップダウンにページ名が表示されていれば、ページトークンです
- 個人名が表示されている場合は、ユーザートークンなので、ページを再選択してください

**長期トークンに変換推奨**:
- 生成されたトークンは短期トークン（1-2時間有効）の場合があります
- 長期トークンに変換するには、方法2を参照してください

#### 方法2: 長期アクセストークンの取得
1. [アクセストークンツール](https://developers.facebook.com/tools/accesstoken/)にアクセス
2. 生成したトークンを入力して「デバッグ」をクリック
3. 「長期トークンに拡張」をクリック
4. 新しい長期トークン（60日間有効）をコピー

#### 方法3: システムユーザートークン（本番環境推奨）
本番環境では、システムユーザートークンを使用することを推奨します。
詳細は[Instagram Graph API ドキュメント](https://developers.facebook.com/docs/instagram-api/getting-started)を参照してください。

### 6. Instagram User IDの取得

**前提条件**: Graph API Explorerで**ページトークン**を使用していることを確認してください。

1. Graph API Explorerで以下のエンドポイントにアクセス：
   ```
   GET /me/accounts
   ```
2. 結果からInstagramアカウントが接続されたページのIDを取得
   - 例: `{"id": "9240601141215079", "name": "農家の店みのりFARM&Garden", ...}`
   - ページID: `9240601141215079` ✓

3. **ページトークンを使用したまま**、以下のエンドポイントにアクセス：
   ```
   GET /9240601141215079?fields=name,instagram_business_account
   ```
   **注意**: 
   - エンドポイントは `/9240601141215079?fields=name,instagram_business_account` （先頭にスラッシュ）
   - Graph API Explorerの「ユーザーまたはページ」で**ページ名を選択**した状態で実行

4. レスポンスを確認：

   **成功時のレスポンス例**:
   ```json
   {
     "name": "農家の店みのりFARM&Garden",
     "id": "9240601141215079",
     "instagram_business_account": {
       "id": "17841405309211844"
     }
   }
   ```
   - `instagram_business_account.id` がInstagram User IDです
   - このID（例: `17841405309211844`）をWordPress管理画面に入力します

   **`instagram_business_account`が返ってこない場合**:
   - レスポンスに `instagram_business_account` フィールドが含まれていない、または `null` の場合
   - 以下のトラブルシューティングを参照してください

## WordPressでの設定

### 1. 管理画面で設定を入力
1. WordPress管理画面にログイン
2. 「設定」→「Instagram設定」をクリック
3. 各アカウントの以下を入力：
   - **アクセストークン**: 上記で取得した**Facebookページのアクセストークン**（長期トークン推奨）
   - **ユーザーID**: 上記で取得したInstagram User ID（数値）
   - 注意: Instagram Graph APIでは、ページのアクセストークンを使用します（`instagram_basic`権限は不要）
4. 「設定を保存」をクリック

### 2. 動作確認
1. トップページにアクセス
2. Instagramセクションに投稿が表示されることを確認

## 実装の詳細

### ファイル構成
```
inc/
  ├── class-instagram-api.php      # Instagram APIクラス
  └── admin-instagram-settings.php # 管理画面設定ページ

front-page.php                     # トップページテンプレート（Instagramセクション）
functions.php                      # クラスの読み込み
```

### キャッシュ機能
- WordPress Transients APIを使用して1時間キャッシュ
- API呼び出し回数を削減してパフォーマンスを向上

### エラーハンドリング
- API呼び出しに失敗した場合、フィードは表示されず「もっと見る」リンクのみ表示
- 管理画面でエラーログを確認可能（今後の拡張）

## トラブルシューティング

### 投稿が表示されない
1. **アクセストークンが有効か確認**
   - Graph API Explorerでトークンの有効期限を確認
   - トークンが期限切れの場合は再生成

2. **ユーザーIDが正しいか確認**
   - Graph API Explorerで以下のエンドポイントにアクセス：
     ```
     GET /{user-id}?fields=username
     ```
   - 正しいユーザー名が返されるか確認

3. **権限（Permissions）が正しいか確認**
   - ページのアクセストークンに以下の権限が含まれているか確認：
     - `pages_show_list`
     - `pages_read_engagement`
   - （注: `instagram_basic`権限は不要。Instagram Basic Display APIは2024年12月に終了）

4. **FacebookページとInstagramアカウントの接続を確認**
   - InstagramアカウントがFacebookページに接続されているか確認

4. **キャッシュをクリア**
   - WordPressのキャッシュプラグインをクリア
   - または、`wp_cache_flush()`を実行

### エラーメッセージの確認
- WordPressのデバッグモードを有効化してエラーログを確認：
  ```php
  define( 'WP_DEBUG', true );
  define( 'WP_DEBUG_LOG', true );
  ```

## セキュリティ

- アクセストークンはWordPressの`wp_options`テーブルに保存されます
- 管理画面でのみアクセス可能な設定項目です
- 本番環境では、システムユーザートークンの使用を推奨

## 参考リンク

- [Instagram Graph API ドキュメント](https://developers.facebook.com/docs/instagram-api)
- [Instagram Graph API チュートリアル](https://developers.facebook.com/docs/instagram-api/getting-started)
- [Graph API Explorer](https://developers.facebook.com/tools/explorer/)
- [アクセストークンツール](https://developers.facebook.com/tools/accesstoken/)

実装が難しいね
やったこと
・インスタのアカウントはある
・ファイスブックアカウント作成
・ファイスブックアカウントからページを作成（アカウント名:農家の店みのり ページ名:農家の店みのりファームアンドガーデン）
・ページとインスタは連携済
・グラフAPIを使用しテストした
テスト結果失敗。。。
詳細
metaアプリ minori
ユーザーまたはページ 農家の店みのりFARM&Garden

アクセス許可
`pages_show_list`
`pages_read_engagement`
`pages_manage_engagement`
'business_management'

me/accounttsで送信
id9240601141215079が返る

その後9240601141215079?fields=instagram_business_accountで送信
id9240601141215079が返る

ここで詰まってる

## トラブルシューティング：instagram_business_accountが返ってこない場合

### 問題
`/{page-id}?fields=instagram_business_account`で送信しても、`instagram_business_account`フィールドが返ってこない（空のレスポンスまたはエラー）

### 確認すべきポイント

#### 1. ページトークンを使用しているか確認
Graph API Explorerで使用しているトークンが**ページトークン**であることを確認：

1. Graph API Explorerで、右上の「ユーザーまたはページ」ドロップダウンを確認
2. **必ずページ名を選択**（「農家の店みのりFARM&Garden」など）
3. ユーザー（個人アカウント）を選択している場合は、ページトークンに切り替える

#### 2. 正しいエンドポイントで確認
以下の順序で確認してください：

**ステップ1: ページIDを取得（既に完了）**
```
GET /me/accounts
```
→ ページID: `9240601141215079` ✓

**ステップ2: ページの情報を取得**
Graph API Explorerで以下を実行：
```
GET /9240601141215079?fields=name,instagram_business_account
```

**重要**: 
- エンドポイントは `/9240601141215079?fields=instagram_business_account` であることを確認（スラッシュが最初に必要）
- アクセストークンは**ページトークン**を使用

#### 3. Instagramアカウントの状態を確認（最重要）

**ステップ1: Instagramアカウントの種類を確認**
1. Instagramアプリを開く
2. プロフィール → 右上のメニュー（三本線）→ 設定
3. 「アカウント」→「プロフェッショナルアカウントに切り替え」または「アカウントの種類」
4. **「ビジネス」または「クリエーター」**になっているか確認
   - 「個人アカウント」の場合は、必ず「ビジネス」または「クリエーター」に変更してください
   - これが最も一般的な原因です

**ステップ2: Facebookページとの接続を確認**
1. Facebookにログイン
2. ページ「農家の店みのりFARM&Garden」に移動
3. 左サイドバーまたは「設定」→「Instagram」
4. Instagramアカウントが接続されているか確認
   - 接続されていない場合は「接続」をクリックして接続
   - 既に接続されている場合は、一度切断して再接続してみてください

**ステップ3: 接続確認（Graph APIで確認）**
Graph API Explorerで以下を実行して、接続状態を確認：
```
GET /9240601141215079?fields=name,instagram_business_account{id,username}
```
このクエリでも`instagram_business_account`が返ってこない場合は、接続が正しく行われていません。

#### 4. アクセストークンの権限を確認
ページトークンに以下の権限が含まれているか確認：
- `pages_show_list` ✓
- `pages_read_engagement` ✓
- `pages_read_user_content` （追加で必要かもしれない）

#### 5. 代替方法：直接Instagram User IDを取得
もし `instagram_business_account` が取得できない場合、以下の方法を試してください：

**方法A: Instagramのユーザー名から直接取得（可能な場合）**
Instagramのユーザー名（例: `noukanomiseminori`）がわかっている場合：
```
GET /ig_hashtag_search?q=noukanomiseminori
```
ただし、この方法はユーザー名検索用で、直接User IDを取得する方法ではないので、推奨しません。

**方法B: Instagramアプリの設定から確認**
1. Instagramアプリで「設定」
2. 「アカウント」→「アプリやWebサイト」
3. 「アクセス許可を与えたアプリとWebサイト」を確認
4. または、InstagramのプロフィールURLから直接取得できないか確認

#### 6. デバッグ用のクエリ
Graph API Explorerで以下を順番に実行して、どのフィールドが取得できるか確認：

```
# 1. ページの基本情報を取得
GET /9240601141215079?fields=name,id

# 2. ページの全フィールドを確認（可能なフィールドを確認）
GET /9240601141215079?fields=name,instagram_business_account,access_token

# 3. エラーメッセージを確認
GET /9240601141215079?fields=instagram_business_account{id,username}
```

### よくある原因と解決策

#### 原因1: ユーザートークンを使用している
**症状**: `instagram_business_account`が空
**解決策**: Graph API Explorerの「ユーザーまたはページ」で**ページを選択**してページトークンを取得

#### 原因2: Instagramアカウントが個人アカウント
**症状**: `instagram_business_account`フィールドが存在しない
**解決策**: Instagramアカウントを「ビジネス」または「クリエーター」アカウントに変更

#### 原因3: ページとInstagramアカウントの接続が切れている
**症状**: `instagram_business_account`が空
**解決策**: Facebookページの設定 → Instagram で再接続

#### 原因4: アプリの権限が不足
**症状**: エラーメッセージが表示される
**解決策**: アプリの設定で、Instagram Graph APIの権限を確認

### 具体的な解決手順（今すぐ試すべきこと）

#### 優先度1: Instagramアカウントの種類を確認・変更
1. **Instagramアプリ**で以下を確認：
   - プロフィール → 設定 → アカウント → アカウントの種類
   - もし「個人アカウント」になっていたら：
     - 「プロフェッショナルアカウントに切り替え」をタップ
     - 「ビジネス」または「クリエーター」を選択
     - Facebookページと連携することを求められたら、該当するページを選択

#### 優先度2: Facebookページとの接続を再確認
1. **Facebook**にログイン
2. ページ「農家の店みのりFARM&Garden」の管理画面を開く
3. 左サイドバーの「Instagram」または「設定」→「Instagram」を確認
4. Instagramアカウントが表示されているか確認
   - 表示されていない、または「接続」ボタンがある場合：
     - 一度接続を解除して、再度接続してください
     - この際、正しいInstagramアカウント（`@noukanomiseminori`）を選択してください

#### 優先度3: 再接続後の確認
1. 上記の手順を行った後、**数分待つ**（接続が反映されるまで少し時間がかかることがあります）
2. Graph API Explorerで再度以下を実行：
   ```
   GET /9240601141215079?fields=name,instagram_business_account{id,username}
   ```
3. 今度は以下のようなレスポンスが返ってくるはずです：
   ```json
   {
     "name": "農家の店みのりFARM&Garden",
     "id": "9240601141215079",
     "instagram_business_account": {
       "id": "17841405309211844",
       "username": "noukanomiseminori"
     }
   }
   ```

**もし依然として `instagram_business_account` が返ってこない場合（現在の状況）**:
以下の追加確認を行ってください。

#### 追加確認1: Instagramアカウントが「ビジネス」アカウントか確認
プロフェッショナルアカウントには2種類あります：
- **「ビジネス」アカウント**: Facebookページと接続可能
- **「クリエーター」アカウント**: 接続は可能だが、APIでの取得が難しい場合がある

確認方法：
1. Instagramアプリ → プロフィール → 設定 → アカウント → アカウントの種類
2. 「ビジネス」になっているか確認
3. 「クリエーター」の場合は、「ビジネス」に変更してみてください

#### 追加確認2: Metaアプリの設定を確認（重要！）

**重要なポイント**: Meta for Developersでは、「Instagram Graph API」は「Instagram」製品の中に含まれています。製品一覧に「Instagram Graph API」という独立した製品名が表示されない場合があります。

1. [Meta for Developers](https://developers.facebook.com/)にアクセス
2. アプリ「minori」を選択
3. 「製品」タブ（左サイドバー）を確認

4. **「Instagram」製品をクリック**して詳細を開く
   - 製品一覧に「Instagram Graph API」という独立した名前が表示されなくても問題ありません
   - 「Instagram」製品の中に「Instagram Graph API」の機能が含まれています

5. 「Instagram」製品の設定画面で以下を確認：
   - 左サイドバーや設定画面に表示されているメニュー項目を確認
   - 「基本設定」「設定」「Instagram Graph API」「Webhooks」などの項目を探す
   - Metaのインターフェースは頻繁に更新されるため、表示されている項目名は異なる可能性があります
   - 重要なのは、「Instagram」製品が追加されていることと、Graph API Explorerでアクセストークンが取得できることです

6. もし「Instagram」製品がまだ追加されていない場合：
   - 「製品を追加」ボタンをクリック
   - 製品一覧から「**Instagram**」を選択して追加

7. **実際の設定確認**（重要）:
   - 設定画面の具体的な項目名がわからない場合は、Graph API Explorerで実際に動作するか確認することが最も重要です
   - 「Instagram」製品が追加されていて、Graph API Explorerでページトークンが取得できれば、設定は正しく行われています
   - 詳細な設定項目は、Metaのインターフェースが更新されている可能性があるため、実際に表示されている項目に従って確認してください

**現在の状況に合わせた確認**:
- 製品一覧に「Instagram」が表示されている場合は、それをクリックして設定を確認してください
- 「InstagramログインによるAPI」や「API統合ヘルパー」などは、Instagram Graph APIとは別の機能です
- 重要なのは、「Instagram」製品が追加されていて、その中でInstagram Graph APIが有効になっているかです

#### 追加確認3: アクセストークンの詳細を確認
Graph API Explorerで以下を実行して、トークンの権限を確認：
```
GET /me/permissions
```

以下の権限が含まれているか確認：
- `pages_show_list`
- `pages_read_engagement`
- `pages_manage_engagement`
- `business_management`

#### 追加確認4: 別のエンドポイントで試す
Graph API Explorerで以下も試してみてください：
```
GET /9240601141215079?fields=instagram_business_account.id,instagram_business_account.username
```

または：
```
GET /9240601141215079?fields=connected_instagram_account
```

#### 追加確認5: Facebookページの設定で再確認
1. Facebookページ「農家の店みのりFARM&Garden」の管理画面を開く
2. 「設定」→「Instagram」を開く
3. 接続されているInstagramアカウントのユーザー名を確認（例: `@noukanomiseminori`）
4. このユーザー名が正しいことを確認

#### 追加確認6: 時間を置いて再試行
接続後、APIへの反映には時間がかかる場合があります：
- 5-10分待ってから再度Graph API Explorerで試してください
- 場合によっては1時間程度かかることもあります

#### 追加確認7: Instagramアカウントから直接確認
1. Instagramアプリで、プロフィール → 設定 → アカウント
2. 「ページ」または「Facebookページ」の項目を確認
3. 接続されているFacebookページが表示されているか確認
4. 表示されていない場合は、ここから接続してみてください

#### 追加確認8: エラーメッセージの確認
Graph API Explorerで以下を実行して、エラーメッセージがあるか確認：
```
GET /9240601141215079?fields=instagram_business_account
```

もしエラーメッセージが表示される場合、そのメッセージを確認してください。
よくあるエラー：
- `(#10) Application does not have permission for this action` → アプリの権限が不足
- `(#100) No Instagram Business Account found` → Instagramビジネスアカウントが見つからない
- `(#200) Permissions error` → アクセストークンの権限エラー

#### 最後の手段: 代替方法
もし上記の方法でも `instagram_business_account` が取得できない場合、以下の方法を検討してください：

1. **別の方法でInstagram User IDを取得**
   - Instagramアカウントのユーザー名（例: `noukanomiseminori`）がわかっている場合
   - サードパーティツールを使用してUser IDを取得（例: [Find Instagram User ID](https://codeofaninja.com/tools/find-instagram-user-id/)）
   - ただし、この方法はAPIの仕様変更に弱いため、推奨しません

2. **Metaサポートに問い合わせ**
   - [Meta Business Support](https://business.facebook.com/help) に問い合わせる
   - アプリID、ページID、Instagramアカウント情報を用意して問い合わせ

3. **プラグインの使用を検討**
   - この問題が解決しない場合は、Smash Balloonプラグインなどの使用も検討
   - ただし、プラグインでも同様の問題が発生する可能性があります

### 次のステップ
`instagram_business_account`が取得できたら：
1. レスポンスから `instagram_business_account.id` フィールドを取得（これがInstagram User ID）
   - 例: `17841405309211844`
2. WordPress管理画面の「設定」→「Instagram設定」を開く
3. 「メインアカウント」の「ユーザーID」欄に、取得したIDを入力
4. 「アクセストークン」欄に、Graph API Explorerで使用しているページトークンを入力
5. 「設定を保存」をクリック
6. トップページでInstagramフィードが表示されるか確認

### 参考リンク
- [Instagram Graph API - はじめに](https://developers.facebook.com/docs/instagram-api/getting-started)
- [Page Access Tokenの取得方法](https://developers.facebook.com/docs/pages/access-tokens)