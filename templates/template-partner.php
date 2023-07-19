<?php
/**
 * Template Name: Partner With Us
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

    
<section id="content" style="<?php echo esc_attr( apply_filters( 'awb_content_tag_style', '' ) ); ?>">
	<?php get_template_part('template-parts/content', 'partner'); ?>
</section>


<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

