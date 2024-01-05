<div class="gs-scholarship-summary">
    <div class="gs-scholarship-summary-box">
        <h2>Scholarship Summary</h2>
        <div class="gs-scholarship-summary-list-items">
        <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-summary-list.php'; ?>

        </div>
    </div>
    <div class="gs-scholarship-summary-info-boxes">
        <?php if(!empty($scholarship_funded_by) && isset($scholarship_funded_by) ) : ?>
        <div class="gs-scholarship-summary-institute-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/institute-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title"><?php echo $scholarship_funded_by; ?></p>
        </div>
        <?php endif; ?>
        <div class="gs-scholarship-summary-scholarship-amount-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/funding-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title"><?php echo $scholarship_category; ?></p>
        </div>

        <?php if( !empty($degrees_text) && isset($degrees_text) ) : ?>
        <div class="gs-scholarship-summary-degrees-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/degrees-icon.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title"><?php echo $degrees_text; ?></p>
        </div>
        <?php endif; ?>

        <?php if( !empty($deadline_text) && isset($deadline_text) ) : ?>
        <div class="gs-scholarship-summary-separate-application-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/Deadline.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title">
                <?php echo $deadline_text; ?>
            </p>
        </div>  
        <?php endif; ?>
    </div>

</div>