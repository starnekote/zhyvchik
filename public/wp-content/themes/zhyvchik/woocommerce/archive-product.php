<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
	<!-- ХЕДЕР КАТЕГОРІЇ -->
	 <section class="catalog-header">
		<div class="container">
			<?php woocommerce_product_taxonomy_archive_header(); ?>
		</div>
	 </section>

    <!-- МЕНЮ КАТЕГОРІЇ -->
     <section class="catalog-categories">
        <div class="container">
            <?php
                wp_nav_menu( [
                    'theme_location'  => 'category', //ідентифікатор нашого меню
                    'menu'            => '', //меню яке потрібно вивести
                    'container'       => 'div', //чим огортати тег ul
                    'container_class' => 'catalog-swiper', //клас контейнера меню
					'menu_class'      => 'swiper-wrapper'
                ] );
            ?>
        </div>
    </section>

	<!-- ФІЛЬТРАЦІЯ СОРТУВАННЯ -->
	 <section class="catalog-filter-sort">
			<div class="container">
				<div class="filter">
					<?php woocommerce_add_filter(); ?>
				</div>
				<div class="sort">
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			</div>
	 </section>

	<!-- ТОВАРИ -->
	<section class="products">
		<div class="container">
			<div class="product-wrapper">
				<?php
					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();
				?>
			</div>
		</div>
	</section>

	<!-- ПАГІНАЦІЯ -->
	 <section class="catalog-pagination">
		<div class="container">
			<?php the_posts_pagination(); ?>
		</div>
	 </section>


	<?php get_footer( 'shop' ); ?>
