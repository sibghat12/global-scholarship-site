<section id="scholarship-outro" class="gs-scholarship-outro">
    <h2><?php echo $scholarship_title; ?> Page</h2>

    <p>Want to learn more about <?php echo $institution_name; ?>, <?php echo $scholarship_title; ?>, requirements, application process, and other related information? Check the <a href="<?php echo $scholarship_page_link; ?>"><?php echo $scholarship_title; ?> page</a>!</p>


    <!--
    <h2>Popular Scholarships in  --> <?php //echo $country_name; ?> <!--</h2> 


-->
    <?php

    /*



    $country_institutions = get_institutions_location($country_name);

    $country_institutions_ids = $country_institutions->posts;

    $fully_funded_scholarship_in_country = [];
    
    foreach($country_institutions_ids as $id ) {
        $scholarships = get_fully_funded_scholarships($id); // Assuming there is a function to retrieve fully funded scholarships for a given institution ID.

        $fully_funded_scholarship_in_country = array_merge($fully_funded_scholarship_in_country, $scholarships->posts);
        
    }


    // We only get the first 5 Fully funded Scholarships
    //$fully_funded_scholarship_in_country = array_slice( $fully_funded_scholarship_in_country, 0, 5);
    ?>
    <!-- Display Popular Scholarships in Country --->

    
  
    <div class="gs-popular-scholarships-container">


        <?php// foreach($fully_funded_scholarship_in_country as $key => $scholarship) : ?>
            <div class="gs-popular-scholarship-item">
                <a href="<?php echo get_the_permalink($scholarship) ?>"><?php echo get_the_title($scholarship); ?></a>
            </div>
        <?php endforeach ?>
    </div>

    */?>



    

</section>

