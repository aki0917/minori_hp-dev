<?php
/**
 * メインテンプレートファイル
 *
 * @package Minorihp
 */

get_header();
?>

<main class="l-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <p><?php esc_html_e( '投稿が見つかりませんでした。', 'minorihp' ); ?></p>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();

