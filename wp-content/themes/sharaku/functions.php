<?php

function my_editor_styles() {
  add_theme_support('editor-styles');
  add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'my_editor_styles');

add_action('rest_api_init', function () {
  register_rest_field('post', 'style', [
    'get_callback' => function ($post_arr) {
      // 投稿ごとに違うスタイルを設定する場合は $post_arr['id'] を使って処理可能
      return [
        'font' => 'Courier New',
        'fontSize' => '18px',
        'color' => '#333333',
        'backgroundColor' => '#ffe4e1',
      ];
    },
    'schema' => [
      'description' => 'Custom style settings for the post.',
      'type'        => 'object',
      'context'     => ['view', 'edit'],
    ],
  ]);
});