<?php if (isset($admission_pages) && !empty($admission_pages)) :
?>
    <div id="admissions" class="gs-institution-admissions">
        <h2 class="gs-institution-admissions-title">
            <?php echo $institution_title;  ?> Admissions
        </h2>

        <div class="gs-institution-admissions-text">
            <p>If you’re planning to study at the <?php echo $institution_title; ?>, it’s important to familiarize yourself with the application process and requirements of the institution.</p>
        
            <p>Each institution follows a unique application procedure, so you must be alert and updated on their latest announcements. Visit their official website occasionally and only utilize legitimate channels when submitting applications. Moreover, it is crucial to always take note of the essential details related to your admission in order to ensure a seamless application process.</p>
        
            <p>To apply to <?php echo $institution_title; ?>, make sure to complete the admission requirements and follow the application procedure. You can find more information on the following links:</p>
        </div>
        <?php
            $bachelors_links = array();
            $masters_links = array();
            foreach ($admission_pages as $admission_page) {
                if ($admission_page['degree_name'] == "Bachelor's") {
                    $bachelors_links[] = [
                        'type' => $admission_page['type'],
                        'link' => $admission_page['admissions_link']
                    ];
                } elseif($admission_page['degree_name'] == "Master's") {
                    $masters_links[] = [
                        'type' => $admission_page['type'],
                        'link' => $admission_page['admissions_link']
                    ];
                }
            }

            if (!empty($bachelors_links) || !empty($masters_links)) {
                echo '<div class="gs-institution-admissions-boxes">';
                
                if (!empty($bachelors_links)) {
                    echo '<div class="gs-institution-admissions-box gs-institution-admissions-box-bachelors">';
                    ?>
                    <div class="gs-institution-admissions-thumbnail-container">
                        <img class="gs-institution-admissions-thumbnail-image" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/institution-admissions.png" alt="Institution Admissions">
                    </div>
                    <div class="gs-institution-admissions-box-text">
                    <?php
                    echo '<p class="gs-institution-admissions-degree">Bachelor\'s</p>';
                    echo '<div class="gs-institution-admissions-links">';
                    echo '<ul>';
                    foreach ($bachelors_links as $link) {
                        if (!empty($link['link'])) {
                            echo '<li><a class="gs-institution-admissions-link" href="' . $link['link'] . '">' . $link['type'] . ' Students Admissions Page</a></li>';
                        }
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                
                if (!empty($masters_links)) {
                    echo '<div class="gs-institution-admissions-box gs-institution-admissions-box-masters">';
                    ?>
                    <div class="gs-institution-admissions-thumbnail-container">
                        <img class="gs-institution-admissions-thumbnail-image" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/institution-admissions.png" alt="Institution Admissions">
                    </div>
                    <div class="gs-institution-admissions-box-text">
                    <?php

                    echo '<p class="gs-institution-admissions-degree">Master\'s</p>';
                    echo '<div class="gs-institution-admissions-links">';
                    echo '<ul>';
                    foreach ($masters_links as $link) {
                        if (!empty($link['link'])) {
                            echo '<li><a class="gs-institution-admissions-link" href="' . $link['link'] . '">' . $link['type']  . ' Students Admissions Page</a></li>';
                        }
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                
                echo '</div>';
            }

             
             if($application_video){ 
               
                $parsed_url = parse_url($application_video);
                parse_str($parsed_url['query'], $query_params);
                $video_id = $query_params['v']; ?>
                 
                 <div class="youtube-video-shortcode-container">
                 <?php echo do_shortcode("[lyte id='$video_id' /]"); ?>
                </div>
            
             <?php }

            ?>
    
    </div>
<?php endif; ?>
