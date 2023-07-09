<div class="gs-scholarship-overview-box">
    <!-- <div class="gs-scholarship-overview-image">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/scholarship-image.png'; ?>" alt="Scholarship Image" srcset="">
    </div> -->
    <div class="gs-scholarship-overview-text">
        <h1>
            <?php echo $title; ?>
        </h1>
        <?php // Breadcrumbs ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/breadcrumbs.php'; ?>
        
        <?php // Scholarship Description ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-description.php'; ?>

        <?php // Institution Scholarships  ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/institution-scholarships.php'; ?>
    </div>
</div>