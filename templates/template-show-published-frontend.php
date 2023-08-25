<?php
/**
 * Template Name: Published Frontend
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
        'post_type' => 'institution',
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

    
    echo "<ul>";
    foreach ($ids as $id){ 
       $permalink = get_permalink($id);         
                ?>
                
                
                
        <li><a href="<?php echo $permalink ?>"><?php echo get_the_title($id) ?></a></li>
                
                
        
    <?php 
        
        
        wp_cache_delete( $id, 'posts' );
        wp_cache_delete( $id, 'post_meta' );        
    }
    echo "</ul>";
         
        
                
                
                
                ?>
    </div>
                

    
	<?php wp_reset_postdata(); ?>
    
    
</section>
            
<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
