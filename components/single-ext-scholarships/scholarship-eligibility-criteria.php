<?php // Eligibility Criteria Section ?>
<section id="scholarship-eligibility-criteria" class="gs-scholarship-eligibility-criteria">
    
    <div class="gs-scholarship-eligibility-criteria-intro">
        <h2><?php echo $scholarship_title; ?> Eligibility Criteria</h2>
        <p>To be eligible for <?php echo $scholarship_title; ?>, you need to meet the following criteria:</p>
    </div>
    
    <div class="gs-scholarship-eligibility-criteria-scholarship">

            <div class="gs-scholarship-eligibility-criteria-scholarship-content">
            <?php if($eligibility_criteria) : ?>

            <?php
                if(count($eligibility_criteria) >= 1) :
                    ?>
                       
                        <ul>
                            <?php 
                            foreach($eligibility_criteria as $criteria) : ?>
                                <li><b><?php echo $criteria['criteria']; ?></b></li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                <?php  endif; ?>
            <?php  endif; ?>
            <p>Please refer to the <a href="<?php echo $creteria_page_link; ?>">Eligibility Page</a> for detailed information on the eligibility requirements for the <?php echo $scholarship_title; ?>.</p>
            </div>
        </div>

        
        <?php // GS External Scholarship Disclaimer (Wysiwig) ?>
           <?php if(isset($scholarship_disclaimer_text) && !empty($scholarship_disclaimer_text)) : ?>
                <?php require get_stylesheet_directory() . '/components/single-ext-scholarships/scholarship-disclaimer.php'; ?>
            <?php endif ?>

</section>