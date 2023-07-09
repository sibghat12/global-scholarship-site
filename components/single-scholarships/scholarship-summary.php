<div class="gs-scholarship-summary">
    <div class="gs-scholarship-summary-box">
        <h2>Scholarship Summary</h2>
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
            <p class="gs-scholarship-summary-title"><?php echo $institution_name; ?></p>
        </div>
        <?php endif; ?>
        <div class="gs-scholarship-summary-scholarship-amount-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/funding-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title"><?php echo $scholarship_type; ?></p>
        </div>

        <?php if( !empty($degrees_text) && isset($degrees_text) ) : ?>
        <div class="gs-scholarship-summary-degrees-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/degrees-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title"><?php echo $degrees_text; ?></p>
        </div>
        <?php endif; ?>

        <?php if( !empty($separate_application) && isset($separate_application) ) : ?>
        <div class="gs-scholarship-summary-separate-application-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/application-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title">
                <?php if($separate_application == 'Yes') : ?>
                <?php echo 'Separate Application'; ?>
                <?php elseif( $separate_application == 'No' ) : ?>
                <?php echo 'No Separate Application'; ?>
                <?php endif; ?>
                </p>
        </div>  
        <?php endif; ?>
    </div>

</div>