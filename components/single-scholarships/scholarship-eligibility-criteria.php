<?php // Eligibility Criteria Section ?>
<section id="scholarship-eligibility-criteria" class="gs-scholarship-eligibility-criteria">
    
    <div class="gs-scholarship-eligibility-criteria-intro">
        <h2><?php echo  $scholarship_title; ?> Eligibility Criteria</h2>
        <p>
        To get a scholarship for international students, these are the two types of eligibility criteria you must meet:
        </p>

        <ol>
            <li>University Eligibility Criteria - the requirements you need to meet to be admitted to the university</li>
            <li>Scholarship Specific Eligibility Criteria - the requirements you need to meet to be considered for the scholarship</li>
        </ol>

        <p class="criteria-note">These criteria vary per institution and scholarship so be sure to take note of these before preparing your application.</p>

    </div>
    
    <div class="gs-scholarship-eligibility-criteria-institution">
        
        <h3><?php echo $institution_name; ?> Eligibility Criteria</h3>
    
        <div class="gs-scholarship-eligibility-criteria-institution-content">
            <p>Before applying for scholarships for international students, you need to apply for admissions at the university first. Find the <?php echo $institution_name; ?>’s admission eligibility criteria <a href="<?php echo get_permalink($institution->ID); ?>#admissions">here</a>.</p>
            
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
                            <li><?php echo $criteria['criteria']; ?></li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    <?php
                    elseif(count($eligibility_criteria) == 1) : ?>
                        <p>
                        Did you meet the admissions criteria? If yes, you’re now ready to apply for a scholarship. Applicants must be <?php echo $eligibility_criteria[0]['criteria'] ?>.
                        </p>
                    <?php endif; ?>
            
                
                <?php else : ?>
                    <p>There are no specific eligibility criteria for this scholarship. You just need to be an international <?php echo $degrees_text; ?> student or applicant of <?php echo $institution_name; ?>.</p>
                <?php endif; ?>
            </div>
        </div>
</section>