<?php
/**
 * ブログ一覧テンプレート
 *
 * @package Minorihp
 */

get_header();
?>

<main class="l-main">
  <section class="p-news">
    <div class="p-news__inner">
      <div class="p-news__container">
        <div class="p-news__main">
          <h2 class="p-news__title c-sec-title">ブログ</h2>
          <?php
          $paged    = max( 1, get_query_var( 'paged' ) );
          $year     = get_query_var( 'year' );
          $monthnum = get_query_var( 'monthnum' );

          $query_args = array(
            'post_type'      => 'blog',
            'posts_per_page' => 10,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
          );

          if ( $year ) {
            $query_args['year'] = $year;
          }
          if ( $monthnum ) {
            $query_args['monthnum'] = $monthnum;
          }

          $blog_query = new WP_Query( $query_args );
          ?>
          <?php if ( $blog_query->have_posts() ) : ?>
            <ul class="p-news__list">
              <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
              <li class="p-news__item">
                <a class="p-news__link" href="<?php the_permalink(); ?>">
                  <time class="p-news__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
                  <?php
                  $categories = get_the_category();
                  $cat_name   = ! empty( $categories ) ? $categories[0]->name : 'ブログ';
                  ?>
                  <span class="p-news__cat"><?php echo esc_html( $cat_name ); ?></span>
                  <span class="p-news__text"><?php the_title(); ?></span>
                </a>
              </li>
              <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
          <?php else : ?>
            <p class="p-news__empty">現在、ブログ記事はありません。</p>
          <?php endif; ?>
        </div>

        <aside class="p-news__sidebar">
          <div class="p-news-sidebar">
            <div class="p-news-sidebar__widget">
              <h3 class="p-news-sidebar__title">最新記事</h3>
              <ul class="p-news-sidebar__list">
                <?php
                $recent_posts = wp_get_recent_posts(
                  array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                    'post_type'   => 'blog',
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
                    'post_type' => 'blog',
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
  </section>
</main>

<?php get_footer(); ?>
