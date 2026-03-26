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

// ФУНКЦІЯ ЩО ЗАМІНЯЄ КЛАСИЧНЕ ВІДОБРАЖЕННЯ РЕЙТИНГУ НА SVG ЗІРОЧКИ

add_filter( 'woocommerce_product_get_rating_html', 'custom_svg_star_rating_html', 10, 3 );

function custom_svg_star_rating_html( $html, $rating, $count ) {
    // Якщо рейтинг дорівнює нулю, нічого не виводимо (стандартна поведінка WooCommerce)
    // Якщо хочете виводити 5 пустих зірок навіть для товарів без відгуків, закоментуйте наступний рядок:
    if ( 0 == $rating ) {
        return '';
    }

    // Округлюємо рейтинг за математичними правилами (4.4 -> 4, 4.5 -> 5)
    // Якщо потрібно завжди округлювати в меншу сторону (наприклад, 4.9 -> 4), замініть round() на floor()
    $rounded_rating = round( $rating );

    // Шлях до папки з вашими SVG (перевірте, чи правильний шлях для вашої теми)
    $svg_dir = get_stylesheet_directory_uri() . '/assets/images/'; // змініть на свій шлях

    // Формуємо обгортку
    $custom_html = '<div class="custom-star-rating" aria-label="' . esc_attr( sprintf( __( 'Оцінено в %s з 5', 'woocommerce' ), $rating ) ) . '">';

    // Цикл для 5 зірочок
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $i <= $rounded_rating ) {
            // Замальована зірочка
            $custom_html .= '<img src="' . esc_url( $svg_dir . 'star-full.svg' ) . '" alt="full star" class="star-icon" />';
        } else {
            // Пуста зірочка
            $custom_html .= '<img src="' . esc_url( $svg_dir . 'star-empty.svg' ) . '" alt="empty star" class="star-icon" />';
        }
    }

    $custom_html .= '</div>';

    return $custom_html;
}



// remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

?>