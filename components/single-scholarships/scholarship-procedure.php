<section id="scholarship-application-procedure" class="gs-scholarship-application-procedure">

    <h2><?php echo $scholarship_title; ?> Application Procedure</h2>

    <p>If you meet the eligibility criteria for the university and scholarship, you can move forward with the application process!</p>

    <div class="gs-scholarship-application-procedure-note">
        <p>
        <strong>Remember to apply for admission to the university first before applying for a scholarship.</strong> You can visit the official website found in <a href="<?php echo get_permalink($institution->ID); ?>#admissions"><?php echo $institution_name; ?> Admissions Section</a> to see the admissions application process.
        </p>
    </div>
    <div class="gs-scholarship-application-procedure-separate-application">

        <?php if($separate_application == "No") : ?>
            <p>
            For <?php echo $scholarship_title; ?>, you DO NOT need to apply separately. That is, once you’ve submitted your admission application, you are automatically considered for the scholarship, as long as you meet the eligibility criteria. 
            </p>
            <p>If you need more information regarding the scholarship application process, visit the official <a href="<?php echo $scholarship_page_link; ?>">scholarship page</a>.</p>
        <?php else : 
            ?>
            <?php if( NULL != get_field('additional_scholarship_requirements') && !empty(get_field('additional_scholarship_requirements'))) : ?>
        <h3><?php echo $scholarship_title; ?> Application Process</h3>
            <p>A separate scholarship application – in addition to the university admission – is needed for <?php echo $scholarship_title; ?>. You’ll have to collect these requirements:</p>
            <ul class="fa-ul">
                <?php foreach(get_field('additional_scholarship_requirements') as $requirement) : ?>
                <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><div class="requirement-item"><?php echo $requirement['requirements']; ?></div></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php if( NULL != get_field('application_procedure') && !empty(get_field('application_procedure'))) : ?>
            <p>Once you have those ready, follow these steps to submit your scholarship application and requirements:</p>
            <ol>
                <?php foreach(get_field('application_procedure') as $step) : ?>
                    <li><?php echo $step['steps']; ?></li>
                <?php endforeach; ?>
            </ol>
            <?php endif; ?>

            <p>If you need more information regarding the scholarship application process, visit the official <a href="<?php echo $scholarship_page_link; ?>">scholarship page</a>.</p>
        <?php endif; ?>
    </div>

    <div class="gs-scholarships-ad">
        <div class="gs-scholarship-ad-content">
            <h3>Still looking for Scholarships?</h3>
            
            <p>Are you still looking for scholarships to help pay for college? If so, you're not alone. Luckily, our Scholarship Filter is here to transform your chances of finding the perfect scholarships for college. Check it out and unlock unparalleled opportunities!</p>
        </div>
        <div class="gs-scholarship-ad-arrow">
            <a href="<?php echo site_url(); ?>/scholarship-search/">&rarr;</a>
        </div>
    
    </div>

</section>
