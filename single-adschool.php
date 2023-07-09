<?php
/**
 * This is used for adschool custom post type
 *
 * @package Avada
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
    
}


?>

<?php get_header(); ?>

<div id="primary" class="content-single content-area">
<main id="main" class="site-main" role="main">
    
<?php
while ( have_posts() ) : the_post();
    
    
    get_template_part( 'template-parts/content', 'adschool' );



endwhile; // End of the loop.
?>

    
    
         

</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>