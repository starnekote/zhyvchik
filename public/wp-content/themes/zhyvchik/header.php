<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pure Essence</title>
    <?php wp_head(); ?>
</head>
<body>
    <header>
        <div>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.75 18.75L12.75 12.75M14.75 7.75C14.75 11.6134 11.6134 14.75 7.75 14.75C3.88659 14.75 0.75 11.6134 0.75 7.75C0.75 3.88659 3.88659 0.75 7.75 0.75C11.6134 0.75 14.75 3.88659 14.75 7.75L18.75 18.75" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <a class="logo" href="<?php echo home_url(); ?>">
            ЖИВЧИК
        </a>
        <div class="icons">
            <a class="icon" href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.75 4.75C11.75 6.95766 9.95766 8.75 7.75 8.75C5.54234 8.75 3.75 6.95766 3.75 4.75C3.75 2.54234 5.54234 0.75 7.75 0.75C9.95766 0.75 11.75 2.54234 11.75 4.75V4.75M7.75 11.75C3.88659 11.75 0.75 14.8866 0.75 18.75H14.75C14.75 14.8866 11.6134 11.75 7.75 11.75V11.75" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <a class="icon" href="<?php echo wc_get_cart_url(); ?>">
                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.75 8.75V4.75C4.75 2.54234 6.54234 0.75 8.75 0.75C10.9577 0.75 12.75 2.54234 12.75 4.75V8.75L1.75 6.75M1.75 6.75H15.75L16.75 18.75H0.75L1.75 6.75Z" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </header>