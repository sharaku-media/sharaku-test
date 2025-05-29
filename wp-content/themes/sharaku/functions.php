<?php
// ✅ 投稿詳細ページでのみ CSS/JS を読み込む
function sharaku_enqueue_assets() {
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
  }
}
add_action('wp_enqueue_scripts', 'sharaku_enqueue_assets');


// ✅ 投稿タイプ「post」のテンプレート構造を定義
add_action('init', function () {
  $post_type = get_post_type_object('post');
  if ($post_type) {
    $post_type->template = [

      // 🖼 メイン画像ギャラリー（編集可能）
      ['core/gallery', [
        'columns' => 4,
        'align' => 'wide',
        'lock' => false
      ]],

      // 📍 アクセス
      ['core/group', [
        'className' => 'block-section'
      ], [
        ['core/heading', [
          'level' => 3,
          'content' => 'アクセス',
          'className' => 'fixed-heading'
        ]],
        ['core/paragraph', ['placeholder' => 'アクセス情報を入力', 'className' => 'paragraph-access']]
      ]],

      // 🚉 最寄り駅
      ['core/group', [
        'className' => 'block-section'
      ], [
        ['core/heading', [
          'level' => 3,
          'content' => '最寄り駅',
          'className' => 'fixed-heading'
        ]],
        ['core/group', [
          'className' => 'station-options'
        ], [
          ['core/paragraph', ['content' => '電車', 'className' => 'label-train']],
          ['core/paragraph', ['content' => 'バス', 'className' => 'label-bus']],
          ['core/paragraph', ['content' => '徒歩', 'className' => 'label-walk']]
        ]],
        ['core/html', [
          'content' => '<div class="location-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>',
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