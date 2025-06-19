<?php include get_template_directory() . '/parts/header.php'; ?>
<!-- この中に書いていくmain -->
<!-- body -->
<main>
    <!-- MapView -->
    <div class="map-view-container">
        <div id="map" class="map-view"></div>
    </div>

    <!-- LocationView -->
    <div class="location-view-wrapper">
        <div class="search-wrapper">
            <!-- ...existing search container code... -->
        </div>

        <div class="location-view">
            <?php
            // 投稿を取得
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1
            );
            $posts_query = new WP_Query($args);

            if ($posts_query->have_posts()) :
                while ($posts_query->have_posts()) : $posts_query->the_post();
                    // 緯度経度を取得
                    $lat = get_post_meta(get_the_ID(), 'lat', true);
                    $lng = get_post_meta(get_the_ID(), 'lng', true);
                    ?>
            <a href="<?php the_permalink(); ?>" class="location-item-link">
                <div class="location-item" data-lat="<?php echo esc_attr($lat); ?>"
                    data-lng="<?php echo esc_attr($lng); ?>">
                    <div class="location-item-img-container">
                        <?php
                        // コンテンツから最初の画像を取得
                        $content = get_the_content();
                        preg_match('/<img[^>]+>/i', $content, $firstImage);
                        
                        if ($firstImage) {
                            echo $firstImage[0];  // 最初の画像を表示
                        } elseif (has_post_thumbnail()) {
                            // 画像が見つからない場合はアイキャッチ画像を表示
                            the_post_thumbnail('medium', ['class' => 'location-item-img']);
                        }
                    ?>
                    </div>
                    <div class="location-item-content">
                        <h2 class="location-item-title"><?php the_title(); ?></h2>
                        <p class="location-item-address"><?php echo get_post_meta(get_the_ID(), 'address', true); ?></p>
                        <div class="location-item-tags-view">
                            <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                    foreach ($tags as $tag) : ?>
                            <span class="location-item-tag"><?php echo $tag->name; ?></span>
                            <?php endforeach;
                                endif;
                                ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
      div/div>
    </div>
</main>

<script>
// 投稿データをJavaScriptで使用できるように変換
const locations = [
    <?php
    if ($posts_query->have_posts()) : while ($posts_query->have_posts()) : $posts_query->the_post();
        $lat = get_post_meta(get_the_ID(), 'lat', true);
        $lng = get_post_meta(get_the_ID(), 'lng', true);
        ?> {
        lat: <?php echo $lat ? $lat : '0'; ?>,
        lng: <?php echo $lng ? $lng : '0'; ?>,
        title: "<?php echo esc_js(get_the_title()); ?>",
        image: "<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>",
        description: "<?php echo esc_js(get_the_excerpt()); ?>"
    },
    <?php endwhile; wp_reset_postdata(); endif; ?>
];
</script>
<?php include get_template_directory() . '/parts/footer.php'; ?>