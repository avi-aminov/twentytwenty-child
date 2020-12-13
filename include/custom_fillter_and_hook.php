<?php

// Custom fillter change shortcode 'On Sale' label to 'After fillter On Sale'
add_filter( 'do_shortcode_tag',function ($output, $tag, $attr){

    //make sure it is the right shortcode
    if('product' != $tag){ 
    return $output;
    }

    // return after replace
    return str_replace("On Sale","After fillter On Sale",$output);
},1,3);


// Custom hook add address bar on mobile only
add_action('wp_head', 'add_address_bar_on_mobile'); 
function add_address_bar_on_mobile() {
    // check if the current view it's on mobile
    if(wp_is_mobile()){
        echo '<div class="mobile-address-bar">This Header Adress Bar On Mobile Only</div>'; 
    }
}