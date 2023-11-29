<?php

    // Scholarship Title from Post Title
    $scholarship_title = get_the_title(); 
    //Get Scholarship Custom Fields + Post Meta.

    // Scholarship Overview Wyswig
    $scholarship_overview_text = get_field('scholarship_overview');

    // Scholarship Disclaimer Wyswig
    $scholarship_disclaimer_text = get_field('disclaimer');

?>
    
<main id="main">
    <div class="fusion-row">

    <section id="content" style="<?php esc_attr_e(apply_filters('awb_content_tag_style', '')); ?>">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        
        <div class="post-content">
            
            <?php // GS Scholarship Overview Box ?>
            <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-overview.php'; ?>




            <?php 
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>

        </div>
        <?php // GS Scholarships Newsletter ?>
            <?php require get_stylesheet_directory() . '/components/single-scholarships/newsletter.php'; ?>

    </div>
    </section>

    </div>
</main>