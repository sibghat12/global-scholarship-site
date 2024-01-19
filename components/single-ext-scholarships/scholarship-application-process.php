<section id="scholarship-application-procedure" class="gs-scholarship-application-process">

    <h2><?php echo $scholarship_title; ?> Application Process</h2>

    <p>In this section, we'll provide a clear general overview of requirements and steps to guide you through the application process for <?php echo $scholarship_title; ?>.</p>

    <div class="gs-ext-schoalrship-application-requirements">

        <h3><?php echo $scholarship_title; ?> Application Requirements:</h3>

        <p>To begin your application for <?php echo $scholarship_title; ?>, you'll need to prepare and submit the following documents:</p>
        <?php // Scholarship Application Steps ?>

        <?php if($application_steps) : ?>
            <ul class="fa-ul">
                <?php foreach($application_steps as $step) : ?>
                    <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><div class="step-item"><?php echo $step['steps']; ?></div></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="gs-ext-schoalrship-application-procedures">
        <h3><?php echo $scholarship_title; ?> Application Procedure:</h3>

        <p>To apply for <?php echo $scholarship_title; ?>, please follow these steps:</p>

        <?php // Scholarship Application procedures ?>

        <?php if($application_procedures) : ?>
        <ul>
            <?php foreach($application_procedures as $procedure) : ?>
                <li><?php echo $procedure['steps']; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

    </div>
   

    <div class="gs-scholarship-application-process-outro">
    <p>
    <b>Important Note</b>: The application procedures and required documents for <?php echo $scholarship_title; ?> may vary depending on your degree, program, nationality and other factors. For specific details regarding the requirements, kindly visit the <a href="<?php echo ($scholarship_application_procedure_link) ? $scholarship_application_procedure_link: $scholarship_page_link; ?>">official website of <?php echo $scholarship_title; ?></a>.
    </p>
    </div>
</section>
