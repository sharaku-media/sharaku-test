<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo("title"); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <!-- 共通 style -->
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri() . '/styles/ress.css') ?>">
    <?php wp_head() ?>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <!-- ここの下にheaderを用意 -->
    <!-- <Header /> -->
    <!-- <header class="mobile-header"> -->
    <!-- logo -->
    <!-- <h1 class="logo">SHARAKU</h1> -->

    <!-- mobile search icon -->
    <!-- <button class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="m21 21l-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </g>
            </svg>
        </button>
    </header> -->