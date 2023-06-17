<?php

function prepare_cities_institutions (){
    
    $file = fopen('cities_institutions.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        //$line is an array of the csv elements
        
        $institution_title = $line[0];
        $city_title = $line[1];
        $institution = get_page_by_title($institution_title , OBJECT, "institution")->ID;
        $city = get_page_by_title($city_title, OBJECT, "city")->ID;
        
        $field_key = "cities";
        if($institution){
            update_field($field_key, $city, $institution);
        }

        wp_cache_delete( $id, 'posts' );
        wp_cache_delete( $id, 'post_meta' );
        
    }
    fclose($file);
}

function get_all_institutions($post_status="publish"){
    $args = array(
        'post_type' => 'institution',
        'post_status' => $post_status,        
        'posts_per_page' => -1,
        'orderby'   => 'title',
        'order'     => 'ASC',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false, 
        'update_post_term_cache' => false,   
        'cache_results'          => false,
        'fields' => 'ids',      
    );
    
    $the_query = new WP_Query($args);
    
    $my_posts = $the_query->get_posts();
    
    return $my_posts;

}

function get_all_scholarships($post_status="publish"){
    $args = array(
        'post_type' => 'scholarships',
        'post_status' => $post_status,        
        'posts_per_page' => -1,
        'orderby'   => 'title',
        'order'     => 'ASC',
        'no_found_rows' => true, 
        'update_post_meta_cache' => false, 
        'update_post_term_cache' => false,   
        'cache_results'          => false,
        'fields' => 'ids',      
    );
    
    $the_query = new WP_Query($args);
    
    $my_posts = $the_query->get_posts();
    
    return $my_posts;

}



?>