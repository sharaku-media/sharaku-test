<?php
// ✅ Gutenbergエディター用スタイルの適用
// function my_editor_styles() {
//   add_theme_support('editor-styles');
//   add_editor_style('editor-style.css');
//   add_theme_support('block-templates');
// }
// add_action('after_setup_theme', 'my_editor_styles');

// 特定ページへのstyle
function sharaku_enqueue_single_post_style() {
  if (is_singular('post')) {
    wp_enqueue_style(
      'sharaku-single-post-style',
      get_template_directory_uri() . '/styles/single-post.css',
      [], // 依存関係
      null // バージョン（キャッシュ対策したい場合は time() や '1.0' など）
    );
  }
}
add_action('wp_enqueue_scripts', 'sharaku_enqueue_single_post_style');

// 投稿タイプのテンプレート構造（固定見出しブロックを使用）
add_action('init', function () {
  $post_type = get_post_type_object('post');
  if ($post_type) {
    $post_type->template = [
      // main images max 4
      ['core/gallery', [
        'columns' => 4,
        'align' => 'wide',
        'className' => 'main-gallery'
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