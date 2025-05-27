<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo("title") ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <!-- 共通 style -->
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/ress.css">
    <?php wp_head() ?>
</head>
<body>
    <header>
    </header>