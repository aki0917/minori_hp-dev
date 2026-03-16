<?php
/**
 * Instagram API設定（管理画面）
 * 
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 管理画面に設定ページを追加
function minorihp_add_instagram_settings_page() {
	add_options_page(
		'Instagram設定',
		'Instagram設定',
		'manage_options',
		'minorihp-instagram-settings',
		'minorihp_instagram_settings_page_callback'
	);
}
add_action( 'admin_menu', 'minorihp_add_instagram_settings_page' );

// 設定ページのコールバック
function minorihp_instagram_settings_page_callback() {
	// 権限チェック
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// 設定の保存処理
	if ( isset( $_POST['minorihp_instagram_save'] ) && check_admin_referer( 'minorihp_instagram_settings' ) ) {
		// メインアカウント
		update_option( 'minorihp_instagram_token_main', sanitize_text_field( $_POST['token_main'] ?? '' ) );
		update_option( 'minorihp_instagram_user_id_main', sanitize_text_field( $_POST['user_id_main'] ?? '' ) );
		
		// インターパーク店アカウント
		update_option( 'minorihp_instagram_token_interpark', sanitize_text_field( $_POST['token_interpark'] ?? '' ) );
		update_option( 'minorihp_instagram_user_id_interpark', sanitize_text_field( $_POST['user_id_interpark'] ?? '' ) );

		echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
	}

	// 現在の設定値を取得
	$token_main = get_option( 'minorihp_instagram_token_main', '' );
	$user_id_main = get_option( 'minorihp_instagram_user_id_main', '' );
	$token_interpark = get_option( 'minorihp_instagram_token_interpark', '' );
	$user_id_interpark = get_option( 'minorihp_instagram_user_id_interpark', '' );
	?>
	<div class="wrap">
		<h1>Instagram設定</h1>
		<p>Instagram Graph APIを使用してフィードを表示するための設定です。</p>
		
		<form method="post" action="">
			<?php wp_nonce_field( 'minorihp_instagram_settings' ); ?>
			
			<h2>メインアカウント（@noukanomiseminori）</h2>
			<table class="form-table">
				<tr>
					<th><label for="token_main">アクセストークン</label></th>
					<td>
						<input type="text" 
						       id="token_main" 
						       name="token_main" 
						       value="<?php echo esc_attr( $token_main ); ?>" 
						       class="regular-text"
						       placeholder="ページのアクセストークンを入力">
						<p class="description">Facebookページのアクセストークン（Instagram Graph API用）<br>※instagram_basic権限は不要（2024年12月に終了）</p>
					</td>
				</tr>
				<tr>
					<th><label for="user_id_main">ユーザーID</label></th>
					<td>
						<input type="text" 
						       id="user_id_main" 
						       name="user_id_main" 
						       value="<?php echo esc_attr( $user_id_main ); ?>" 
						       class="regular-text"
						       placeholder="Instagram User IDを入力">
						<p class="description">Instagram Graph APIのユーザーID（数値）</p>
					</td>
				</tr>
			</table>

			<h2>インターパーク店アカウント（@minori_kaboku_interpark）</h2>
			<table class="form-table">
				<tr>
					<th><label for="token_interpark">アクセストークン</label></th>
					<td>
						<input type="text" 
						       id="token_interpark" 
						       name="token_interpark" 
						       value="<?php echo esc_attr( $token_interpark ); ?>" 
						       class="regular-text"
						       placeholder="ページのアクセストークンを入力">
						<p class="description">Facebookページのアクセストークン（Instagram Graph API用）<br>※instagram_basic権限は不要（2024年12月に終了）</p>
					</td>
				</tr>
				<tr>
					<th><label for="user_id_interpark">ユーザーID</label></th>
					<td>
						<input type="text" 
						       id="user_id_interpark" 
						       name="user_id_interpark" 
						       value="<?php echo esc_attr( $user_id_interpark ); ?>" 
						       class="regular-text"
						       placeholder="Instagram User IDを入力">
						<p class="description">Instagram Graph APIのユーザーID（数値）</p>
					</td>
				</tr>
			</table>

			<?php submit_button( '設定を保存', 'primary', 'minorihp_instagram_save' ); ?>
		</form>

		<h2>アクセストークンの取得方法</h2>
		<ol>
			<li>Instagramアカウントを「ビジネス」または「クリエーター」に変更</li>
			<li>InstagramアカウントをFacebookページに接続</li>
			<li><a href="https://developers.facebook.com/" target="_blank">Facebook開発者</a>でアプリを作成</li>
			<li>Instagram Graph APIのアクセス許可をリクエスト（必要な権限: <code>pages_show_list</code>, <code>pages_read_engagement</code>）</li>
			<li><strong>Facebookページのアクセストークン</strong>とユーザーIDを取得</li>
			<li>上記のフォームに入力して保存</li>
		</ol>
		<p><strong>注意:</strong> Instagram Graph APIでは、<code>instagram_basic</code>権限は不要です（2024年12月にInstagram Basic Display APIが終了）。代わりに、Facebookページのアクセストークンを使用します。</p>
		<p><a href="https://developers.facebook.com/docs/instagram-api/getting-started" target="_blank">Instagram Graph API ドキュメント</a></p>
	</div>
	<?php
}

