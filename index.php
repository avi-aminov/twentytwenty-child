<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<main id="site-content" role="main">
<div class="container mb-4">
    <div class="row">
		<?php
		// Query from post type product order by title and show 6 product per page
		$args = array(  
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => 6, 
			'orderby' => 'title', 
			'order' => 'ASC', 
		);

		$loop = new WP_Query( $args ); 
			
		while ( $loop->have_posts() ) : $loop->the_post();
		// drow product 
		?>
			<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-4 <?php echo is_on_sale() ? ' sale ' : '';?>">
			<span class="on-sale">On Sale</span>
				<div class="card shadow">
					<div class="card-body text-center">
						<h3 class="text-warning"></h3>
						<a href="<?php echo get_permalink(); ?>">
							<img class="card-img-top" src="<?php echo get_field("cf_product_gallery_1"); ?>" alt="">
						</a>
						<a class="text-reset" href="<?php echo get_permalink(); ?>">
							<h4 class="card-title"><?php echo the_title(); ?></h4>
						</a>
						<h4>
						<span class="price">
							<span class="product-price-amount">
								<bdi>
									<span class="product-price-currencySymbol">$</span>
									<?php echo get_price();?>
								</bdi>
								<bdi class="old-price">
									<span class="product-price-currencySymbol">$</span>
									<?php echo get_field("cf_product_price");?>
								</bdi>
							</span>
						</span>
						</h4>
						<a class="btn btn-dark my-2" href="#" role="button"><?php echo _e( 'Add to cart', 'default' ); ?></a>
					</div>
				</div>
			</div>
		<?php
		endwhile;
		wp_reset_postdata(); 
		?>
    </div>
</div>
</main><!-- #site-content -->
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
<?php
get_footer();
