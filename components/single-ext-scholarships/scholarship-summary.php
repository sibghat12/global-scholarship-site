<div class="gs-scholarship-summary">
    <div class="gs-scholarship-summary-box">
        <h2>Scholarship Summary</h2>
        <div class="gs-scholarship-summary-list-items">
        <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-summary-list.php'; ?>

        </div>
    </div>
    <div class="gs-scholarship-summary-info-boxes">
        <?php if(!empty($scholarship_providers) && isset($scholarship_providers) ) : ?>
        <div class="gs-scholarship-summary-institute-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/institute-icon.png'); ?>" alt="">
            </div>
            <?php
            $scholarship_funded_by_first = $scholarship_providers_list[0];
            $words = explode(' ', $scholarship_funded_by_first);
            $scholarships_funded_five_words = implode(' ', array_slice($words, 0, 5));
            ?>
            <p class="gs-scholarship-summary-title"><?php echo $scholarships_funded_five_words; ?></p>
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
        <?php if($scholarship_deadlines || $scholarship_deadlines_country_institution) : ?>
        <div class="gs-scholarship-summary-separate-application-box gs-summary-box">
            <div class="gs-scholarship-summary-insitute-image">
                <img src="<?php echo site_url('wp-content/themes/Avada-Child-Theme/assets/images/Deadline.png'); ?>" alt="">
            </div>
            <p class="gs-scholarship-summary-title">
                <?php 
                    
                    // Find the first non-"Accept Application All Year" deadline
                    $first_non_year_round_deadline = '';
                    if(!$varied_deadlines) {
                        foreach ($scholarship_deadlines as $deadline) {
                            if ($deadline['accepts_application_all_year_round'] !== 'Yes') {
                                $first_non_year_round_deadline = $deadline['deadline'];
                                break;
                            }
                        }
    
                        // Display the appropriate deadline or "Accept Application All Year"
                        if (!empty($first_non_year_round_deadline)) {
                            echo strip_tags($first_non_year_round_deadline); // Output the text without HTML tags
                        } elseif (count($unique_acceptance) === 1 && reset($unique_acceptance) === 'Yes') {
                            echo 'Accept Application All Year';
                        } else {
                            echo 'No Deadlines!';
                        }
                    } else {
                        echo "Varied Deadlines";
                    }
                ?>
            </p>
        </div>
        <?php endif; ?>
    </div>

</div>