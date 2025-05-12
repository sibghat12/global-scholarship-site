<?php
/**
* This is used for Single Scholarship custom post type
*
* @package Avada
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
   exit( 'Direct script access denied.' );
   
}

?>
<?php get_header(); ?>
<?php while ( have_posts() ) : ?>
       <?php the_post(); 

       // template content goes here
       get_template_part('template-parts/content', 'institutions');


?>



<?php endwhile; ?>
<?php wp_reset_postdata(); ?>


<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>