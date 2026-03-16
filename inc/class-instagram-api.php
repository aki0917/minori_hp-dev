<?php
/**
 * Instagram API クラス
 * Instagram Graph APIを使用して投稿を取得
 *
 * @package Minorihp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Minorihp_Instagram_API {
	/**
	 * Instagram Graph APIのベースURL
	 */
	const API_BASE_URL = 'https://graph.instagram.com/';

	/**
	 * キャッシュの有効期限（秒）
	 * デフォルト: 1時間（3600秒）
	 */
	const CACHE_EXPIRATION = 3600;

	/**
	 * デフォルトの投稿取得数
	 */
	const DEFAULT_POSTS_COUNT = 6;

	/**
	 * アクセストークンを取得（WordPress管理画面で設定）
	 * 
	 * @param string $account_id アカウントID（'main' または 'interpark'）
	 * @return string|false アクセストークン、取得できない場合はfalse
	 */
	private static function get_access_token( $account_id = 'main' ) {
		// 管理画面で設定されたトークンを取得
		// オプション: minorihp_instagram_token_main, minorihp_instagram_token_interpark
		$token_key = 'minorihp_instagram_token_' . $account_id;
		$token = get_option( $token_key, '' );
		
		return ! empty( $token ) ? $token : false;
	}

	/**
	 * Instagram Graph APIから投稿を取得
	 *
	 * @param string $account_id アカウントID
	 * @param int    $limit 取得する投稿数
	 * @return array|false 投稿データの配列、失敗した場合はfalse
	 */
	public static function get_posts( $account_id = 'main', $limit = self::DEFAULT_POSTS_COUNT ) {
		// キャッシュキー
		$cache_key = 'minorihp_instagram_posts_' . $account_id . '_' . $limit;
		
		// キャッシュから取得を試みる
		$cached_data = get_transient( $cache_key );
		if ( false !== $cached_data ) {
			return $cached_data;
		}

		// アクセストークンを取得
		$access_token = self::get_access_token( $account_id );
		if ( ! $access_token ) {
			return false;
		}

		// アカウントIDを取得（トークンとは別に、Instagram User IDが必要）
		$user_id = get_option( 'minorihp_instagram_user_id_' . $account_id, '' );
		if ( empty( $user_id ) ) {
			return false;
		}

		// APIエンドポイント
		$endpoint = self::API_BASE_URL . $user_id . '/media';
		$params = array(
			'fields'       => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
			'limit'        => $limit,
			'access_token' => $access_token,
		);

		$url = add_query_arg( $params, $endpoint );

		// APIリクエスト
		$response = wp_remote_get( $url, array(
			'timeout' => 15,
			'sslverify' => true,
		) );

		// エラーチェック
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		// エラーチェック
		if ( ! isset( $data['data'] ) || ! is_array( $data['data'] ) ) {
			return false;
		}

		// データを整形
		$posts = array();
		foreach ( $data['data'] as $item ) {
			// 画像のみを対象とする（VIDEOなどは除外可能）
			if ( in_array( $item['media_type'], array( 'IMAGE', 'CAROUSEL_ALBUM' ) ) ) {
				$posts[] = array(
					'id'        => $item['id'],
					'caption'   => isset( $item['caption'] ) ? $item['caption'] : '',
					'image_url' => isset( $item['media_url'] ) ? $item['media_url'] : '',
					'permalink' => isset( $item['permalink'] ) ? $item['permalink'] : '',
					'timestamp' => isset( $item['timestamp'] ) ? $item['timestamp'] : '',
				);
			}
		}

		// キャッシュに保存
		set_transient( $cache_key, $posts, self::CACHE_EXPIRATION );

		return $posts;
	}

	/**
	 * 投稿をHTMLとして出力
	 *
	 * @param string $account_id アカウントID
	 * @param int    $limit 取得する投稿数
	 * @return string HTML
	 */
	public static function render_posts( $account_id = 'main', $limit = self::DEFAULT_POSTS_COUNT ) {
		$posts = self::get_posts( $account_id, $limit );
		
		if ( false === $posts || empty( $posts ) ) {
			return '';
		}

		ob_start();
		foreach ( $posts as $post ) {
			?>
			<div class="p-instagram__item">
				<a href="<?php echo esc_url( $post['permalink'] ); ?>" 
				   target="_blank" 
				   rel="noopener noreferrer" 
				   class="p-instagram__link"
				   aria-label="Instagram投稿を見る">
					<img src="<?php echo esc_url( $post['image_url'] ); ?>" 
					     alt="<?php echo esc_attr( wp_trim_words( $post['caption'], 10, '...' ) ); ?>"
					     class="p-instagram__image"
					     loading="lazy"
					     decoding="async"
					     width="400"
					     height="400">
				</a>
			</div>
			<?php
		}
		return ob_get_clean();
	}
}













