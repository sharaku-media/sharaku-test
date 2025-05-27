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
        'className' => 'section-access',
        'template' => [
          ['core/heading', [
            'level' => 3,
            'content' => 'アクセス',
            'className' => 'fixed-heading heading-access'
          ]],
          ['core/paragraph', ['placeholder' => 'アクセス情報を入力']]
        ]
      ]],

      // 🚉 最寄り駅
      ['core/group', [
        'className' => 'section-station',
        'template' => [
          ['core/heading', [
            'level' => 3,
            'content' => '最寄り駅',
            'className' => 'fixed-heading heading-station'
          ]],
          ['core/paragraph', ['placeholder' => '最寄り駅情報を入力']],
          ['core/embed', [
            'providerNameSlug' => 'google-maps',
            'className' => 'location-map'
          ]]
        ]
      ]],

      // 🗓 時期
      ['core/group', [
        'className' => 'section-season',
        'template' => [
          ['core/heading', [
            'level' => 3,
            'content' => '時期',
            'className' => 'fixed-heading heading-season'
          ]],
          ['core/paragraph', ['placeholder' => '例：3月下旬〜4月上旬']]
        ]
      ]],

      // 🌟 おすすめポイント
      ['core/group', [
        'className' => 'section-points',
        'template' => [
          ['core/heading', [
            'level' => 3,
            'content' => 'おすすめポイント',
            'className' => 'fixed-heading heading-points'
          ]],

          // 🔸 ポイント 1
          ['core/image', ['className' => 'point-image']],
          ['core/paragraph', ['placeholder' => 'ポイントのタイトル1', 'className' => 'point-title']],
          ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']],

          // 🔸 ポイント 2
          ['core/image', ['className' => 'point-image']],
          ['core/paragraph', ['placeholder' => 'ポイントのタイトル2', 'className' => 'point-title']],
          ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']],

          // 🔸 ポイント 3
          ['core/image', ['className' => 'point-image']],
          ['core/paragraph', ['placeholder' => 'ポイントのタイトル3', 'className' => 'point-title']],
          ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']],

          // 🔸 ポイント 4
          ['core/image', ['className' => 'point-image']],
          ['core/paragraph', ['placeholder' => 'ポイントのタイトル4', 'className' => 'point-title']],
          ['core/paragraph', ['placeholder' => 'ポイントの説明', 'className' => 'point-description']]
        ]
      ]],

    ];
    $post_type->template_lock = 'all';
  }
});