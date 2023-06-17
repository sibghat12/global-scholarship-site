<aside>
    <?php if ($country == "United States"){ ?>
        <h2>Related Scholarships in United States</h2>
        <?php if (get_the_ID() % 5 == 0){?>
            <ul>
                <li><a href="/institutions/harvard-university-2/">Harvard University Scholarships</a></li>
                <li><a href="/institutions/yale-university-2/">Yale University Scholarships</a></li>
                <li><a href="/institutions/stanford-university/">Stanford University Scholarships</a></li>
            </ul>    
        <?php } else if (get_the_ID() % 5 == 1){ ?>
            <ul>
                <li><a href="/institutions/massachusetts-institute-of-technology/">MIT Scholarships</a></li>
                <li><a href="/institutions/princeton-university/">Princeton University Scholarships</a></li>
                <li><a href="/institutions/cornell-university/">Cornell University Scholarships</a></li>
            </ul>    
        <?php } else if (get_the_ID() % 5 == 2){ ?>
        <ul>
            <li><a href="/institutions/duke-university/">Duke University Scholarships</a></li>
            <li><a href="/institutions/university-of-chicago/">University of Chicago Scholarships</a></li>
            <li><a href="/institutions/columbia-university/">Columbia University Scholarships</a></li>
        </ul>  
        <?php } else if (get_the_ID() % 5 == 3){ ?>
            <ul>
                <li><a href="/institutions/harvard-university-2/">Harvard University Scholarships</a></li>
                <li><a href="/institutions/princeton-university/">Princeton University Scholarships</a></li>
                <li><a href="/institutions/rice-university/">Rice University Scholarships</a></li>
            </ul>    
        <?php } else if (get_the_ID() % 5 == 4){ ?>
        <ul>
            <li><a href="/institutions/duke-university/">Duke University Scholarships</a></li>
            <li><a href="/institutions/massachusetts-institute-of-technology/">MIT Scholarships</a></li>
            <li><a href="/institutions/columbia-university/">Columbia University Scholarships</a></li>
        </ul>                  
        <?php } ?>

    <?php } ?>

    <?php if ($country == "South Korea"){ ?>
        <h2>Related Scholarships in South Korea</h2>
        <?php if (get_the_ID() % 3 == 0){?>
            <ul>
                <li><a href="/institutions/seoul-national-university/">Seoul National University Scholarships</a></li>
                <li><a href="/institutions/yonsei-university/">Yonsei University Scholarships</a></li>
                <li><a href="/institutions/korea-university/">Korea University Scholarships</a></li>
            </ul>    
        <?php } else if (get_the_ID() % 3 == 1){ ?>
            <ul>
                <li><a href="/institutions/korea-advanced-institute-of-science-and-technology/">KAIST Scholarships</a></li>
                <li><a href="/institutions/yonsei-university/">Yonsei University Scholarships</a></li>
                <li><a href="/institutions/kyung-hee-university/">Kyung Hee University Scholarships</a></li>
            </ul>    
        <?php } else if (get_the_ID() % 3 == 2){ ?>
        <ul>
            <li><a href="/institutions/seoul-national-university/">Seoul National University Scholarships</a></li>
            <li><a href="/institutions/sungkyunkwan-university/">Sungkyunkwan University Scholarships</a></li>
            <li><a href="/institutions/inha-university/">Inha University Scholarships</a></li>
        </ul>                  
        <?php } ?>

    <?php } ?>   
</aside>