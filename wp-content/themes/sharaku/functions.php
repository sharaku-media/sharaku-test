<?php
// ✅ 投稿詳細ページやトップページで必要な CSS/JS を読み込む
function sharaku_enqueue_assets() {
      // 共通のスタイルシートを読み込む（全ページ共通）
    wp_enqueue_style(
        'sharaku-style',
        get_stylesheet_uri()  // style.cssを読み込む
    );

    // index.cssを全ページで読み込む（モバイル検索のスタイルを含む）
    wp_enqueue_style(
        'sharaku-index-style',
        get_template_directory_uri() . '/styles/index.css',
        [], 
        null
    );

    // 共通のJavaScriptを読み込む（全ページ共通）
    wp_enqueue_script(
        'sharaku-common-script',
        get_template_directory_uri() . '/scripts/common.js',
        [],
        null,
        true
    );

  // モバイル検索のスクリプトを全ページで読み込む
    wp_enqueue_script(
        'sharaku-mobile-search-script',
        get_template_directory_uri() . '/scripts/mobile-search.js',
        ['sharaku-common-script'], // common.jsに依存
        null,
        true
    );

  // 投稿詳細ページ用のアセット
    if (is_singular('post')) {
    wp_enqueue_style(
        'sharaku-single-post-style',
        get_template_directory_uri() . '/styles/single-post.css'
    );

    wp_enqueue_script(
        'sharaku-slider-script',
        get_template_directory_uri() . '/scripts/slider.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'sharaku-image-modal-script',
        get_template_directory_uri() . '/scripts/image-modal.js',
        [],
        null,
        true
        );
    }

  // ✅ 記事一覧（archive-article.php 用）
    if (is_post_type_archive('article')) {
        wp_enqueue_style(
            'sharaku-archive-article-style',
            get_template_directory_uri() . '/styles/archive-article.css'
        );
        // ★ 新規追加：記事検索用スクリプト
        wp_enqueue_script(
            'sharaku-article-search-script',
            get_template_directory_uri() . '/scripts/article-search.js',
            [],
            null,
            true
        );
    }

  // ✅ 記事詳細（single-article.php 用）
    if (is_singular('article')) {
        // archive-article.cssを先に読み込む（依存関係として）
        wp_enqueue_style(
            'sharaku-archive-article-style-for-single',
            get_template_directory_uri() . '/styles/archive-article.css'
        );
        
        // single-article.cssを読み込む（archive-article.cssに依存）
        wp_enqueue_style(
            'sharaku-single-article-style',
            get_template_directory_uri() . '/styles/single-article.css',
            // array('sharaku-archive-article-style-for-single') // 依存関係を指定
        );
    }

    if (is_front_page() || is_home()) {
    // index.cssは既に上で読み込み済みなので、ここでは読み込まない

    // index.jsを読み込む（モバイル検索は既に全ページで読み込み済み）
    wp_enqueue_script(
        'sharaku-index-script',
        get_template_directory_uri() . '/scripts/index.js',
        ['sharaku-mobile-search-script'], // mobile-search.jsに依存
        null,
        true
    );

    // その後にGoogle Maps APIを読み込む
    wp_enqueue_script(
        'google-maps',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCR_Nu28owuza4O4zP-LZUMMIelifwVP5g&callback=initMap',
        ['sharaku-index-script'], // index.jsに依存
        null,
        true
    );
  }
}
add_action('wp_enqueue_scripts', 'sharaku_enqueue_assets');

// WordPressのネイティブLazy Loadを有効化
add_filter('wp_lazy_loading_enabled', '__return_true');

