<section id="scholarship-application-procedure" class="gs-scholarship-application-process">

    <h2><?php echo $scholarship_title; ?> Application Process</h2>

    <p>In this section, we will be discussing the requirements and step-by-step process on how to apply for <?php echo $scholarship_title; ?>:</p>
    <div class="gs-ext-schoalrship-application-requirements">

        <h3><?php echo $scholarship_title; ?> Application Requirements:</h3>

        <p>To start your application for <?php echo $scholarship_title; ?>, you need to submit the following documents and meet the following requirements:</p>
        <?php // Scholarship Application Steps ?>

        <?php if($application_steps) : ?>
        <ol>
            <?php foreach($application_steps as $step) : ?>
            <li><?php echo $step['steps']; ?></li>
            <?php endforeach; ?>
        </ol>
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
    <b>Important Note</b>: The application procedures and required documents for <?php echo $scholarship_title; ?> may vary depending on your degree, program, nationality and other factors. For specific details regarding the requirements, kindly visit the <a href="<?php echo $scholarship_application_procedure_link; ?>">official website of <?php echo $scholarship_title; ?></a>.
    </p>
    </div>
</section>
