<?php
/**
 * Template Name: Landing Page
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header();  ?>



<div class="container mt-4 custom-gutter">

    <div class="landing-breadcrumb">
        <a href="" class="item" >Home</a> >
        <a href="" class="item">Guides</a>
    </div>

    <div class="row mt-4" style="margin-top:0px;">

        <?php
        // Check if there are any rows in the "topic" repeater
        if (have_rows('topic')) :

            // Loop through each row in "topic" repeater
            while (have_rows('topic')) : the_row();

                // Fetch the topic_title
                $main_title = get_sub_field('topic_title'); ?>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <div class="clearfix"></div>
                <h2 class="landing-page-title">
                    <span><i  class="fa fa-circle"></i></span>
                    <?php echo $main_title; ?>
                </h2>

                <?php
                // Check if there are any rows in the "posts" repeater of the current topic
                if (have_rows('posts')) :

                    // Loop through each row in "posts" repeater of the current topic
                    while (have_rows('posts')) : the_row();

                        $post_object = get_sub_field('post_type');
                        $post_image = get_sub_field('image');

                        if ($post_object) :
                            $post_title = $post_object->post_title;
                            $post_link = get_permalink($post_object->ID);
                        endif; ?>

                        <div class="col-md-4">
                            <a href="<?php echo $post_link; ?>" class="d-block position-relative card-link">
                                <img src="<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>" class="img-fluid">
                                <span class="position-absolute bottom-0 start-0 p-2"><?php echo $post_title; ?></span>
                            </a>
                        </div>

                    <?php endwhile; // End of "posts" repeater loop
                endif; // End of "posts" repeater check

            endwhile; // End of "topic" repeater loop
        endif; // End of "topic" repeater check
        ?>
    </div>
</div>



<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */