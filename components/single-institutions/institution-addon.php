<div class="gs-institution-addon-box">
    <div class="gs-institution-addon-text">
        <?php if($number_of_scholarships >= 3 && $number_of_scholarships <= 5 ): ?>
            <p>Got questions about scholarships? Check out our <a href="<?php site_url(); ?>/scholarship-admissions-faqs/">Scholarship Admissions: FAQs for International Students Applying for Scholarships Abroad Article!</a></p>
        <?php elseif( $number_of_scholarships > 5): ?>
            <p>Need help in writing your scholarship resume? Check out this article and <a href="<?php site_url(); ?>/write-scholarship-resume/">learn how to write a resume that will impress scholarship committees!</a></p>
        <?php endif ?>
    </div>
</div>