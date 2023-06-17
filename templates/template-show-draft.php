<?php
/**
 * Template Name: Show Drafts
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

include get_stylesheet_directory() . "/functions/cities_functions.php";

?>  



<section id="content" class="small-text">
			<div class="post-content">

                
   <?php 
    $ids = get_all_institutions("draft");
    echo "<ul>";
    foreach ($ids as $id){ 
       $permalink = get_site_url() . "/wp-admin/post.php?post=" . $id .  "&action=edit";         
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
