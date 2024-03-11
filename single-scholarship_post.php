<?php

/**
 * This is used for Scholarship Posts custom post type
 *
 * @package Avada
 */

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>

<?php get_header();

$featured_image_url = get_the_post_thumbnail_url(get_the_ID());

?>

<section class="scholarship-post-main">

    <div class="scholarship-post-breadcrumb">
        <a class="blog-breadcrumb" href="/"> Home </a> > <a class="blog-breadcrumb" href="/recent-scholarship-posts/"> Scholarship Recipients </a> >
        <a href="javascript:void(0)" class="blog-breadcrumb active-breadcrumb"> <?php echo get_the_title(); ?> Scholarship Journey </a>
    </div>

    <div class="scholarship-post-hero row">
        <div class="scholarship-post-hero-text col-md-8 col-sm-12">
            <h1> Hi, I'm <span> <?php echo get_the_title(); ?> </span> <br>
                This is the story of my <br><span>Scholarship Journey. </span> </h1>


            <div class="brief_intro_text">
                <?php echo get_field('brief_intro'); ?>
            </div>


        </div>
        <div class="scholarship-post-hero-image col-md-4 col-sm-12">

            <div class="image-container">
                <img src="<?php echo $featured_image_url; ?>" alt="Your Image">
            </div>
            <div class="image-container1">
            </div>

        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row the-journey">

        <h2> The <br> Journey</h2>
        <hr>

        <div class="clearfix"></div>

        <div class="the_journey_text">
            <?php echo wpautop(get_the_content()); ?>
        </div>

        <div class="clearfix"></div>

        <div class="scholarship_categories">


            <?php
            $taxonomy = 'scholarship_category'; // Replace with your custom taxonomy slug
            $terms = get_the_terms(get_the_ID(), $taxonomy);

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_link = get_term_link($term, $taxonomy);
            ?>
                    <a href="<?php echo esc_url($term_link); ?>" class="scholarship_post_category_link"><?php echo esc_html($term->name); ?></a>
            <?php
                }
            }
            ?>

        </div>
    </div>


</section>


<section class="cta_submit">
    <center>
        <p class="cta-heading">Want to <b>submit</b> your <br>
            <b>scholarship journey? </b>
        </p>
        <hr>
        <p class="cta-text">Contact us at</p>
        <a class="cta-contact-email" href="mailto:admin@globalscholarships.com"> admin@globalscholarships.com </a>
    </center>
</section>

<div class="clearfix"> </div>

<section class="scholarship-post-main read-more-scholarship-post">
    <h2> More Scholarship Recipients </h2>
    <div class="clearfix"> </div>
    <?php
    echo do_shortcode('[latest_scholarships]');
    ?>

    <?php
    if (comments_open() || get_comments_number()) {
        comments_template();
    }
    ?>


</section>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
