<div class="gs-scholarship-overview-box">
    <div class="gs-scholarship-overview-image">
    <?php echo the_post_thumbnail(); ?>
    </div>
    <div class="gs-scholarship-overview-text">
        <h2>
            <?php echo $title; ?>
        </h2>
        <?php // Breadcrumbs ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/breadcrumbs.php'; ?>
        
        <?php // Scholarship Description ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-description.php'; ?>

        <?php // Institution Scholarships  ?>
        <?php require get_stylesheet_directory() . '/components/single-scholarships/institution-scholarships.php'; ?>
    </div>
</div>