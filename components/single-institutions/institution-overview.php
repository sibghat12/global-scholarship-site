<div class="gs-institution-overview-box">

    <div class="gs-institution-overview-text">
        <h1>
            <?php echo $title .' '. date("Y").' - '.date('Y', strtotime('+1 year')); ?>
        </h1>
        <?php // Breadcrumbs ?>
        <?php require get_stylesheet_directory() . '/components/single-institutions/breadcrumbs.php'; ?>

        <?php // Institution Description ?>
        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-description.php'; ?>

    </div>
</div>