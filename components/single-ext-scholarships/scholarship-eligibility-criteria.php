<?php // Eligibility Criteria Section ?>
<section id="scholarship-eligibility-criteria" class="gs-scholarship-eligibility-criteria">
    
    <div class="gs-scholarship-eligibility-criteria-intro">
        <h2><?php echo $scholarship_title; ?> Eligibility Criteria</h2>
        <p>To be eligible for <?php echo $scholarship_title; ?>, you need to meet the following criteria:</p>

       
        <p class="criteria-note">These criteria vary per institution and scholarship so be sure to take note of these before preparing your application.</p>

    </div>
    
    <div class="gs-scholarship-eligibility-criteria-institution">
        
        <h3><?php echo $institution_name; ?> Eligibility Criteria</h3>
    
        <div class="gs-scholarship-eligibility-criteria-institution-content">
            <p>Before applying for <?php echo $scholarship_title; ?> for international students, you need to apply for admissions at the <?php echo $institution_name; ?> first. Find the <?php echo $institution_name; ?>’s admission eligibility criteria <a href="<?php echo get_permalink($institution->ID); ?>#admissions">here</a>.</p>
            
        </div>
    </div>
    
    <div class="gs-scholarship-eligibility-criteria-scholarship">
        <h3><?php echo $scholarship_title; ?> Specific Eligibility Criteria</h3>
        
            <div class="gs-scholarship-eligibility-criteria-scholarship-content">
            <?php if($eligibility_criteria) : ?>

                <?php
                
                    if(count($eligibility_criteria) >= 2) :
                    ?>
                        <p>
                        Did you meet the admissions criteria? If yes, you’re now ready to apply for a scholarship. Here are the additional criteria or requirements you must meet to apply for <?php echo $scholarship_title; ?>: </p>

                        <ul>
                            <?php 
                            foreach($eligibility_criteria as $criteria) : ?>
                            <li><b><?php echo $criteria['criteria']; ?></b></li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    <?php
                    elseif(count($eligibility_criteria) == 1) : ?>
                        <p>
                        Did you meet the admissions criteria? If yes, you’re now ready to apply for a scholarship. <b>Applicants must be <?php echo $eligibility_criteria[0]['criteria'] ?>.</b>
                        </p>
                    <?php endif; ?>
            
                
                <?php else : ?>
                    <p>There are no specific eligibility criteria for this scholarship. <b>You just need to be an international <?php echo ( str_contains($degrees_text, 'PhD') ) ? str_replace('PhD', 'Ph.D.', $degrees_text) : $degrees_text; ?> student or applicant of <?php echo $institution_name; ?>.</b></p>
                <?php endif; ?>
            </div>
        </div>

        <p>Make sure to check out the <a href="<?php echo get_permalink($institution->ID); ?>#admissions"><?php echo $institution_name; ?> admissions pages</a> and the <a href="<?php echo $scholarship_page_link; ?>"><?php echo $scholarship_title; ?> pages</a> for more information!</p>
</section>