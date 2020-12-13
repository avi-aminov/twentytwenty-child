<?php

    add_action('rest_api_init', function () {
        register_rest_route( 'json-api/v1', 'products/(?P<category_id>\d+)',array(
                    'methods'  => 'GET',
                    'callback' => 'get_product_by_category'
        ));
    });

    function get_product_by_category($request) {

        $args = array(
            'post_type' => 'product',
            'category' => $request['category_id'],
        );
    
        $posts = get_posts($args);
        if (empty($posts)) {
            return new WP_Error( 'empty_category', 'there is no product in this category', array('status' => 404) );
        }

        $output = array();
        foreach ($posts as $p) {
            $temp['id'] = $p->ID;
            $temp['title'] = $p->post_title;
            $temp['description'] = $p->post_content;
            $temp['images'] = get_post_meta($p->ID, "cf_product_gallery_1", true);
            $temp['price'] = get_post_meta($p->ID, "cf_product_price", true);
            $temp['sale_price'] = get_post_meta($p->ID, "cf_product_sale_price", true);
            $temp['is_on_sale'] = get_post_meta($p->ID, "cf_product_is_on_sale", true) ? "on sale" : "not on sale";
            array_push($output, $temp);
        }
    
        $response = new WP_REST_Response($output);
        $response->set_status(200);
    
        return $response;
    }
    