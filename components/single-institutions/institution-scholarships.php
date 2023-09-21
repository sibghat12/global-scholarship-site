<?php if( $undergraduate_list ||$graduate_list ) :
    $degrees = get_field('eligible_degrees');

?>
<div id="institution-scholarships" class="gs-institution-scholarships">

    <h2 class="gs-institution-scholarships-title"><?php $institution_title ?> Scholarships for International Students</h2>
    <?php if($number_of_scholarships > 0) { ?>
    <div class="gs-institution-scholarships-text">
    <?php
        if($undergraduate_list) {
            ?>
            <div class="gs-institution-scholarships-subtext">
            <?php
            echo  "<h2> Undergraduate Scholarships </h2>";
        ?>
        <p>Are you planning to take up a bachelor’s degree abroad? Then one of the first things you can do is look for scholarship opportunities to apply to. <?php echo $institution_title; ?> is wide-arms open to incoming undergraduate students who want to become international students. The following are the currently available undergraduate scholarships at the institutions:</p>
        <?php
    
        if (in_array("Bachelor's", $degrees)) {
            echo "<ul>";
                foreach($undergraduate_list as $undergraduate_scholarship) :
                ?>
                <li><a href="<?php  echo get_permalink($undergraduate_scholarship)?>"><?php echo get_the_title($undergraduate_scholarship); ?></a></li>
        
                <?php
                endforeach;
            echo "</ul>";
        }
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
        $degrees = get_field('eligible_degrees');
        ?>
        <div class="gs-institution-scholarships-text">
            <div class="gs-institution-scholarships-subtext">
                <?php
                echo  "<h2> Graduate Scholarships </h2>"; 
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
                    <?php

                }

            }

            wp_reset_postdata();

            ?>

        </div>
        
        
        
    <?php } ?> 

    <p> With these <?php echo $institution_title; ?> scholarships for international students, you can finally study abroad financially worry-free. If you’re interested, make sure to also check out the <a href="/opencourses/">Open Courses for International Students</a>.</p>  

    <?php } 
    ?>
    </div>
<?php
endif;