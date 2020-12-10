<?php

/*
* create new user if not exist
*/
function createUser() {
    $userEmail = "wptest@elementor.com";
    $userName = "wp-test";
    $password = "123456789";

    $user = email_exists( $userEmail );
    if (!$user) {
        $user_id = wp_create_user( $userName, $password, $userEmail );
        $user_id_role = new WP_User($user_id);
        $user_id_role->set_role('editor');
    }
}

/*
*   hide admin bar for specific user
*/
function remove_admin_bar_for_specific_user() {
    if(is_user_logged_in()){
        $current_user = wp_get_current_user();
        if (!is_admin() && $current_user->data->user_email == "wptest@elementor.com") {
            show_admin_bar(false);
        }
    }   
}

/*
* run createUser function after setup theme
*/
add_action( 'after_setup_theme', 'createUser' );
add_action('after_setup_theme', 'remove_admin_bar_for_specific_user');



