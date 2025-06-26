<?php
    $tags = get_the_tags();
?>
<?php include get_template_directory() . '/parts/header.php'; ?>
<main class="single-post">
    <div class="back-to-top">
        <a href="<?php echo home_url(); ?>" class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8l8 8l1.41-1.41L7.83 13H20z" />
            </svg>
            トップに戻る
        </a>
    </div>
    <div class="main-images">
        <div class="image-track">
            <?php
                    global $post;
                    $content = $post->post_content;
                    preg_match_all('/<img[^>]+>/i', $content, $matches);
                    $images = array_slice($matches[0], 0, 4);
                    foreach ($images as $image) {
                        echo '<div class="slide">' . $image . '</div>';
                    }
                ?>
        </div>
        <div class="indicator">
            <?php for ($i = 0; $i < count($images); $i++): ?>
            <span class="dot" data-index="<?= $i ?>"></span>
            <?php endfor; ?>
        </div>
    </div>
    <section class="post-content">
        <h1 class="post-title"><?php the_title() ?></h1>
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
        <div class="post-wrap">
            <?php
                    // WordPressのループを開始
                    if ( have_posts() ) :
                        while ( have_posts() ) : the_post();
                            // コンテンツを取得
                            $content = get_the_content();
                            
                            // 画像タグを見つけて、最初の4枚分を削除
                            $pattern = '/<img[^>]+>/i';
                            preg_match_all($pattern, $content, $matches);
                            
                            if (!empty($matches[0])) {
                                // 最初の4枚の画像を順番に置換
                                for ($i = 0; $i < min(4, count($matches[0])); $i++) {
                                    $content = preg_replace($pattern, '', $content, 1);
                                }
                            }
                            
                            // フィルターを適用して出力
                            echo apply_filters('the_content', $content);
                        endwhile;
                    else :
                        echo '<p>投稿が見つかりませんでした。</p>';
                    endif;
                ?>
        </div>
    </section>
</main>
<?php include get_template_directory() . '/parts/footer.php'; ?>