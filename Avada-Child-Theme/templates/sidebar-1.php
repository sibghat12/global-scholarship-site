<?php
/**
 * Sidebar-1 template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       https://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$sticky_sidebar = in_array( 'fusion-sticky-sidebar', apply_filters( 'fusion_sidebar_1_class', [] ), true );
?>
<aside id="sidebar" class="<?php echo esc_attr( $sidebar_classes ); ?>" style="<?php echo esc_attr( apply_filters( 'awb_aside_1_tag_style', '' ) ); ?>" data="<?php echo esc_attr( apply_filters( 'awb_aside_1_tag_data', '' ) ); ?>">
	<?php if ( $sticky_sidebar ) : ?>
		<div class="fusion-sidebar-inner-content">
	<?php endif; ?>
		<?php if ( ! Avada()->template->has_sidebar() || 'left' === Avada()->layout->sidebars['position'] || ( 'right' === Avada()->layout->sidebars['position'] && ! Avada()->template->double_sidebars() ) ) : ?>
			<?php echo avada_display_sidenav( Avada()->fusion_library->get_page_id() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php if ( class_exists( 'Tribe__Events__Main' ) && is_singular( 'tribe_events' ) && 'sidebar' === Avada()->settings->get( 'ec_meta_layout' ) ) : ?>
				<?php do_action( 'tribe_events_single_event_before_the_meta' ); ?>
				<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( isset( Avada()->layout->sidebars['sidebar_1'] ) && Avada()->layout->sidebars['sidebar_1'] ) : ?>
			<?php generated_dynamic_sidebar( Avada()->layout->sidebars['sidebar_1'] ); ?>
		<?php endif; ?>
	<?php if ( $sticky_sidebar ) : ?>
		</div>
	<?php endif; ?>
</aside>
<div class="white-sidebar">
<aside id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> <?php Avada()->layout->add_style( 'sidebar_1_style' ); ?> <?php Avada()->layout->add_data( 'sidebar_1_data' ); ?>>
    
    
    
<!-- Ezoic - sidebar_floating_1 - sidebar_floating_1 -->
<div id="ezoic-pub-ad-placeholder-834"> </div>
<!-- End Ezoic - sidebar_floating_1 - sidebar_floating_1 -->
<!-- adngin-sidebar_3-0  -->
<div id="adngin-sidebar_3-0" style="text-align: center;"></div>
</aside>
<div>

