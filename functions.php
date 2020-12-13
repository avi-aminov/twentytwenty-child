<?php
    /*
    *  create user if not exist
    *  hide admin bar for specific user
    */
    include 'include/create-user.php';

    /*
    *  Register Custom Post Type
    */
    include 'include/cpt-products.php';

    /*
    *  Add Custom Fields To Product
    */
    include 'include/products_metaboxes.php';


    /*
    *  Add Shortcode display product by id
    */
    include 'include/product_shortcode.php';



	add_action( 'wp_enqueue_scripts', 'child_enqueue_parent_styles' );

	function child_enqueue_parent_styles() {
       wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
       wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.css', array(), 20141119 );
	   wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css' );
    
    
        // all scripts
        wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '20120206', true );
        wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '20120206', true );
    }



    /* Helper functions */
    function get_field($key){
        return get_post_meta(get_the_ID(), $key, true);
    }
    
    function is_on_sale(){
        return get_field("cf_product_is_on_sale") == 'checkbox';
    }

    function get_price(){
        $price = 0.0;
        if(is_on_sale()){
            $price = get_field("cf_product_sale_price");
        }else{
            $price = get_field("cf_product_price");
        }
        return $price;
    }

    function get_product_images(){
        $result = array();
        for ($i = 1; $i <= 6; $i++) { 
            if(get_field("cf_product_gallery_".$i)){
                array_push($result, get_field("cf_product_gallery_".$i));
            } 
        }
         return $result;      
    }

    // add filter for shortcode use in widget
    add_filter('widget_text', 'do_shortcode');
?>