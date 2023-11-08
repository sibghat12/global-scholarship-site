<section id="scholarship-application-procedure" class="gs-scholarship-application-procedure">

    <h2><?php echo $scholarship_title; ?> Application Procedure</h2>

    <p>If you meet the eligibility criteria for <?php echo $institution_name ?> and <?php echo $scholarship_title; ?>, you can move forward with the application process!</p>

    <div class="gs-scholarship-application-procedure-note">
        <p>
        <strong>Remember to apply for admission to <?php echo $institution_name ?> first before applying for <?php echo $scholarship_title; ?>.</strong> You can visit the official website found in <a href="<?php echo get_permalink($institution->ID); ?>#admissions"><?php echo $institution_name; ?> Admissions Section</a> to see the admissions application process.
        </p>
    </div>
    <div class="gs-scholarship-application-procedure-separate-application">

    <?php if($separate_application == "No") : ?>

        <p><b>There is no separate application needed for <?php echo $scholarship_title; ?>.</b> Just apply for admission to <b><?php echo $institution_name; ?></b>, and you'll automatically be considered for this offer if you meet the criteria.</p>
    
    <?php elseif($separate_application == "Yes") : ?>

        <?php if( ( NULL != get_field('additional_scholarship_requirements') &&  !empty( get_field('additional_scholarship_requirements')) ) && (NULL != get_field('application_procedure') && !empty(get_field('application_procedure'))) ) : 
                ?>

                <h3><?php echo $scholarship_title; ?> Application Process</h3>
                <p>A separate scholarship application – in addition to the university admission – is needed for <?php echo $scholarship_title; ?>. You’ll have to collect these requirements:</p>
                <ul class="fa-ul">
                    <?php foreach(get_field('additional_scholarship_requirements') as $requirement) : ?>
                    <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><b><div class="requirement-item"><?php echo $requirement['requirements']; ?></div></b></li>
                    <?php endforeach; ?>
                </ul>
                <p>Once you have those ready, follow these steps to submit your scholarship application and requirements:</p>
                <ol>
                    <?php foreach(get_field('application_procedure') as $step) : ?>
                        <li><b><?php echo $step['steps']; ?></b></li>
                    <?php endforeach; ?>
                </ol>
                
                <p>For more information, please see the <a href=" <?php echo ($scholarship_application_procedure_link) ? $scholarship_application_procedure_link : $scholarship_page_link; ?>"><?php echo $scholarship_title; ?> Scholarship Application Procedure Page </a>.</p>
            <?php elseif( ( NULL == get_field('additional_scholarship_requirements') &&  empty( get_field('additional_scholarship_requirements')) ) && (NULL == get_field('application_procedure') && empty(get_field('application_procedure'))) ) : ?>

                <p>A separate scholarship application - in addition to <?php echo $institution_name; ?> admission - is needed for <b><a href="<?php echo $scholarship_page_link; ?>"><?php echo $scholarship_title ?></a></b>, it's essential to know the application requirements and process. Make sure to take note of the important details before you apply!</p>

            <?php elseif ( ( NULL != get_field('additional_scholarship_requirements') &&  !empty( get_field('additional_scholarship_requirements')) ) && (NULL == get_field('application_procedure') && empty(get_field('application_procedure'))) ) : ?>
                <p>A separate scholarship application – in addition to <?php echo $institution_name; ?>  admission – is needed for <?php echo $scholarship_title; ?>. You’ll have to collect these requirements:</p>
                <ul class="fa-ul">
                    <?php foreach(get_field('additional_scholarship_requirements') as $requirement) : ?>
                    <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><b><div class="requirement-item"><?php echo $requirement['requirements']; ?></div></b></li>
                    <?php endforeach; ?>
                </ul>

                <p>For more information, please see the <a href=" <?php echo ($scholarship_application_procedure_link) ? $scholarship_application_procedure_link : $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Scholarship Application Procedure Page </a>.</p>
                <?php elseif ( ( NULL == get_field('additional_scholarship_requirements') &&  empty( get_field('additional_scholarship_requirements')) ) && (NULL != get_field('application_procedure') && !empty(get_field('application_procedure'))) ) : ?>
                    <p>A separate scholarship application is needed for this offer. To apply for <?php echo $scholarship_title; ?>, please follow these steps:</p>
                <ol>
                    <?php foreach(get_field('application_procedure') as $step) : ?>
                        <li><b><?php echo $step['steps']; ?></b></li>
                    <?php endforeach; ?>
                </ol>
                <p>For more information, please see the <a href=" <?php echo ($scholarship_application_procedure_link) ? $scholarship_application_procedure_link : $scholarship_page_link; ?>"> <?php echo $scholarship_title; ?> Scholarship Application Procedure Page </a>. </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- <aside class="gs-scholarships-ad">
        <div class="gs-scholarship-ad-image">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/Looking-For-Scholarships-image.png'; ?>" alt="Scholarship Image" srcset="">
        </div>
        <div class="gs-scholarship-ad-content-container">
            <div class="gs-scholarship-ad-content">
                <h3>Still looking for Scholarships?</h3>
                
                <p>Are you still looking for scholarships to help pay for college? If so, you're not alone. Luckily, our Scholarship Filter is here to transform your chances of finding the perfect scholarships for college. Check it out and unlock unparalleled opportunities!</p>
            </div>
            <div class="gs-scholarship-ad-arrow">
                <a href="<?php echo site_url(); ?>/scholarship-search/">&rarr;</a>
            </div>
        </div>
    </aside> -->

    <!-- Replace Still looking for Scholarships with Explore Courses from institutions -->
    <?php require get_stylesheet_directory() . '/components/single-institutions/explore-courses.php'; ?>


</section>
