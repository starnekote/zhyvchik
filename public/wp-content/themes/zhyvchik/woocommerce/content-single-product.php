<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );
// Додає айді головного зобоаження в масив галереї
$product_img_id = $product->get_image_id();
$product_gallery_ids = $product->get_gallery_image_ids();
array_unshift($product_gallery_ids, (int) $product_img_id);
?>

<!-- ХЛІБНІ КРИХТИ -->
<section class="zhyvchik-breadcrumb">
	<div class="container">
		<?php woocommerce_breadcrumb(); ?>
	</div>
</section>

<!-- ГАЛЕРЕЯ ТОВАРУ -->
<section class="zhyvchik-product-gallery">
	<div class="container">
		<div class="product-gallery-main-swiper">
			<ul class="swiper-wrapper">
				<?php foreach ($product_gallery_ids as $product_gallery_id): ?>
					<li class="swiper-slide">
						<div class="img-wrapper">
							<img src="<?php echo wp_get_attachment_url($product_gallery_id); ?>" alt="">
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="product-gallery-thumb-swiper">
			<ul class="swiper-wrapper">
				<?php foreach ($product_gallery_ids as $product_gallery_id): ?>
					<li class="swiper-slide">
						<div class="img-wrapper">
							<img src="<?php echo wp_get_attachment_url($product_gallery_id); ?>" alt="">
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<!-- НАЗВА ТОВАРУ -->
 <section class="zhyvchik-product-name">
	<div class="container">
		<h2>назва товару</h2>
		<div class="title"><h1>Взірець № <?php echo $product->get_id(); ?> -</h1><?php woocommerce_template_single_title(); ?></div>
	</div>
 </section>

<!-- ХАРАКТЕРИСТИКИ -->
  <section class="zhyvchik-atributes">
	<div class="container">
		<div><?php woocommerce_product_additional_information_tab(); ?></div>
	</div>
 </section>

<!-- ЦІНА -->
  <section class="zhyvchik-">
	<div class="container">
		<div><?php woocommerce_template_single_price(); ?></div>
	</div>
 </section>

<!-- КНОПКИ -->
  <section class="zhyvchik-">
	<div class="container">
		<div><?php woocommerce_template_single_add_to_cart(); ?></div>
	</div>
 </section>

<!-- ВІДГУКИ -->
  <section class="zhyvchik-">
	<div class="container">
		<div><?php comments_template(); ?></div>
	</div>
 </section>

<!-- ДОПРОДАЖІ -->
  <section class="zhyvchik-">
	<div class="container">
		<div><?php woocommerce_upsell_display(); ?></div>
	</div>
 </section>


<?php do_action( 'woocommerce_after_single_product' ); ?>
