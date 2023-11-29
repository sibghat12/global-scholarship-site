<div class="gs-scholarship-overview-box">
    <!-- <div class="gs-scholarship-overview-image">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/scholarship-image.png'; ?>" alt="Scholarship Image" srcset="">
    </div> -->
    <div class="gs-scholarship-overview-text">
        <h1>
            <?php echo $scholarship_title .' '. date("Y").' - '.date('Y', strtotime('+1 year')); ?>
        </h1>

        
        <?php // Scholarship Description ?>
        <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-description.php'; ?>

    </div>
</div>