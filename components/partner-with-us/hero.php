<section class="gs-partner-hero-section content-section-container">
       
    <!-- Hero Section text -->
    <div class="gs-partner-hero-section-content">
        <div class="gs-partner-hero-section-intro-title">
            <?php echo $hero_section_title; ?>
        </div>
        <div class="gs-partner-hero-section-intro-heading">
            <?php echo $hero_section_heading; ?>
        </div>
        <div class="gs-partner-hero-section-intro-text">
            <?php echo $hero_section_text; ?>
        </div>
        <div class="gs-partner-hero-section-button-cta">
            <a href="<?php echo $hero_section_button; ?>"><?php echo $hero_section_button_title ?></a>
        </div>
    </div>
    <!-- End Hero Section Text -->

        <!-- Hero Section Image -->
        <div class="gs-partner-hero-section-image">
        <?php echo wp_get_attachment_image( $hero_section_image_id, 'full' ); ?>
    </div>
    <!-- End Hero Section Image -->

</section>