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

add_filter( 'woocommerce_billing_fields', 'make_billing_fields_optional', 9999 );

function make_billing_fields_optional( $fields ) {
    // Список полів, які ми робимо необов'язковими
    $not_required_fields = array(
        'billing_company', 
        'billing_country', 
        'billing_address_1',
        'billing_address_2', 
        'billing_city', 
        'billing_state',
        'billing_postcode', 
        'billing_email'
    );

    foreach ( $not_required_fields as $field ) {
        if ( isset( $fields[ $field ] ) ) {
            $fields[ $field ]['required'] = false;
        }
    }

    return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields_placeholders', 9999 );

function custom_override_checkout_fields_placeholders( $fields ) {
    // Плейсхолдер для імені
    $fields['billing']['billing_first_name']['placeholder'] = 'Ваше ім’я';
    
    // Плейсхолдер для прізвища
    $fields['billing']['billing_last_name']['placeholder'] = 'Ваше прізвище';
    
    // Плейсхолдер для телефону
    $fields['billing']['billing_phone']['placeholder'] = '+380';

    return $fields;
}

add_filter('woocommerce_cart_totals_order_total_html', function($value) {

    if ( ! is_cart() || is_checkout() ) {
        return $value;
    }

    $cart = WC()->cart;

    // повний total (з доставкою)
    $total = (float) $cart->get_total('edit');

    // доставка + податок доставки
    $shipping = (float) $cart->get_shipping_total() + (float) $cart->get_shipping_tax();

    // total БЕЗ доставки
    $new_total = $total - $shipping;

    return wc_price($new_total);
});

?>