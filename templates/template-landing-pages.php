<?php
/**
 * Template Name: Landing Page
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<?php get_header();  ?>

<div class="container mt-4 custom-gutter">

    <div class="landing-breadcrumb">
        <a href="" class="item">Home</a> >
        <a href="" class="item">Guides</a>
    </div>

    <div class="row mt-4" style="margin-top:0px;">

        <?php
        // Check if there are any rows in the "topic" repeater
        if (have_rows('topic')) :

            // Loop through each row in "topic" repeater
            $topicCounter = 0;
            while (have_rows('topic')) : the_row();

                $topicCounter++;
                $main_title = get_sub_field('topic_title');
                $counter = 0; // Initialize a counter for the posts within each topic
                ?>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <div class="clearfix"></div>
                <h2 class="landing-page-title">
                    <?php echo $main_title; ?>
                </h2>

                <?php
                $buttonCounter = 0;
                if (have_rows('posts')) :

                    while (have_rows('posts')) : the_row();

                        $buttonCounter++;

                        $post_object = get_sub_field('post_type');
                        $post_image = get_sub_field('image');

                        if ($post_object) :
                            $post_title = $post_object->post_title;
                            $post_link = get_permalink($post_object->ID);
                        endif;

                        $counter++;

                        // Display only the first 9 posts, and hide the rest initially
                        if ($counter <= 9) { ?>

                            <div class="col-md-4">
                                <a href="<?php echo $post_link; ?>" class="d-block position-relative card-link">
                                    <img src="<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>" class="img-fluid">
                                    <span class="position-absolute bottom-0 start-0 p-2"><?php echo $post_title; ?></span>
                                </a>
                            </div>

                        <?php } else { ?>

                            <div class="col-md-4 more-posts-<?php echo $topicCounter; ?> more-posts" style="display: none;">
                                <a href="<?php echo $post_link; ?>" class="d-block position-relative card-link">
                                    <img src="<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>" class="img-fluid">
                                    <span class="position-absolute bottom-0 start-0 p-2"><?php echo $post_title; ?></span>
                                </a>
                            </div>

                        <?php }

                    endwhile;

                endif;

                // Add a "More" button to show hidden posts
                if ($counter > 9) { ?>

                    <button class="btn btn-primary mt-3 more-button load-more-topics" data-topic="<?php echo $topicCounter; ?>">Load More</button>

                <?php }

            endwhile;

        endif;
        ?>
    </div>
</div>

<script>


    document.addEventListener('DOMContentLoaded', function () {
        let moreButtons = document.querySelectorAll('.more-button');
        moreButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                let topicNum = button.getAttribute('data-topic');
                let morePosts = document.querySelectorAll('.more-posts-' + topicNum + ':not([style*="display: block"])');
                let postCounter = 0;
                morePosts.forEach(function (post) {
                    if (postCounter < 9) {
                        post.style.display = 'block';
                        postCounter++;
                        console.log(postCounter);
                    }
                });

                // Check if there are still hidden posts
                let hiddenPosts = document.querySelectorAll('.more-posts-' + topicNum + ':not([style*="display: block"])');
                if (hiddenPosts.length === 0) {
                    button.style.display = 'none';
                }
            });
        });
    });
</script>



<?php do_action('avada_after_content'); ?>
<?php get_footer(); ?>
