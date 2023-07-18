<?php
/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<!DOCTYPE html>
<html class="<?php avada_the_html_class(); ?>" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php Avada()->head->the_viewport(); ?>

	<?php wp_head(); ?>

	<?php
	/**
	 * The setting below is not sanitized.
	 * In order to be able to take advantage of this,
	 * a user would have to gain access to the database
	 * in which case this is the least of your worries.
	 */
	echo apply_filters( 'avada_space_head', Avada()->settings->get( 'space_head' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	?>
	<style type="">
    .awb-menu_row .menu-text {
    text-align: left !important; 
    }
    
    @media screen and (max-width: 600px) {
    .awb-menu__sub-ul span {
   text-align:center !important;
     }
     
    }

    .awb-menu__mega-wrap {
    	display: none;
    }

    
    
   
   
	</style>
</head>

<?php
$object_id      = get_queried_object_id();
$c_page_id      = Avada()->fusion_library->get_page_id();
$wrapper_class  = 'fusion-wrapper';
$wrapper_class .= ( is_page_template( 'blank.php' ) ) ? ' wrapper_blank' : '';
?>
<body <?php body_class(); ?> <?php fusion_element_attributes( 'body' ); ?>>

 

 <?php
$post_type = get_post_type();


if ($post_type === 'post' || $post_type === 'institution') {
	    ?>

<script data-cfasync="false" type="text/javascript">
  window.snigelPubConf = {
    "adengine": {
      "activeAdUnits": ["incontent_1"]
    }
  }
</script>
<script async data-cfasync="false" src="https://cdn.snigelweb.com/adengine/globalscholarships.com/loader.js" type="text/javascript"></script>

<?php
} else {
    ?>

<script data-cfasync="false" type="text/javascript">
window.snigelPubConf = {
  "adengine": {
    "activeAdUnits": ["interstitial"]
  }
}
</script>
<script async data-cfasync="false" src="https://cdn.snigelweb.com/adengine/globalscholarships.com/loader.js" type="text/javascript"></script>

<?php
}
?>


  


	<?php do_action( 'avada_before_body_content' ); ?>
		<?php do_action('wp_body_open'); ?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'Avada' ); ?></a>

	<div id="boxed-wrapper">
		<div class="fusion-sides-frame"></div>
		<div id="wrapper" class="<?php echo esc_attr( $wrapper_class ); ?>">
			<div id="home" style="position:relative;top:-1px;"></div>
			<?php if ( has_action( 'avada_render_header' ) ) : ?>
				<?php do_action( 'avada_render_header' ); ?>
			<?php else : ?>

				<?php avada_header_template( 'below', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) ); ?>
				<?php if ( 'left' === fusion_get_option( 'header_position' ) || 'right' === fusion_get_option( 'header_position' ) ) : ?>
					<?php avada_side_header(); ?>
				<?php endif; ?>

				<?php avada_sliders_container(); ?>
                  
                  


				<?php avada_header_template( 'above', ( is_archive() || Avada_Helper::bbp_is_topic_tag() ) && ! ( class_exists( 'WooCommerce' ) && is_shop() ) );  ?>

			<?php endif; ?>

<?php  if ( is_singular( 'scholarships' ) ||  is_singular('institution') ) {  } else { ?>
			<?php avada_current_page_title_bar( $c_page_id ); ?>
    <?php } ?>
			<?php
			$row_css    = '';
			$main_class = '';

			if ( apply_filters( 'fusion_is_hundred_percent_template', false, $c_page_id ) ) {
				$row_css    = 'max-width:100%;';
				$main_class = 'width-100';
			}

			if ( fusion_get_option( 'content_bg_full' ) && 'no' !== fusion_get_option( 'content_bg_full' ) ) {
				$main_class .= ' full-bg';
			}
			do_action( 'avada_before_main_container' );
			?>

<?php 
   
    if ( is_singular( 'scholarships' ) ||  is_singular('institution') ) {

   } else {  ?>


			<main id="main" class="clearfix <?php echo esc_attr($main_class); ?>">
	<div class="fusion-row" style="<?php echo esc_attr($row_css); ?>">
<?php } ?>