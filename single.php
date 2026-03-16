<?php
/**
 * 投稿詳細テンプレート
 *
 * @package Minorihp
 */

get_header();
?>

<main class="l-main">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <article class="p-news-detail">
      <div class="p-news-detail__inner">
        <div class="p-news-detail__container">
          <div class="p-news-detail__main">
            <header class="p-news-detail__header">
              <div class="p-news-detail__meta">
                <time class="p-news-detail__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                  <?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?>
                </time>
              </div>
              <h1 class="p-news-detail__title"><?php the_title(); ?></h1>
            </header>

            <div class="p-news-detail__content">
              <?php the_content(); ?>
            </div>

            <?php
            // カスタム投稿タイプを含めた前後ナビゲーション（WP標準関数を使用）
            $prev_post = get_adjacent_post( false, '', true );
            $next_post = get_adjacent_post( false, '', false );
            ?>

            <nav class="p-news-detail__navigation" aria-label="記事ナビゲーション">
              <div class="p-news-detail__nav-item p-news-detail__nav-item--prev">
                <?php if ( $prev_post ) : ?>
                  <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="p-news-detail__nav-link">
                    <span class="p-news-detail__nav-label">前の記事</span>
                    <span class="p-news-detail__nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
                  </a>
                <?php else : ?>
                  <span class="p-news-detail__nav-link" style="opacity: 0.5; cursor: not-allowed; pointer-events: none;">
                    <span class="p-news-detail__nav-label">前の記事</span>
                    <span class="p-news-detail__nav-title">これより前の記事はありません</span>
                  </span>
                <?php endif; ?>
              </div>
              <div class="p-news-detail__nav-item p-news-detail__nav-item--next">
                <?php if ( $next_post ) : ?>
                  <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="p-news-detail__nav-link">
                    <span class="p-news-detail__nav-label">次の記事</span>
                    <span class="p-news-detail__nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
                  </a>
                <?php else : ?>
                  <span class="p-news-detail__nav-link" style="opacity: 0.5; cursor: not-allowed; pointer-events: none;">
                    <span class="p-news-detail__nav-label">次の記事</span>
                    <span class="p-news-detail__nav-title">（最新記事です）</span>
                  </span>
                <?php endif; ?>
              </div>
            </nav>

            <footer class="p-news-detail__footer">
              <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="p-news-detail__back-to-list">お知らせ一覧に戻る</a>
            </footer>
          </div>

          <aside class="p-news-detail__sidebar">
            <div class="p-news-sidebar">
              <div class="p-news-sidebar__widget">
                <h3 class="p-news-sidebar__title">最新記事</h3>
                <ul class="p-news-sidebar__list">
                  <?php
                  $recent_posts = wp_get_recent_posts(
                    array(
                      'numberposts' => 5,
                      'post_status' => 'publish',
                      'post_type'   => get_post_type(),
                    )
                  );
                  if ( ! empty( $recent_posts ) ) :
                    foreach ( $recent_posts as $recent ) :
                  ?>
                    <li class="p-news-sidebar__item">
                      <a href="<?php echo esc_url( get_permalink( $recent['ID'] ) ); ?>" class="p-news-sidebar__link">
                        <time class="p-news-sidebar__date" datetime="<?php echo esc_attr( get_the_date( 'c', $recent['ID'] ) ); ?>">
                          <?php echo esc_html( get_the_date( 'Y.m.d', $recent['ID'] ) ); ?>
                        </time>
                        <span class="p-news-sidebar__text"><?php echo esc_html( get_the_title( $recent['ID'] ) ); ?></span>
                      </a>
                    </li>
                  <?php
                    endforeach;
                  else :
                  ?>
                    <li class="p-news-sidebar__item">まだ記事がありません。</li>
                  <?php endif; ?>
                </ul>
              </div>

              <div class="p-news-sidebar__widget">
                <h3 class="p-news-sidebar__title">アーカイブ</h3>
                <ul class="p-news-sidebar__list">
                  <?php
                  $archives = wp_get_archives(
                    array(
                      'type'      => 'monthly',
                      'limit'     => 6,
                      'echo'      => false,
                      'format'    => 'custom',
                      'before'    => '<li class="p-news-sidebar__item">',
                      'after'     => '</li>',
                      'post_type' => get_post_type(),
                    )
                  );
                  echo wp_kses_post( $archives );
                  ?>
                </ul>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </article>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
