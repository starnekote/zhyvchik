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
        <button>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.75 18.75L12.75 12.75M14.75 7.75C14.75 11.6134 11.6134 14.75 7.75 14.75C3.88659 14.75 0.75 11.6134 0.75 7.75C0.75 3.88659 3.88659 0.75 7.75 0.75C11.6134 0.75 14.75 3.88659 14.75 7.75L18.75 18.75" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <a class="logo" href="">
            ЖИВЧИК<br>
        </a>
        <div>
            <button>
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.75 4.75C11.75 6.95766 9.95766 8.75 7.75 8.75C5.54234 8.75 3.75 6.95766 3.75 4.75C3.75 2.54234 5.54234 0.75 7.75 0.75C9.95766 0.75 11.75 2.54234 11.75 4.75V4.75M7.75 11.75C3.88659 11.75 0.75 14.8866 0.75 18.75H14.75C14.75 14.8866 11.6134 11.75 7.75 11.75V11.75" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button>
                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.75 8.75V4.75C4.75 2.54234 6.54234 0.75 8.75 0.75C10.9577 0.75 12.75 2.54234 12.75 4.75V8.75L1.75 6.75M1.75 6.75H15.75L16.75 18.75H0.75L1.75 6.75Z" stroke="#2D2D2D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </header>
    <section class="hero">
        <div class="hero-swiper">
            <ul class="swiper-wrapper">
                <?php 
                    $posts = get_posts([
                        'numberposts' => -1,
                        'category_name' => 'hero-section',
                        'post_type' => 'post',
                        'suppress_filters' => true
                        ]);
                    foreach($posts as $post) {
                        setup_postdata($post);
                ?>  
                    <li class="swiper-slide"
                    style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
                        <h1><?php the_title(); ?></h1>
                        <h2><?php the_content(); ?></h2>
                        <button><?php echo CFS()->get('button-text'); ?></button>
                    </li>
                <?php
                }
                wp_reset_postdata();
                ?>
            </ul>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- КАТЕГОРІЇ -->
     <section class="categories">
        <div class="container">
            <?php
                wp_nav_menu( [
                    'theme_location'  => 'top', //ідентифікатор нашого меню
                    'menu'            => '', //меню яке потрібно вивести
                    'container'       => 'div', //чим огортати тег ul
                    'container_class' => 'front-page-menu', //клас контейнера меню
                ] );
            ?>
        </div>
    </section>

    <!-- ОСТАННІ НАДХОДЖЕННЯ -->
    <section class="last-arrivals">
        <div class="container">
            <div class="last-arrivals-header">
                <h2>останні</h2>
                <span>
                    <h1>Надходження</h1>
                    <a href="">Дивитись всі</a>
                </span>
            </div>
            <?php echo do_shortcode('[recent_products class="product-swiper"]'); ?>
        </div>
    </section>
<?php wp_footer(); ?>
</body>
</html>