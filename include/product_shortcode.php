<?php

add_shortcode('product', 'product_query');
function product_query($atts, $content){

    extract(shortcode_atts(array(
        'id' => null,
        'color' => '')
        , $atts)
    );

    $args = array(  
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'p' => $atts['id']
    );

    if(isset($atts['id']) && $atts['id']){
        $args['p'] = $atts['id'];
    }else {
        return false;
    }

    global $post;
    $loop = new WP_Query( $args ); 
    $output = '';

    if ($loop->have_posts()){

        while ($loop->have_posts()) {
            $loop->the_post();

            $is_on_sale = is_on_sale() ? ' sale ' : '';
            $title = get_the_title();
            $link = get_permalink();
            $image = get_field("cf_product_gallery_1");
            $price = get_price();
            $product_price = get_field("cf_product_price");
            $btn_text = 'Add to cart';
            $bg_color = "background: ".$color.";";

            $output = <<<HEREDOC
            <div  class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-4 $is_on_sale">
			<span class="on-sale">On Sale</span>
				<div style="$bg_color" class="card shadow">
					<div class="card-body text-center">
						<h3 class="text-warning"></h3>
						<a href="$link">
							<img class="card-img-top" src="$image" alt="">
						</a>
						<a class="text-reset" href="$link">
							<h4 class="card-title">$title</h4>
						</a>
						<h4>
						<span class="price">
							<span class="product-price-amount">
								<bdi>
									<span class="product-price-currencySymbol">$</span>
									$price
								</bdi>
								<bdi class="old-price">
									<span class="product-price-currencySymbol">$</span>
									$product_price
								</bdi>
							</span>
						</span>
						</h4>
						<a class="btn btn-dark my-2" href="#" role="button">$btn_text</a>
					</div>
				</div>
            </div>  
HEREDOC;
        }

    }else{
        return; // no posts found
    }
    
    wp_reset_query();
    return html_entity_decode($output);
}


// add filter for shortcode use in widget
add_filter('widget_text', 'do_shortcode');