function create_article_post_type() {
    // アイキャッチ画像を有効化
    add_theme_support('post-thumbnails');
    register_post_type('article',
    array(
        'labels' => array(
            'name'          => '記事',
            'singular_name' => '記事',
            'featured_image'        => 'アイキャッチ画像',
            'set_featured_image'    => 'アイキャッチ画像を設定',
            'remove_featured_image' => 'アイキャッチ画像を削除',
            'use_featured_image'    => 'アイキャッチ画像として使用'
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_position'=> 5,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'article'),
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions')
        )
    );
}
add_action('init', 'create_article_post_type');

// パーマリンクを自動更新（カスタム投稿タイプ登録後）
function sharaku_flush_rewrite_rules() {
    create_article_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'sharaku_flush_rewrite_rules');

// テーマ切り替え時にもパーマリンクを更新
function sharaku_theme_activation() {
    create_article_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'sharaku_theme_activation');

// 記事(article)のブロックエディタ初期構成
add_action('init', function () {
    $post_type = get_post_type_object('article');
    if ($post_type) {
        $post_type->template = [
            // 1. はじめに
            ['core/group', [
                'className' => 'block-section intro-section'
            ], [
                ['core/heading', [
                    'level' => 3,
                    'content' => 'はじめに', // ←編集可能
                    'className' => 'fixed-heading'
                ]],
                ['core/paragraph', [
                    'placeholder' => '記事の導入文を入力してください',
                    'className' => 'paragraph-intro'
                ]]
            ]],

            // 3. 使用機材
            ['core/group', [
                'className' => 'block-section tools-section'
            ], [
                ['core/heading', [
                    'level' => 3,
                    'content' => '使用した機材・アプリ', // ←編集可能
                    'className' => 'fixed-heading'
                ]],
                ['core/list', [
                    'placeholder' => '使用機材を箇条書きで入力'
                ]]
            ]],

            // 4. ステップ解説セクション
            ['core/group', ['className' => 'block-section steps-wrapper'], [
                ['core/heading', [
                    'level' => 3,
                    'content' => 'ステップ解説',
                    'className' => 'fixed-heading'
                ]],

                // ステップ1
                ['core/group', ['className' => 'block-section step-section'], [
                    ['core/heading', [
                        'level' => 3,
                        'content' => 'STEP1：タイトルを入力', // ←初期値、自由に編集可能
                    ]],
                    ['core/image', [
                        'className' => 'step-image',
                        'align' => 'center'
                    ]],
                    ['core/paragraph', ['placeholder' => 'ここに解説を入力']]
                ]],

                // ステップ2
                ['core/group', ['className' => 'block-section step-section'], [
                    ['core/heading', [
                        'level' => 3,
                        'content' => 'STEP2：タイトルを入力',
                    ]],
                    ['core/image', [
                        'className' => 'step-image',
                        'align' => 'center'
                    ]],
                    ['core/paragraph', ['placeholder' => 'ここに解説を入力']]
                ]],

                // ステップ3
                ['core/group', ['className' => 'block-section step-section'], [
                    ['core/heading', [
                        'level' => 3,
                        'content' => 'STEP3：タイトルを入力',
                    ]],
                    ['core/image', [
                        'className' => 'step-image',
                        'align' => 'center'
                    ]],
                    ['core/paragraph', ['placeholder' => 'ここに解説を入力']]
                ]],

                // ステップ4
                ['core/group', ['className' => 'block-section step-section'], [
                    ['core/heading', [
                        'level' => 3,
                        'content' => 'STEP4：タイトルを入力',
                    ]],
                    ['core/image', [
                        'className' => 'step-image',
                        'align' => 'center'
                    ]],
                    ['core/paragraph', ['placeholder' => 'ここに解説を入力']]
                ]],

                // ステップ5
                ['core/group', ['className' => 'block-section step-section'], [
                    ['core/heading', [
                        'level' => 3,
                        'content' => 'STEP5：タイトルを入力',
                    ]],
                    ['core/image', [
                        'className' => 'step-image',
                        'align' => 'center'
                    ]],
                    ['core/paragraph', ['placeholder' => 'ここに解説を入力']]
                ]]
            ]],

            // 5. ワンポイントアドバイス
            ['core/group', ['className' => 'block-section advice-section'], [
                ['core/heading', ['level' => 3, 'content' => 'ワンポイントアドバイス']],
                ['core/paragraph', ['placeholder' => 'ちょっとした補足やプロのコツを書いてください']]
            ]],

            // 6. 自由記述エリア（見出しやコンテンツを自由に追加可能）
            ['core/group', ['className' => 'block-section free-content-section'], [
                ['core/heading', ['level' => 3, 'content' => '追加コンテンツ', 'placeholder' => '見出しを編集できます']],
                ['core/paragraph', ['placeholder' => 'ここに自由にコンテンツを追加できます。見出しブロックも追加できます。']]
            ]],
        ];

        // テンプレートロックを解除して自由に編集可能にする
        $post_type->template_lock = null;
    }
});



// functions.php に追加
function noindex_author_archive() {
  if (is_author()) {
    echo '<meta name="robots" content="noindex, follow">';
  }
}
add_action('wp_head', 'noindex_author_archive');

add_filter( 'author_rewrite_rules', '__return_empty_array' );
function disable_author_archive() {
  if( preg_match( '#/author/.+#', $_SERVER['REQUEST_URI'] ) ){
    wp_redirect( esc_url( home_url( '/' ) ) );
    exit;
  }
}
add_action('init', 'disable_author_archive');

/**
 * デバイス別のアーカイブ表示件数を設定
 * モバイル: 3件、PC: 10件
 */
// PC/スマホで記事アーカイブの表示件数を出し分け
function sharaku_set_archive_posts_per_page( $query ) {
    // 管理画面/メイン以外は除外
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'article' ) ) {
        // デフォルトはPC件数
        $ppp = 10;

        // 1) URLパラメータがあれば最優先 (例: /article/?pp=2)
        if ( isset($_GET['pp']) && is_numeric($_GET['pp']) ) {
            $ppp = max(1, intval($_GET['pp']));
        }
        // 2) 画面幅でフロントJSがセットしたクッキーを優先
        elseif ( isset($_COOKIE['sp_view']) && $_COOKIE['sp_view'] === '1' ) {
            $ppp = 6; // スマホ
        }
        // 3) 最後に UA 判定 (iPad等は false になるので過信しない)
        elseif ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
            $ppp = 6;
        }

        $query->set( 'posts_per_page', $ppp );

        // 念のため（ページネーション保険）
        if ( get_query_var('paged') ) {
            $query->set( 'paged', get_query_var('paged') );
        }
    }
}
add_action( 'pre_get_posts', 'sharaku_set_archive_posts_per_page', 99 ); // 後段で上書きされないよう優先度を上げる


