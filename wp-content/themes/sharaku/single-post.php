<?php
    $tags = get_the_tags();
?>
<?php include get_template_directory() . '/parts/header.php'; ?>
    <main>
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
                
        </section>
    </main>
<?php include get_template_directory() . '/parts/footer.php'; ?>
