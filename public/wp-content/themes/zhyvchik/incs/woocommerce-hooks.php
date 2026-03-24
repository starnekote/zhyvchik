<?php 
add_filter('woocommerce_enqueue_styles', '__return_false');


// ФУНКЦІЯ ЩО ДОДАЄ ЗОБРАЖЕННЯ В КАТЕГОРІЮ ПРИ ВІДОБРАЖЕННІ В МЕНЮ
add_filter( 'nav_menu_item_title', 'add_woo_category_image_to_menu', 10, 4 );
function add_woo_category_image_to_menu( $title, $item, $args, $depth ) {
    // 1. Перевіряємо, чи це категорія товарів WooCommerce
    if ( $item->type === 'taxonomy' && $item->object === 'product_cat' ) {
        $category_id = $item->object_id;
        $thumbnail_id = get_term_meta( $category_id, 'thumbnail_id', true );

        if ( $thumbnail_id ) {
            // 2. Отримуємо URL повнорозмірного зображення
            $image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );

            if ( $image_url ) {
                // 3. Формуємо тег зображення
                $img_tag = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $item->title ) . '" class="menu-cat-img">';
                
                // 4. Огортаємо оригінальний заголовок ($title) у span
                $title_span = '<span class="menu-cat-title">' . $title . '</span>';
                
                // 5. Збираємо все докупи: спочатку картинка, потім span з текстом
                // (Порядок тут не важливий, якщо ви використовуєте flex-direction: column-reverse)
                $title = $img_tag . $title_span;
            }
        }
    }

    return $title;
}

?>