// すべての画像にloading="lazy"属性を追加
function add_lazy_loading_attribute($content) {
    if (!is_admin()) {
        $content = preg_replace('/<img(.*?)\/?>/i', '<img$1 loading="lazy">', $content);
    }
    return $content;
    }
    add_filter('the_content', 'add_lazy_loading_attribute');
    add_filter('post_thumbnail_html', 'add_lazy_loading_attribute');
    add_filter('get_avatar', 'add_lazy_loading_attribute');

    // カスタム画像サイズのサムネイルにもLazy Loadを適用
    function add_lazy_loading_to_attachments($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
    }
    add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading_to_attachments');

    // 投稿タイプのテンプレート構造（固定見出しブロックを使用）
    add_action('init', function () {
    // 投稿に緯度・経度のカスタムフィールドを追加
    function add_lat_lng_meta_box() {
    add_meta_box(
    'lat_lng_meta_box',
    '位置情報（lat, lng）',
    function ($post) {
    $lat = get_post_meta($post->ID, 'lat', true);
    $lng = get_post_meta($post->ID, 'lng', true);
    echo '<label for="lat">緯度 (lat): </label>';
    echo '<input type="text" name="lat" id="lat" value="' . esc_attr($lat) . '" size="25" /><br><br>';
    echo '<label for="lng">経度 (lng): </label>';
    echo '<input type="text" name="lng" id="lng" value="' . esc_attr($lng) . '" size="25" />';
    },
    'post',
    'normal',
    'default'
    );
    }
    add_action('add_meta_boxes', 'add_lat_lng_meta_box');

    function save_lat_lng_meta_box($post_id) {
    if (array_key_exists('lat', $_POST)) {
    update_post_meta($post_id, 'lat', sanitize_text_field($_POST['lat']));
    }
    if (array_key_exists('lng', $_POST)) {
    update_post_meta($post_id, 'lng', sanitize_text_field($_POST['lng']));
    }
    }
    add_action('save_post', 'save_lat_lng_meta_box');
    $post_type = get_post_type_object('post');
    if ($post_type) {
    $post_type->template = [

    // 🖼 メイン画像ギャラリー（編集可能）
    ['core/gallery', [
    'columns' => 4,
    'align' => 'wide',
    'lock' => false
    ]],

    // 📍 住所
    ['core/group', [
    'className' => 'block-section'
    ], [
    ['core/heading', [
    'level' => 3,
    'content' => '住所',
    'className' => 'fixed-heading'
    ]],
    ['core/paragraph', ['placeholder' => '住所情報を入力', 'className' => 'paragraph-access']]
    ]],

    // 🚉 最寄り駅
    ['core/group', [
    'className' => 'block-section'
    ], [
    ['core/heading', [
    'level' => 3,
    'content' => 'アクセス',
    'className' => 'fixed-heading'
    ]],
    ['core/group', [
    'className' => 'station-options'
    ], [
    ['core/paragraph', ['content' => '電車', 'className' => 'label-train']],
    ['core/paragraph', ['content' => 'バス', 'className' => 'label-bus']]
    ]],
    ['core/html', [
    'content' => '<div class="location-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!..." width="100%"
            height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>',
    'className' => 'location-map-wrapper'
    ]]
    ]],

    // 🗓 時期
    ['core/group', [
    'className' => 'block-section'
    ], [
    ['core/heading', [
    'level' => 3,
    'content' => '時期',
    'className' => 'fixed-heading'
    ]],
    ['core/paragraph', ['placeholder' => '例：3月下旬〜4月上旬', 'className' => 'paragraph-season']]
    ]],

    // 詳細
    ['core/group', [
    'className' => 'block-section'
    ], [
    ['core/heading', [
    'level' => 3,
    'content' => '詳細',
    'className' => 'fixed-heading'
    ]],
    ['core/paragraph', [
    'placeholder' => 'ここに詳細情報を入力してください。',
    'className' => 'paragraph-detail'
    ]]
    ]],

    // 🌟 おすすめポイント
    ['core/group', [
    'className' => 'block-section'
    ], [
    ['core/heading', [
    'level' => 3,
    'content' => 'おすすめポイント',
    'className' => 'fixed-heading'
    ]],

    // 🔸 ポイント 1
    ['core/group', ['className' => 'point-group'], [
    ['core/image', ['className' => 'point-image']],
    ['core/group', ['className' => 'point-text-group'], [
    ['core/paragraph', ['placeholder' => 'ポイントのタイトル1', 'className' => 'point-title']],
    ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']]
    ]]
    ]],

    // 🔸 ポイント 2
    ['core/group', ['className' => 'point-group'], [
    ['core/image', ['className' => 'point-image']],
    ['core/group', ['className' => 'point-text-group'], [
    ['core/paragraph', ['placeholder' => 'ポイントのタイトル2', 'className' => 'point-title']],
    ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']]
    ]]
    ]],

    // 🔸 ポイント 3
    ['core/group', ['className' => 'point-group'], [
    ['core/image', ['className' => 'point-image']],
    ['core/group', ['className' => 'point-text-group'], [
    ['core/paragraph', ['placeholder' => 'ポイントのタイトル3', 'className' => 'point-title']],
    ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']]
    ]]
    ]],

    // 🔸 ポイント 4
    ['core/group', ['className' => 'point-group'], [
    ['core/image', ['className' => 'point-image']],
    ['core/group', ['className' => 'point-text-group'], [
    ['core/paragraph', ['placeholder' => 'ポイントのタイトル4', 'className' => 'point-title']],
    ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']]
    ]]
    ]]
    ]]
    ];
    $post_type->template_lock = 'all';
    }
    });

    remove_filter( 'the_content', 'wpautop' );
    remove_filter( 'the_excerpt', 'wpautop' );