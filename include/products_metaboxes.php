<?php 
/**
 *  add metaboxes to Product post type
 */
function add_products_metaboxes() {
	add_meta_box('cf_product_details', 'Product Details', 'cf_product_details', 'product', 'normal', 'high');
}

/**
 *  Output the HTML for the metabox.
 */
function cf_product_details() {
	global $post;
    wp_nonce_field( basename( __FILE__ ), 'product_fields' );
	
	// price field
	$price = get_post_meta( $post->ID, 'cf_product_price', true );
	// sale price field
	$sale_price = get_post_meta( $post->ID, 'cf_product_sale_price', true );
	// youtube link field
	$video = get_post_meta( $post->ID, 'cf_product_video', true );
	// is product on sale field
	$is_on_sale = get_post_meta( $post->ID, 'cf_product_is_on_sale', true );
    ?>
	
    <p>
    	<label for="cf_product_price">Price</label>
    	<br>
    	<input type="text" name="cf_product_price" id="cf_product_price" class="regular-text" value="<?php echo $price; ?>">
    </p>

    <p>
    	<label for="cf_product_sale_price">Sale Price</label>
    	<br>
    	<input type="text" name="cf_product_sale_price" id="cf_product_sale_price" class="regular-text" value="<?php echo $sale_price; ?>">
    </p>

    <p>
    	<label for="cf_product_video">YouTube Link</label>
    	<br>
    	<input type="text" name="cf_product_video" id="cf_product_video" class="regular-text" value="<?php echo $video; ?>">
    </p>

    <p>
    	<label for="cf_product_is_on_sale">Is on sale?
    		<input type="checkbox" name="cf_product_is_on_sale" value="checkbox" <?php if ( $is_on_sale === 'checkbox' ) echo 'checked'; ?>>
    	</label>
    </p>
    <?php

	// add gallery image to html 
	drowAddImageHtml($post->ID);
}


/**
 * Save the metabox data
 */
function save_products_meta( $post_id, $post ) {

	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Verify this came from the our screen and with proper authorization,
	if (!isset($_POST['product_fields']) || ! wp_verify_nonce( $_POST['product_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// This sanitizes the data from the field and saves it into an array $product_fields.
	$products_meta['cf_product_price'] = esc_textarea( $_POST['cf_product_price'] );
	$products_meta['cf_product_sale_price'] = esc_textarea( $_POST['cf_product_sale_price'] );
	$products_meta['cf_product_video'] = esc_textarea( $_POST['cf_product_video'] );
	$products_meta['cf_product_is_on_sale'] = esc_textarea( $_POST['cf_product_is_on_sale'] );
	$products_meta['cf_product_gallery_1'] = esc_textarea( $_POST['cf_product_gallery_1'] );
	$products_meta['cf_product_gallery_2'] = esc_textarea( $_POST['cf_product_gallery_2'] );
	$products_meta['cf_product_gallery_3'] = esc_textarea( $_POST['cf_product_gallery_3'] );
	$products_meta['cf_product_gallery_4'] = esc_textarea( $_POST['cf_product_gallery_4'] );
	$products_meta['cf_product_gallery_5'] = esc_textarea( $_POST['cf_product_gallery_5'] );
	$products_meta['cf_product_gallery_6'] = esc_textarea( $_POST['cf_product_gallery_6'] );

	// Cycle through the $product_fields array.
	foreach ( $products_meta as $key => $value ) {

		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			// update custom field
			update_post_meta( $post_id, $key, $value );
		} else {
			// add custom field
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}
	}
}

// add js to admin only to product type 
function product_admin_script() {
    global $post_type;
    if( 'product' == $post_type )
    wp_enqueue_script( 'product-admin-script', get_stylesheet_directory_uri() . '/assets/js/admin.js' );
}

// drow add gallery html
function drowAddImageHtml($id){
	for ($i = 1; $i <= 6; $i++) { 
		$temp = get_post_meta( $id, 'cf_product_gallery_'.$i , true )
	?>
		<div class="image-upload-wrap">
			<p>
				<label for="cf_product_gallery_<?php echo $i ?>">Image <?php echo $i ?> Form Gallery</label><br>
				<input type="text" name="cf_product_gallery_<?php echo $i ?>" 
						id="cf_product_gallery_<?php echo $i ?>" class="meta-image regular-text" value="<?php echo $temp; ?>">
				<input type="button" class="button image-upload" value="Browse">
			</p>
			<div class="image-preview"><img src="<?php echo $temp; ?>" style="max-width: 250px;"></div>	
		</div>
	<?php 
	}
}


// save product meta on save post
add_action( 'save_post', 'save_products_meta', 1, 2 );
// add meta boxes to product post type
add_action( 'add_meta_boxes', 'add_products_metaboxes' );
// add custom js to new post / edit post
add_action( 'admin_print_scripts-post-new.php', 'product_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'product_admin_script', 11 );