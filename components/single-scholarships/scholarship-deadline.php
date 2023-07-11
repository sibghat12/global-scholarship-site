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
        <?php else:  ?>
            <p>The great news is that there is no specific deadline to apply for <scholarship name>! While there are no specific dates, it’s important to apply before the  <a href="<?php echo get_permalink($institution->ID) . '#admissions'; ?>"><?php echo $institution_name; ?> admission deadlines</a>. Here are the deadlines:</p>
            <?php 
            $institution_admissions_deadlines = get_field('admission_deadlines', $institution->ID);

            ?>
         
            <ul class="fa-ul">
            <?php
            if(!empty($institution_admissions_deadlines)) :
                foreach($institution_admissions_deadlines as $key => $admission_deadline ) :
                    ?>

                    <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><div class="deadline-item"><?php echo (($admission_deadline['degree']) ? ($admission_deadline['degree']) : "Bachelor's and Master's"); ?> Deadline (<?php echo $admission_deadline['label'] ?>): <?php echo ($admission_deadline['deadline']) ? $admission_deadline['deadline'] : '(Different '. (($admission_deadline['degree']) ? ($admission_deadline['degree']) : 'Bachelor\'s and Master\'s'). ' programs have different deadlines)' ?></div></li>
                    <?php
                    
                endforeach;
                ?>
            </ul>
            <?php
            endif;
            ?>
    <?php
        endif;
    ?>
</section>