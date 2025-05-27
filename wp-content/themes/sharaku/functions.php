<?php
// 特定ページへのstyle
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

// 投稿タイプのテンプレート構造（固定見出しブロックを使用）
add_action('init', function () {
  $post_type = get_post_type_object('post');
  if ($post_type) {
    $post_type->template = [
      // main images max 4（ロックしない）
      ['core/gallery', [
        'columns' => 4,
        'align' => 'wide',
        'className' => 'main-gallery',
        'lock' => false  // ギャラリーは編集可能
      ]],
      // access
      ['core/heading', [
        'level' => 3,
        'content' => 'アクセス',
        'className' => 'fixed-heading'
      ]],
      ['core/paragraph', ['placeholder' => 'アクセス情報を入力']],
      // station
      ['core/heading', [
        'level' => 3,
        'content' => '最寄り駅',
        'className' => 'fixed-heading'
      ]],
      ['core/paragraph', ['placeholder' => '最寄り駅情報を入力']],
      ['core/embed', [
        'providerNameSlug' => 'google-maps',
        'className' => 'location-map'
      ]],
      // location
      ['core/heading', [
        'level' => 3,
        'content' => '時期',
        'className' => 'fixed-heading'
      ]],
      ['core/paragraph', ['placeholder' => '例：3月下旬〜4月上旬']],
      // points
      ['core/heading', [
        'level' => 3,
        'content' => 'おすすめポイント',
        'className' => 'fixed-heading'
      ]],
      ['core/image', [
          'className' => 'point-image'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントのタイトル1',
          'className' => 'point-title'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントの説明',
          'className' => 'point-description'
      ]],['core/image', [
          'className' => 'point-image'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントのタイトル2',
          'className' => 'point-title'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントの説明',
          'className' => 'point-description'
      ]],['core/image', [
          'className' => 'point-image'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントのタイトル3',
          'className' => 'point-title'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントの説明',
          'className' => 'point-description'
      ]],['core/image', [
          'className' => 'point-image'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントのタイトル4',
          'className' => 'point-title'
      ]],
      ['core/paragraph', [
          'placeholder' => 'ポイントの説明',
          'className' => 'point-description'
      ]],
    ];
    $post_type->template_lock = 'all';
  }
});