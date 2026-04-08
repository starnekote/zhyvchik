<?php 
require_once get_template_directory().'/incs/woocommerce-hooks.php';
add_action('after_setup_theme', function() {add_theme_support('woocommerce');});

add_action('wp_enqueue_scripts', 'add_scripts_and_styles');
function add_scripts_and_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('swiper', get_template_directory_uri().'/assets/css/swiper-bundle.min.css');
    wp_enqueue_script('main', get_template_directory_uri().'/assets/js/main.js', array('jquery', 'wc-cart'), null, true);
    wp_enqueue_script('swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', array(), null, true);
}

add_action('after_setup_theme', 'add_menu');
    function add_menu() {
        register_nav_menu('top', 'Головне меню');
        register_nav_menu('category', 'Меню каталог товарів');
        }

add_action('widgets_init', function() {
    register_sidebar(
        array(
            'name' => 'Фільтр',
            'id' => 'filter'
        )
    );
});

// ДОДАВАННЯ КЛАСІВ ДО ПУНКТІВ КОНКРЕТНОГО МЕНЮ
add_filter( 'nav_menu_css_class', 'add_custom_class_to_top_menu', 10, 4 );

function add_custom_class_to_top_menu( $classes, $item, $args, $depth ) {
    // Перевіряємо, чи це наше меню 'top'
    if ( isset($args->theme_location) && $args->theme_location === 'category' ) {
        // Додаємо ваш клас до масиву існуючих класів
        $classes[] = 'swiper-slide';
    }

    return $classes;
}

function woocommerce_add_filter() {
    dynamic_sidebar('filter');
}

add_filter( 'gettext', 'custom_woocommerce_filter_button_text', 20, 3 );
function custom_woocommerce_filter_button_text( $translated_text, $text, $domain ) {
    if ( $domain === 'woocommerce' && $text === 'Filter' ) {
        $translated_text = 'Фільтр'; // Ваш новий текст
    }
    return $translated_text;
}


add_filter( 'woocommerce_catalog_orderby', 'custom_remove_sorting_options' );
function custom_remove_sorting_options( $options ) {
    
    // Приклади опцій (назви ключів):
    // 'menu_order' — стандартне сортування
    // 'popularity' — за популярністю
    // 'rating' — за рейтингом
    // 'date' — нові надходження
    // 'price' — ціна ↑
    // 'price-desc' — ціна ↓

    // Видаляємо зайві
    unset( $options['popularity'] );
    unset( $options['menu_order'] );

    $options['date'] = 'Найновіші';
    $options['rating']      = 'За рейтингом';
    $options['price']      = 'Дешеві';
    $options['price-desc'] = 'Дорогі';

    return $options;
}

?>