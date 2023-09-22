<?php if (isset($admission_deadlines) && !empty($admission_deadlines)) :
?>
    <div id="institution-deadline" class="gs-institution-deadlines">
        <h2 class="gs-institution-deadlines-title">
            <?php echo $institution_title;  ?> Application Deadlines
        </h2>

        <div class="gs-institution-deadlines-container">
            <div class="gs-institution-deadlines-content">
                <div class="gs-institution-deadlines-text">
                    <p>Submitting on time demonstrates commitment and a keen interest in the program, giving a good impression to the applicant. Thus, other than securing the required documents, adhering to the submission deadline is also a must.</p>
            
                    <p>It is essential that you meet the application deadlines at <?php echo $institution_title; ?>. Here are the deadlines:</p>
                </div>
            
                    <ul class="gs-institution-deadlines-list">
                        <?php
                        foreach ($admission_deadlines as $admission_deadline) {
                            
                            $degree = $admission_deadline['degree'];
                            if (!$degree){
                                $degree = "Bachelor's and Master's";
                            
                            }                        
                            
                            $deadline = $admission_deadline['deadline'];
                            
                            $label = $admission_deadline['label'];
                            
                            if ($label) {
                                $label_text = "(" . $label . ")";
                            } else {
                                $label_text = "";
                            }
                            
            
                            $open_date = $admission_deadline['open_date'];
                            $link = $admission_deadline['deadline_link'];
                            $application_all_year = $admission_deadline['accepts_application_all_year_round'];
                            
                            $varied_deadlines = $admission_deadline['varied_deadline'];
                            
                            if ($varied_deadlines == "Yes"){
                                $varied_text = "(Different " . $degree . " programs have different deadlines)";
                            } else {
                                $varied_text = "";
                            }
                            
                            
                            echo '<li>';
                            
                            if ($application_all_year == "Yes"){
                                echo "<a href='" . $link . "'>" . $degree . " Deadline</a>: Accepts Application All Year" ;
                            } else if ($application_all_year == "No"){
                                    echo "<a href='" . $link . "'>" . $degree . " Deadline " . $label_text . "</a>: " . $deadline . " ". $varied_text;
                            }
                            echo '</li>';
                        }
            
                        ?>
                    </ul>
        
                <p>Start being mindful of the deadlines from this moment onward. Submitting your application on or before the deadline ensures that your application will be reviewed and considered. Therefore, avoid late submissions, as these might be reviewed separately or not considered at all.</p>
            </div>
            <div class="gs-institution-deadlines-thumbnail">
                <img class="gs-institution-deadlines-thumbnail-image" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/institution-deadlines.png" alt="Institution Deadlines">
            </div>
        </div>

    </div>
<?php endif; ?>
