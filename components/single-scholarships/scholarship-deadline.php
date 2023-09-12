<section id="scholarship-deadline" class="gs-scholarship-deadline">

    <h2>When to Apply for <?php echo $scholarship_title; ?></h2>

    <?php
        if (Null != $scholarship_deadlines && !empty($scholarship_deadlines)) :

        ?>
        <p>For <?php echo $scholarship_title; ?>, you may apply on these dates:</p>

        <?php 
        if ($scholarship_deadlines){
            echo '<ul>';
            while( have_rows("scholarship_deadlines")) {
                the_row();
                $degree = get_sub_field('degree');
                
                if (!$degree){
                    $degree = $degrees_text;
                }                        
                                        
                $open_date = get_sub_field('open_date');
                $deadline = get_sub_field('deadline');
                $label = get_sub_field("label");
                
                if ($label) {
                    $label_text = " (" . $label . ") ";
                } else {
                    $label_text = "";
                }
                
                echo '<li>'; ?>
                <a href="<?php echo ($scholarship_deadline_link) ? $scholarship_deadline_link : $scholarship_page_link; ?>"><?php echo $degree; ?> Scholarship Application Deadline<?php echo $label_text; ?></a>: <?php echo $deadline; ?>
                <?php 
                echo '</li>';
            }
            echo '</ul>';                  
          }
        ?>

        <p>We also recommend visiting the <?php echo $institution_name; ?> Admissions Section for other university deadlines and requirements.</p>
        <?php else:  
            
            if($degrees_text != 'PhD') :
            
            ?>
            <p>The great news is that there is no specific deadline to apply for <?php echo $scholarship_title; ?>! While there are no specific dates, it’s important to apply before the  <a href="<?php echo get_permalink($institution->ID) . '#admissions'; ?>"><?php echo $institution_name; ?> admission deadlines</a>. Here are the deadlines:</p>

            <ul>
            <?php
            $institution_admissions_deadlines = get_field('admission_deadlines', $institution->ID);
                     
            if(!empty($institution_admissions_deadlines)) :
                foreach($institution_admissions_deadlines as $key => $admission_deadline ) :
                    
                    $varied_deadlines = $admission_deadline["varied_deadline"];

                    $application_all_year =  $admission_deadline["accepts_application_all_year_round"];

                    $degree = $admission_deadline['degree'];
                    if (!$degree){
                        $degree = "Bachelor's and Master's";
                    
                    }    
                    if ($varied_deadlines == "Yes"){
                        $varied_text = "(Different " . $degree . " programs have different deadlines)";
                    } else {
                        $varied_text = "";
                    }

                    $application_text = '';
                    if ($application_all_year == "Yes"){
                        $application_text .= "<a href='" . $admission_deadline['deadline_link'] . "'>" . $degree . " Deadline</a>: Accepts Application All Year" ;
                    } else if ($application_all_year == "No"){
                        $application_text .= "<a href='" . $admission_deadline['deadline_link'] . "'>" . $degree . " Deadline " . $admission_deadline['label'] . "</a>: " . $admission_deadline['deadline'] . " ". $varied_text;
                    }
                    
                    ?>

                    <li>
                        <div class="deadline-item">
                           <?php echo $application_text; ?>
                        </div>
                    </li>
                    <?php
                    
                endforeach;
                ?>
            </ul>
            <?php
            endif;
            ?>
        <?php else: ?>

            <p>The great news is that there is no specific deadline to apply for <?php echo $scholarship_title; ?>! While there is no fixed deadline, you are encouraged to submit your application as early as possible. We recommend visiting the <a href="<?php echo get_permalink($institution->ID) . '#admissions'; ?>"><?php echo $institution_name; ?> Admissions Section</a> for additional dates and requirements.</p>
            <?php
            
            endif;

        endif;
    ?>
</section>