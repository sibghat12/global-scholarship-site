<div class="gs-scholarship-summary">
    <div class="gs-scholarship-summary-box">
        <h1>Scholarship Summary</h1>
        <div class="gs-scholarship-summary-list-items">
        <?php require get_stylesheet_directory() . '/components/single-scholarships/scholarship-summary-list.php'; ?>

        </div>
    </div>
    <div class="gs-scholarship-summary-info-boxes">
        <?php if(!empty($institution_name) && isset($institution_name) ) : ?>
        <div class="gs-scholarship-summary-institute-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/institute-icon.png'); ?>" alt="">
            </div>
            <h2 class="gs-scholarship-summary-title"><?php echo $institution_name; ?></h2>
        </div>
        <?php endif; ?>
        <?php if($scholarship_amount > 0) : ?>
        <div class="gs-scholarship-summary-scholarship-amount-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/funding-icon.png'); ?>" alt="">
            </div>
            <h2 class="gs-scholarship-summary-title"><?php echo $scholarship_amount; ?></h2>
        </div>
        <?php endif; ?>

        <?php if( !empty($degrees_text) && isset($degrees_text) ) : ?>
        <div class="gs-scholarship-summary-degrees-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/degrees-icon.png'); ?>" alt="">
            </div>
            <h2 class="gs-scholarship-summary-title"><?php echo $degrees_text; ?></h2>
        </div>
        <?php endif; ?>

        <?php if( !empty($separate_application) && isset($separate_application) ) : ?>
        <div class="gs-scholarship-summary-separate-application-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/application-icon.png'); ?>" alt="">
            </div>
            <h2 class="gs-scholarship-summary-title">
                <?php if($separate_application == 'Yes') : ?>
                <?php echo 'Separate Application'; ?>
                <?php elseif( $separate_application == 'No' ) : ?>
                <?php echo 'No Separate Application'; ?>
                <?php endif; ?>
            </h2>
        </div>  
        <?php endif; ?>
    </div>

</div>