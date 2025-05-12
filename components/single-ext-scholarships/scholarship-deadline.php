<section id="scholarship-deadline" class="gs-ext-scholarship-deadline">

    <h2>When to Apply for <?php echo $scholarship_title; ?> (Deadlines)</h2>

    <p>Now that you’re familiar with the application procedure, it’s time to know the application dates! Knowing the dates for <?php echo $scholarship_title; ?> will help you prepare early and it will also give you the time you need to put together a competitive application. 
    </p>

        <?php 
         //Scholarship Deadline(s)
        $deadline_text = '';

        if(!$varied_deadlines) :
            echo '<p>Here are the application deadlines for '. $scholarship_title .':</p>';
            if($scholarship_deadlines):
            echo "<ul>";
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
            echo "</ul>";
            endif;
            ?>
        <?php else : ?>
            <p>The application deadlines for <?php echo $scholarship_title; ?> vary. It’s important to review official guidelines on the official website or contact administrators for specific deadlines. Make sure to regularly check the <a href="<?php echo $scholarship_page_link; ?>" target="_blank"><?php echo $scholarship_title; ?> page</a> for the latest and most accurate information on application deadlines.</p>
            <?php
                if($scholarship_deadlines_country_institution) :
                    echo "<ul>";
                        foreach ($scholarship_deadlines_country_institution as $deadline) {
            
                            $deadline_date = strtotime($deadline['deadline']);
                            $formatted_deadline = date("F j, Y", $deadline_date);
                            $deadline_text = $formatted_deadline;
            
                            echo '<li><a href='.$deadline['link'].' target="_blank">' . $deadline['country_institution'] . ' Scholarship Application Deadline</a>: '. $deadline_text .'</li>';
                        }
                    
                    echo "</ul>";
                endif;
        ?>

        <?php 
        if($scholarship_deadlines_country_institution) : ?>
        <p>Please see <a href="<?php echo $scholarship_page_link; ?>" target="_blank">Official Scholarship Page</a> for complete details on the application dates.</p>

    <?php 
        endif;
    endif;
    ?>
</section>