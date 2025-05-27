<?php
    $tags = get_the_tags();
?>
<?php include get_template_directory() . '/parts/header.php'; ?>
    <h1><?php the_title() ?></h1>
        <div>
            <?php if( $tags ){
                echo '<ul class="tag-list">';
                    foreach( $tags as $tag ){
                        echo '<li>';
                        echo '<p class="tag-button">' . esc_html( $tag->name ) . '</p>';
                        echo '</li>';
                    }
                echo '</ul>';
                } 
            ?>
        </div>
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
        
<?php include get_template_directory() . '/parts/footer.php'; ?>
