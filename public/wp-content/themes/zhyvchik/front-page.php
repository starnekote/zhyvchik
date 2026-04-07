<?php get_header(); ?>
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
        </div>
        <div class="product-container">
            <?php echo do_shortcode('[recent_products class="product-swiper"]'); ?>
        </div>
    </section>

    <!-- СТАТТІ -->
    <section class="journal">
        <div class="container">
            <h1>The Art of Fine Beverages</h1>
            <h2>Exploring the subtle nuances of mineral profiles and the heritage of world-class springs.</h2>
            <a href="">Read Our Journal</a>
        </div>
    </section>
    <?php get_footer(); ?> 
