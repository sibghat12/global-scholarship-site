<section id="scholarship-deadline" class="gs-ext-scholarship-deadline">

    <h2>When to Apply for <?php echo $scholarship_title; ?> (Deadlines)</h2>

    <p>Now that you’re familiar with the application procedure, it’s time to know the application dates! Knowing the dates for <?php echo $scholarship_title; ?> will help you prepare early and it will also give you the time you need to put together a competitive application. 
    </p>
    <p>Here are the application deadlines for <?php echo $scholarship_title; ?></p>

    <ul>
        <?php 
         //Scholarship Deadline(s)
        $deadline_text = '';

        if(!$varied_deadlines) :
            foreach ($scholarship_deadlines as $deadline) {
                $deadline_date = strtotime($deadline['deadline']);
                $formatted_deadline = date("F j, Y", $deadline_date);


                if ($deadline['accepts_application_all_year_round'] === 'Yes') {
                    $deadline_text = 'Accept Application All Year';
                }
                else {
                    $deadline_text = $formatted_deadline;
                }
                echo '<li>' . $deadline['degree'] . ' Scholarship Application Deadline: '. $deadline_text .'</li>';

            }
            ?>
        <?php else :
            foreach ($scholarship_deadlines_country_institution as $deadline) {

                $deadline_date = strtotime($deadline['deadline']);
                $formatted_deadline = date("F j, Y", $deadline_date);
                $deadline_text = $formatted_deadline;

                echo '<li>' . $deadline['country_institution'] . ' Scholarship Application Deadline: '. $deadline_text .'</li>';
            }
            ?>
    <?php endif;
    ?>
    </ul>
    <p>Please see <a href="<?php echo $scholarship_page_link; ?>" target="_blank">Official Scholarship Page</a> for complete details on the application dates.</p>
</section>