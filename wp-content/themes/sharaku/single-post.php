<?php get_header(); ?>
    <h1><?php the_title() ?></h1>
        <?php
        // WordPressのループを開始
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                // 投稿のコンテンツを表示
                the_content();
            endwhile;
        else :
            echo '<p>投稿が見つかりませんでした。</p>';
        endif;
        ?>
<?php wp_footer(); ?>
