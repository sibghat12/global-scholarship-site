<?php
/**
 * Template Name: Show Published Scholarships
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); 

//include get_stylesheet_directory() . "/functions/cities_functions.php";

?>  



<section id="content" class="small-text">
			<div class="post-content">

      <?php 

 $args = array(
        'post_type' => 'scholarships',
        'post_status' => 'publish',        
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
    
    $ids = $the_query->get_posts();
  
 

//$ids = get_all_scholarships("Published");



// Create an associative array to group scholarships by university
$universities = array();

foreach ($ids as $id) { 
    $university_id = get_post_meta($id, 'scholarship_institution', true); // This will give you the university's post ID
    $university_permalink = get_permalink($university_id);
    $university_name = get_the_title($university_id); // This will give you the university's title

    if (!isset($universities[$university_name])) {
        $universities[$university_name] = array('permalink' => $university_permalink, 'scholarships' => array());
    }
    $universities[$university_name]['scholarships'][] = $id;
}

// Iterate through each university and its scholarships
foreach ($universities as $university => $university_data) {
    echo "<h2><a href='" . $university_data['permalink'] . "'>" . $university . "</a></h2>";
    echo '<ul style="padding-left:50px !important;">';

    foreach ($university_data['scholarships'] as $id) {
        $permalink = get_site_url() . "/wp-admin/post.php?post=" . $id . "&action=edit";
        echo '<li><a href="' . $permalink . '">' . get_the_title($id) . '</a></li>';
        wp_cache_delete($id, 'posts');
        wp_cache_delete($id, 'post_meta');
    }
    echo '</ul>';
}
wp_reset_postdata();
?>

    
    
</section>
            
<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
