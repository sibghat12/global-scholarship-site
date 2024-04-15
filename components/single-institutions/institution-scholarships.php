<?php if( $undergraduate_list ||$graduate_list ) :
    $degrees = get_field('eligible_degrees');

?>
    <div id="scholarships" class="gs-institution-scholarships">

        <h2 class="gs-institution-scholarships-title"><?php echo $institution_title ?> Scholarships for International Students</h2>
        <?php if($number_of_scholarships > 0) { ?>
        <div class="gs-institution-scholarships-text">
        <?php
            if($undergraduate_list) {
                 
            require get_stylesheet_directory() . '/components/single-institutions/in-house-graduate-ad.php'; 

                ?>

                <div class="gs-institution-scholarships-subtext">
                <?php
                echo  "<h3 class='gs-institution-scholarships-heading'> Undergraduate Scholarships </h3>";
            ?>
            <p>Are you planning to take up a Bachelor’s degree abroad? Then one of the first things you can do is look for scholarship opportunities to apply to. <?php echo $institution_title; ?> is wide-arms open to incoming undergraduate students who want to become international students. The following are the currently available undergraduate scholarships at the institution:</p>
            <?php
                echo "<ul>";
                    foreach($undergraduate_list as $undergraduate_scholarship) :
                    ?>
                    <li><a href="<?php  echo get_permalink($undergraduate_scholarship)?>"><?php echo get_the_title($undergraduate_scholarship); ?></a></li>
            
                    <?php
                    endforeach;
                echo "</ul>";
            ?>
        </div>

        <?php
        $count = 1;

        while ($scholarships_query->have_posts()) {
            $scholarships_query->the_post();
            $degrees = get_field('eligible_degrees');
            if (in_array("Bachelor's", $degrees)) {
                $program = "undergraduate";
                ?>
                <div class="gs-institution-scholarships-scholarship-container">
                    <?php
                require get_stylesheet_directory() .'/components/scholarship-component.php';
                
                $count = $count + 1;
                ?>
                </div>
                <?php
            }
        }
                            
        wp_reset_postdata();    
            

        ?>
        </div>
        <?php } 

            

        // If there is scholarships associated with this institution for Graduate Program.
    
        if($graduate_list) { 
            ?>

            <?php // GS In House Graduate Search Ad ?>

            

            
            <?php
            $degrees = get_field('eligible_degrees');
            ?>
            <div class="gs-institution-scholarships-text">
                <div class="gs-institution-scholarships-subtext">
                    <?php
                    echo  "<h3 class='gs-institution-scholarships-heading'> Graduate Scholarships </h3>"; 
                    ?>
                    <p>International postgraduate students are eligible to various scholarships being offered at the <?php echo$institution_title; ?>. Make sure to review the requirements and deadlines in each scholarship program before applying. Here are the currently available graduate scholarships at the <?php echo$institution_title; ?>:</p>
                    <?php
                    echo "<ul>";
                    foreach($graduate_list as $graduate_scholarship) :
                    ?>
                    <li><a href="<?php  echo get_permalink($graduate_scholarship)?>"><?php echo get_the_title($graduate_scholarship); ?></a></li>

                    <?php
                    endforeach;
                    echo "</ul>";
                    ?>
                </div>

                <?php
                $count = 1; 
                while ($scholarships_query->have_posts() ) {
                    $scholarships_query->the_post();

                    $degrees = get_field('eligible_degrees');

                    if(in_array("Master's", $degrees) || in_array("PhD", $degrees)){
                        $program = "graduate";
                        ?>
                        <div class="gs-institution-scholarships-scholarship-container">
                        <?php
                        require get_stylesheet_directory() .'/components/scholarship-component.php';

                        $count = $count + 1;
                        ?>
                        </div>

                    <?php if($count == 2) : ?>                    
                        <?php // GS Institution Addon (For Graduate) ?>
                        <?php require get_stylesheet_directory() . '/components/single-institutions/institution-addon.php'; ?>
                        <?php
                    endif;

                    }

                }

                wp_reset_postdata();

                ?>

            </div>
            
            
            
        <?php }
          
          if($scholarship_video){ 
               
                $parsed_url = parse_url($scholarship_video);
                parse_str($parsed_url['query'], $query_params);
                $video_id = $query_params['v']; ?>
                 
                 <div class="youtube-video-shortcode-container">
                 <?php echo do_shortcode("[lyte id='$video_id' /]"); ?>
                </div>
            
             <?php }   
        

          }

        ?>
    </div>
    <?php else: ?>

    <div id="scholarships" class="gs-institution-no-scholarships">
        <h2 class="gs-institution-scholarships-title">Funding your studies at <?php echo $institution_title ?> for International Students</h2>

        <p>Even though <?php echo $institution_title ?> itself does not offer scholarships to international students, you can still receive scholarships that can be applied to <?php echo $institution_title ?> from external organizations. Feel free to check out all available external funding opportunities in <a href="<?php echo site_url('category/external-scholarships/'); ?>">our external scholarship database</a>.</p>
        
        <h2 class="gs-institution-scholarships-title">External Scholarships available at <?php echo $institution_title ?></h2>
        <div class="gs-institution-no-scholarships-scholarship-container">
            <h3>GlobalScholarships.com $1,000 Scholarship for International Students</h3>
            <ul>
                <li><a href="<?php echo site_url(); ?>/globalscholarships-com-1000-scholarship-for-international-students/">Scholarship Page</a></li>
                <li>Scholarship Type: Partial Funding</li>
                <li>Scholarship Amount: 1,000 USD</li>
                <li>Degrees Offered : Bachelor's, Master’s, PhD</li>
            </ul>

            <p>Offered by GlobalScholarships.com, incoming international students at <?php echo $institution_title ?> can apply for this external scholarship. To be considered for this external award, you must meet the following eligibility requirements:</p>

            <ul>
                <li>You must be an international student, that is, you cannot be a citizen or a permanent resident of a country that you will be studying in Fall 2024.</li>
                <li>You must be a current or a prospective student who will be enrolled in a postsecondary degree program (Diploma, Associate’s, Bachelor’s, Master’s, Ph.D., as well as professional programs like law and medicine) in Fall 2024.</li>
            </ul>

            <p><b>The recipient will receive a $1,000 scholarship which will be given to your chosen institution and can be used for study-related costs such as tuition fees, books, and others.</b></p>

            <p>Make sure to visit the <a href="<?php echo site_url(); ?>/globalscholarships-com-1000-scholarship-for-international-students/">official scholarship page</a> to learn more about the requirements, application process, and selection criteria</p>
        </div>
    </div>
<?php endif;