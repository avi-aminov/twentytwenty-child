<?php
/*
    single product page
*/
get_header();
?>
<?php
    // get product images for carousel
    $carusel_images = get_product_images();
?>

<div class="container">
    <div class="col-md-12 <?php echo is_on_sale() ? ' sale ' : '';?>">
        <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="col-md-8">
                <h2 class="mb-0 title"> <?php echo  the_title(); ?> </h2>
                <div class="produuct-text mb-auto">
                    <?php echo the_content(); ?>
                </div>
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
                <div class="btn btn-dark btn-single" role="button"><?php echo _e( 'Add to cart', 'default' ); ?></div>
                <br>
            </div>

            <div class="col-md-4">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <?php 
                        $is_active = true;
                        for ($i = 1; $i <= count($carusel_images) - 1; $i++) { 
                        ?>
                            <div class="carousel-item <?php echo $is_active ? ' active ' : ''?>">
                                <img class="d-block w-100" src="<?php echo $carusel_images[$i]; ?>" alt="First slide">
                            </div>
                        <?php
                        $is_active = false;
                        }
                    ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    </div>
                </diV>
            </div>

            <div class="col-md-12">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_field("cf_product_video");?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
<div>

<h2 class="released-product-center"> <?php echo _e( 'Released Product', 'default' ); ?> </h2>
<?php
    wp_reset_postdata(); 

    $cat_id = get_the_category()[0]->term_id;
    $args = array(
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'post_type' => 'product',
        'cat' => $cat_id,
    );
    $wp_query = new WP_Query( $args );
    
    if ( $wp_query->have_posts() ) {

        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();
            ?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mt-3 <?php echo is_on_sale() ? ' sale ' : '';?>">
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
        }
    }
    wp_reset_postdata(); 
?>
</div>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
