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
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/ress.css">
    <?php wp_head() ?>
</head>
<body>
    <!-- ここの下にheaderを用意 -->
    <!-- <Header /> -->
        <div
            class="flex items-center justify-between px-4 py-1 sticky top-0 bg-white z-10">
            <a href="playground.html">
                <h1 class="uppercase text-[32px] font-bold">sharaku</h1>
            </a>
            <div
                class="w-[36px] aspect-square rounded-full border border-black flex items-center justify-center">
                <span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24">
                        <g
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2">
                            <path d="m21 21l-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </g>
                    </svg>
                </span>
            </div>
        </div>
