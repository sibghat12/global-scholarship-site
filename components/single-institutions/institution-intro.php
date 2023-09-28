<div id="institution-overview" class="gs-institution-intro-section">

<?php
 if ($country_name == "United Kingdom") {?>

    <p>With its ancient universities, top-ranked institutions, and deep history, there is no doubt why the UK is a top destination among international students. Indeed, the country hosted more than 600,000 aspirants from 2020 to 2021.</p>    

    <p>If you want to join the throng of learners who make their way to this nation, you’ll need to enroll in a university. In that case, you may want to include the <?php echo $institution_title; ?> in your list of options.</p>

    <?php if($total_students > 0) : ?>
        <p><?php echo $institution_title; ?> is located in <?php echo $city_name . ", " . $country_name; ?>, and it was established in <?php echo $founded_year; ?>. It is home to <?php echo $total_students_formatted; ?> students, so you’re sure to find a welcoming community that can give you the boost you need to achieve your academic potential.</p>
    <?php else: ?>
        <p><?php echo $institution_title; ?> is located in <?php echo $city_name . ", " . $country_name; ?> and it was established in  <?php echo $founded_year; ?>. You’ll surely find a welcoming community that can give you the boost you need to achieve your academic potential.</p>
    <?php endif; ?>
    
    <?php } elseif ($country_name == "United States"){?>

    <p>Many American institutions have made their education and names synonymous to prestige and excellence. Thus, it is unsurprising that the country and its institutions are among the top choices of aspiring international students when deciding where to study abroad. 
    </p>

    <p>With that said, are you interested in studying in the US, as well? If you are, you might want to consider going to <?php echo $institution_title; ?>, a premier institution in <?php echo $city_name . ", " . $country_name; ?>. <?php echo ($total_students > 0) ?  "You’ll be joining the " .$total_students_formatted ." students who go there every year.": 'You’ll be joining many students who go there every year.'; ?></p>

    <?php } elseif ($country_name == "Canada"){?>

    <p>Canada has joined the group of countries that top the lists of international students. After all, who wouldn’t want to go there when the country has so much to offer, such as high-quality education, picturesque sites, premier healthcare system, and other great benefits?</p>

        <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p>There are also many top-tier institutions to choose from, including the <?php echo $institution_title; ?>. Established in <?php echo $founded_year; ?>, you can study in this university to experience the Canadian dream while expanding your knowledge and skills. This institution offers programs such as, <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>.</p>
        <?php else: ?>
            <p>There are also many top-tier institutions to choose from, including the <?php echo $institution_title; ?>. Established in <?php echo $founded_year; ?>, you can study in this university to experience the Canadian dream while expanding your knowledge and skills.</p>
        <?php endif; ?>

    <?php } elseif ($country_name == "South Korea"){?>

    <p>Being an international student in South Korea is a unique and memorable experience. You get to learn so much, and not just about your program as you’ll be exposed to Korean culture, language, and traditions. Not to mention, the country has a ton of beautiful sites you can explore while studying there.</p>

    <p>Thus, if you’ve been thinking about studying at SK, you should go for it! You can choose from many institutions, such as the <?php echo $institution_title; ?> in <?php echo $city_name . ", " . $country_name; ?>. It was established in <?php echo $founded_year; ?> 
    <?php echo ($total_students > 0) ?  "and welcomes " .$total_students_formatted ." students every year.": "and welcomes many students every year."; ?></p>
    <?php } elseif ($country_name == "Australia"){?>
    <p>Have you been wanting to explore the Land Down Under? You can do that while being an international student! </p>

    <p> For years, Australia has welcomed thousands of international students. It's not just the amazing sites that draw these people. Australian institutions have been joining the top spots of world university rankings. Therefore, you’ll be receiving top-tier education if you go there.</p>

    <p>
    As said, there are many highly recognized institutions in Australia, and one of them is the  <?php echo $institution_title; ?> in <?php echo $city_name . ", " . $country_name; ?>. It was founded in <?php echo $founded_year; ?> 
    <?php echo ($total_students > 0) ?  "and serves as the second home to " .$total_students_formatted ." students.": "and serves as the second home to many students."; ?></p>
    <?php } elseif ($country_name == "Japan"){?>
    <p>
    In today’s era, Japan is a world-leader in terms of research, technology, education, and overall society. Therefore, there’s no better to go and learn from than a Japanese institution, such as <?php echo $institution_title; ?>.
    </p>
    <p><?php echo $institution_title; ?> is a premier <?php echo $type; ?> institution you can find in <?php echo $city_name . ", " . $country_name; ?>. It was founded in <?php echo $founded_year; ?>, and has since molded young learners to become smart contributors to the modern world. 
    <?php echo ($total_students > 0) ?  "Annually, it welcomes around " .$total_students_formatted ." students.": "Annually, it welcomes around  many students."; ?></p>

    <?php } elseif ($country_name == "China"){?>

    <p>The Sleeping Giant of Asia is not just home to booming industries, grandiose sites, or deep-rooted culture. It also has several top-tier universities, which include <?php echo $institution_title; ?>. An education from these institutions is sure to provide you with great experience, incredible learnings, and a career boost (especially if you learn the region’s language!).</p>

    <p>With that said, you really should consider <?php echo $institution_title; ?>. This Chinese academe was founded in <?php echo $founded_year; ?> and currently located in <?php echo $city_name . ", " . $country_name; ?>.
    <?php echo ($total_students > 0) ?  "It is said to welcome " .$total_students_formatted ." students per year, and soon you can be one of them, too!": "It is said to welcome many students per year, and soon you can be one of them, too!"; ?></p>

    <?php } elseif ($country_name == "Denmark"){?>
    <p>Find yourself in the midst of jaw-dropping views, peaceful nature, and beautiful society when you enroll at <?php echo $institution_title; ?> in <?php echo $city_name . ", " . $country_name; ?>. This Danish institution was established in <?php echo $founded_year; ?>, and since then, has been equipping students with valuable knowledge and skills that help move their careers forward.</p>
    
    <p><?php echo ($total_students > 0) ?  "The institution welcomes " .$total_students_formatted ." students per year.": "The institution welcomes many students every year."; ?> These students can choose from many programs, such as <?php echo $degrees_text; ?>. You can easily be one of them soon!</p>
    
    <?php } elseif ($country_name == "Sweden"){?>
    <p>Indulge yourself with breathtaking lake views and forests in Sweden! The country is the home of many world-class universities, including <?php echo $institution_title; ?>. 
    <?php echo ($total_students > 0) ?  "With over " .$total_students_formatted ." students from different places around the globe": "With many students coming from different places around the globe."; ?>, the <?php echo $institution_title; ?> offers a welcoming place and a huge opportunity for individuals to grow and thrive in their chosen careers.</p>

    <p>Since <?php echo $founded_year; ?>, the <?php echo $institution_title; ?> has been offering excellent training and is located in <?php echo $city_name . ", " . $country_name; ?>. You’ll surely gain the best educational experience as you pursue your studies here!</p>

    <?php } elseif ($country_name == "New Zealand"){?>

    <p>Breathe the refreshing air and explore the exhilarating sites of New Zealand while you study there! The archipelago is home to <?php echo $institution_title; ?>, <?php echo ($total_students > 0) ?  "which welcomes " .$total_students_formatted ." students annually": "which welcomes many students annually"; ?>, and you can be one of them!</p>

        <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p><?php echo $institution_title; ?> is in <?php echo $city_name . ", " . $country_name; ?> and was founded in <?php echo $founded_year; ?>. It is known for its programs like <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>. Its facilities and educators are also worldclass, so you’re sure to experience quality training that will propel your career and expand your knowledge.</p>
        <?php else: ?>
            <p><?php echo $institution_title; ?> is in <?php echo $city_name . ", " . $country_name; ?> and was founded in <?php echo $founded_year; ?>. It offers various academic programs for both local and international students. Its facilities and educators are also world-class, so you’re sure to experience quality training that will propel your career and expand your knowledge.</p>
        <?php endif; ?>
    
    <?php } elseif ($country_name == "Switzerland"){?>

    <p>From snow-capped Alps to ancient medieval towns, Switzerland is a paradise for students who want to study here. The country is abundant in picturesque spots, mouth-watering foods, and prominent international schools. <?php echo $institution_title; ?> is just one of the many Swiss institutions known for being open to international student regardless of their race, background, and culture. </p>

    <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p>This Swiss institution is located in the stunning city of <?php echo $city_name . ", " . $country_name; ?> and has been in the education sector since <?php echo $founded_year; ?>. <?php echo $institution_title; ?> has a population of <?php echo $total_students_formatted; ?> students, offering degree courses in <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>. Over the years, it has already produced thousands of graduates who now succeed in their desired career paths.</p>
        <?php else: ?>
            <p>This Swiss institution is located in the stunning city of <?php echo $city_name . ", " . $country_name; ?> and has been in the education sector since <?php echo $founded_year; ?>. Over the years, <?php echo $institution_title; ?> has already produced thousands of graduates who now succeed in their desired career paths.</p>
        <?php endif; ?>

    <?php } elseif ($country_name == "Poland"){?>

    <p>Explore ancient cities and historical monuments when you choose to study in Poland. Poland is such a feast in the eyes of everyone who steps into the country, especially for international students. But more than its tourist spots, the country also has so much more to offer when it comes to education.</p>

    <p><?php echo $institution_title; ?> is one of Poland's esteemed universities. Since its establishment in <?php echo $founded_year; ?>, it has been at the forefront of delivering quality training that boosts the intelligence and knowledge of its students. <?php echo ($total_students > 0) ?  "the university holds over " .$total_students_formatted ." students annually.": "the university have many students annually."; ?></p>

    <?php } elseif ($country_name == "Ireland"){?>

    <p>When talking about hospitable, warm and friendly locals, Ireland is the perfect answer to that! It is one of the top destinations for international students due to the healthy environment it gives to anyone who studies here. It is also the home country of a well-respected educational institution, the <?php echo $institution_title; ?>.</p>

    <p>Opened in <?php echo $founded_year; ?>, <?php echo $institution_title; ?> continuously attracts international students due to its quality education, and diverse community. It is located in <?php echo $city_name . ", " . $country_name; ?>,
    <?php echo ($total_students > 0) ?  "with over " .$total_students_formatted ." students enrolled annually.": "with many students enrolled annually."; ?><?php echo $institution_title; ?> aims to provide the best training to its students by having facilities, laboratories, and infrastructures that can aid their learning. </p>
    
    <?php } elseif ($country_name == "France"){?>

    <p>Stunning arts, finest couture, and phenomenal infrastructures are just some of the reasons why France is a popular destination for international students. It offers a convenient environment for students to access all their living essentials while studying at their chosen university.</p>

    <p>Speaking of iconic universities, <?php echo $institution_title; ?> is an institution located at <?php echo $city_name . ", " . $country_name; ?>. <?php echo ($total_students > 0) ?  " It is the home of " .$total_students_formatted ." students coming from different parts of the world.": "It is the home to many students coming from different parts of the world."; ?> As an international student at <?php echo $institution_title; ?>, you’ll surely get the utmost quality for your education!</p>
    
    <?php } elseif ($country_name == "Italy"){?>

    <p>With Italy's mesmerizing architecture, pristine beaches, and astounding educational system, thousands of international students aim to study in the country every year. It is one of the best countries to visit, especially if you are inclined toward arts, fashion, and design. Italy houses one of the most prominent institutions in the world, the <?php echo $institution_title; ?>.</p>

    <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p><?php echo $institution_title; ?> was established in <?php echo $founded_year; ?> at <?php echo $city_name . ", " . $country_name; ?>. Since then, it has grown to become a respected academic institution that offers programs such as <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>. 
            <?php echo ($total_students > 0) ?  "With an annual population of " .$total_students_formatted ." students": "With large population of students"; ?>, <?php echo $institution_title; ?> has successfully created a space for students to achieve their aspirations and maximize their skills.</p>
        <?php else: ?>
            <p><?php echo $institution_title; ?> was established in <?php echo $founded_year; ?> at <?php echo $city_name . ", " . $country_name; ?>. Since then, it has grown to become a respected academic institution that offers various academic programs for international students. <?php echo $institution_title; ?> has successfully created a space for students to achieve their aspirations and maximize their skills.</p>
        <?php endif; ?>
        
    <?php } elseif ($country_name == "Qatar"){?>

    <p>Qatar is another country that you can consider if you’re planning to study abroad. Aside from its unique culture, fascinating atmosphere and diverse lifestyle, this country offers world class education to all students.</p>

    <p><?php echo $institution_title; ?> is one of Qatar’s best educational institutions. It was established in <?php echo $founded_year; ?> and as a student here, you’ll be exposed to a welcoming environment as you pursue your chosen field!</p>
            
    <?php } elseif ($country_name == "Germany"){?>

    <p>Germany is a magnet for international students with its high academic standards, affordable (even free!) tuition, and outstanding facilities. There is also a broad spectrum of study programs, including high-end STEM courses. Additionally, there are several internships, scholarships, and research opportunities.</p>

    <p>If you wish to experience the life of an international student in Germany, consider enrolling in <?php echo $institution_title; ?>, which is in <?php echo $city_name . ", " . $country_name; ?>. 
    <?php echo ($total_students > 0) ?  "It welcomes " .$total_students_formatted ." of students every year": "It welcomes many students every year"; ?> since it was founded in <?php echo $founded_year; ?>. Thus, you’re sure to find people who you can relate with and contribute to your growth.</p>

    <?php } elseif ($country_name == "Singapore"){?>

    <p>Singapore has built a reputation for academic excellence not just in Asia, but across the world. Such a feat can be credited to its world-class education system that produces highly advanced and competitive academic talent. The country also also hosts students from various corners of the globe, which gives you the opportunity to meet, network, and make connections with plenty of new people.</p>
    
    <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p>You can enjoy all those Singaporean education benefits by being an international student at <?php echo $institution_title; ?>. You’ll find this institution in <?php echo $city_name . ", " . $country_name; ?>, where it welcomes <?php echo $total_students_formatted; ?> of students every year. <?php echo $institution_title; ?> was founded in <?php echo $founded_year; ?>, and is best known for its high-quality programs, such as <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>.</p>
        <?php else: ?>
            <p>You can enjoy all those Singaporean education benefits by being an international student at <?php echo $institution_title; ?>. You’ll find this institution in <?php echo $city_name . ", " . $country_name; ?>, where it welcomes both local and international students. <?php echo $institution_title; ?> was founded in <?php echo $founded_year; ?>, and is best known for its high-quality programs and other academic opportunities.</p>
        <?php endif; ?> 
    
    <?php } elseif ($country_name == "Greece"){?>

    <p>Greece takes pride in becoming a leading destination for international students. Some of the reasons it attracts so many learners are its rich cultural and historical legacy, cutting-edge education system, unique English-taught programs, low tuition fees, safe environment, and valuable internship opportunities.</p>

    <p>Do all those sound too good? Discover for yourself by attending <?php echo $institution_title; ?>, a Greek university you may find in <?php echo $city_name . ", " . $country_name; ?>. It’s been molding students since <?php echo $founded_year; ?>, 
    which has since grown to <?php echo $total_students_formatted; ?> annually.
    <?php echo ($total_students > 0) ?  "which has since grown to " .$total_students_formatted ." annually.": "which has since grown to attract many students every year"; ?> 
     Don’t miss the opportunity to be one of them!</p>

        
    <?php } elseif ($country_name == "Norway"){?>

    <p>Norway has a solid reputation for research and offers premium education at relatively low costs. It also has an active student life, with many opportunities to participate in clubs, societies, and events. You also won’t have to be scared to join those activities, as the country is known for its consistently low crime rate. </p>

    <p>To benefit from all those, enroll at <?php echo $institution_title; ?>. As one of the <?php echo $type; ?> institutions in Norway, you’ll have the opportunity to earn a world-class degree and be a part of an global community!</p>
            
    <?php } elseif ($country_name == "Netherlands"){?>

    <p>The Netherlands is home to a growing international student community, with members from over a hundred different countries. So many students are attracted to this country because not only are living costs lower than other English-speaking nationals, Dutch institutions are also known for their innovative methods that focus on students and interactive teaching.</p>

    <p>Experience that unique learning experience yourself by studying at <?php echo $institution_title; ?>, a Dutch institution that has been active since <?php echo $founded_year; ?>. It is in <?php echo $city_name . ", " . $country_name; ?> and 
    <?php echo ($total_students > 0) ?  "welcomes " .$total_students_formatted ." students annually": "welcomes many students annually"; ?>, who could be your chums should you go here! </p>

    <?php } elseif ($country_name == "India"){?>

    <p>India is the intersection of various cultures, languages, and traditions, making it an exciting place to study. It also has a long history of providing quality education, with many top-ranking universities and institutions that are surrounded by cutting-edge technology companies and research institutions.</p>

    <p>Among those top-tier institutions is <?php echo $institution_title; ?>.<?php echo ($total_students > 0) ?  "It hosts " .$total_students_formatted ." students every year": "It hosts many students every year"; ?>, and you can be one of them soon! You only have to comply with the admission requirements, and you’ll see yourself heading to <?php echo $city_name . ", " . $country_name; ?>, which is where the institution is located.</p>

    <?php } elseif ($country_name == "Philippines"){?>

    <p>There is a growing community of international students in the Philippines. That phenomenon can be attributed to the general population’s fluency in English (which extends to academia), low living costs, premier education, rich culture, and wonderful sights.</p>

    <p>Also, there are many reputed institutions you can go to if you choose to be an international student in the Philippines. One of them is <?php echo $institution_title; ?>, which is in <?php echo $city_name . ", " . $country_name; ?> and was founded in <?php echo $founded_year; ?>. Simply comply with admission requirements,<?php echo ($total_students > 0) ?  " and you can join its population of " .$total_students_formatted ." students": " and you can join many students that are enrolling annually"; ?>.
    </p>

    <?php } elseif ($country_name == "Spain"){?>

    <p>Thousands of international students have made their way to Spain. Some of the reasons many foreigners opted to study there are its high-quality education, numerous research opportunities, diverse culture, and the chance to learn other languages.</p>

        <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p>To become an international student in Spain, you’ll need to pick a university. If you haven’t chosen one, consider <?php echo $institution_title; ?> in <?php echo $city_name . ", " . $country_name; ?>. This institution, which was established in <?php echo $founded_year; ?>, offers courses in <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>, and other fields. Even when you’re thousand of miles from home, you won’t feel alone here as there’s a <?php echo $institution_title; ?>.<?php echo ($total_students > 0) ?  "bustling crowd of " .$total_students_formatted ." students": "bustling crowd of many students"; ?>.
            </p>
        <?php else: ?>
            <p>To become an international student in Spain, you’ll need to pick a university. If you haven’t chosen one, consider <?php echo $institution_title; ?> in <?php echo $city_name . ", " . $country_name; ?>. This institution, which was established in <?php echo $founded_year; ?> and it offers various courses for international students like you! Even when you’re thousand of miles from home, you won’t feel alone here as there’s a bustling crowd of international students here.</p>
        <?php endif; ?> 
    

    <?php } elseif ($country_name == "Portugal"){?>

    <p>Many students fell in love with Portugal, and why wouldn’t they? As a student there, you enjoy low tuition fees, affordable cost of living, friendly culture, sunny climate, and historical sites. All the while, you’re pursuing a high-quality degree program and learning a new language.</p>

    <p>If you’ve made up your mind to study in Portugal, apply to <?php echo $institution_title; ?>. It’s a top-tier institution established in <?php echo $founded_year; ?>. It is situated in <?php echo $city_name . ", " . $country_name; ?>, 
    where most of its <?php echo $total_students_formatted; ?> students congregate and learn <?php echo $institution_title; ?>.<?php echo ($total_students > 0) ?  " where most of its " .$total_students_formatted ." students congregate and learn": " where most of its many students congregate and learn"; ?>
    .</p>

    <?php } elseif ($country_name == "South Africa"){?>

    <p>Have you always dreamed of exploring South Africa? Well, you can do that while learning if you’re an international student at <?php echo $institution_title; ?>. As its student, you’ll find yourself at home in <?php echo $city_name . ", " . $country_name; ?> <?php echo ($total_students > 0) ?  " where most of its " .$total_students_formatted ." other learners": " where you can find many other learners"; ?>.</p>

    <p>The prospect of studying in South Africa may be intriguing, but it’s not novel. Many have had the chance to study in its most prestigious institutions (like <?php echo $institution_title; ?>), immerse in the rich culture and history, learn new languages, and see stunning landscapes. All those at relatively low costs!</p>
    
    <?php } elseif ($country_name == "Russia"){?>

    <p>Russia is an underrated destination for students. Learners who had gone there from various parts of the world had the incredible chance to earn a high-quality degree, learn new languages, immerse in exotic culture, and see grand sites. They experienced all that at relatively low costs, too!</p>

    <p>One of the institutions they were able to do all that in was <?php echo $institution_title; ?>. It’s situated in <?php echo $city_name . ", " . $country_name; ?> and was founded in <?php echo $founded_year; ?>. Annually, <?php echo ($total_students > 0) ?  " it expects " .$total_students_formatted ." students": " it expects many students enrolling"; ?>, and you can become one of them! If you request admission there, don’t forget to try applying for funding.</p>
    
    <?php } elseif ($country_name == "Czech Republic"){?>

    <p>Czech Republic may seem like just a small nation in Central Europe, but it offers more than what meets the eye. It has a rich history, evident in its towering castles and hundred-year old universities. Thus, it’s no surprise that the country is a magnet for young learners who are curious about these long standing structures.</p>

    <p>If you’re one such learner, you’re in the right place (or rather, article!). We’ll be talking about <?php echo $institution_title; ?>, an institution in <?php echo $city_name . ", " . $country_name; ?>. It was founded in <?php echo $founded_year; ?>, so it’s had significant experience molding students, whether native or foreign.</p>
    
    <?php } elseif ($country_name == "Austria"){?>

    <p>Have you imagined yourself studying amidst snow-capped mountains, lush sceneries, grand castles, and magnificent churches? You can make that reverie come true by studying Austria, a small, land-locked country in the heart of Europe.</p>

    <p>You have a choice of many academic institutions there, but you may want to consider <?php echo $institution_title; ?>, which was founded in <?php echo $founded_year; ?>. Once admitted, you’ll find yourself charmed by its campus in <?php echo $city_name . ", " . $country_name; ?>. <?php echo ($total_students > 0) ?  " You’ll also find yourself enthralled amidst the crowd of " .$total_students_formatted ." students": " You’ll also find yourself enthralled amidst the crowd of many students"; ?>.</p>
    
    <?php } elseif ($country_name == "Finland"){?>

    <p>Do you want the chance to study in the happiest country in the world? You can have that by enrolling in a university in Finland! This country of ice and snow is renowned not just for its carbon reduction efforts, complex language, thousand lakes, or social democratic system.</p>

    
    <?php if( !empty($bachelor_courses) || !empty($master_courses)) : ?>
            <p>The country is also popular for its affordable education, offered by prestigious universities. One of such institutions is <?php echo $institution_title; ?>, which stands in <?php echo $city_name . ", " . $country_name; ?>. Founded in <?php echo $founded_year; ?>, you can choose from the many programs it offers, which <?php echo (isset($bachelor_courses_string) && !empty($bachelor_courses_string)) ? $bachelor_courses_string : ((isset($master_courses_string) && !empty($master_courses_string)) ? $master_courses_string : ''); ?>.</p>
        <?php else: ?>
            <p>The country is also popular for its affordable education, offered by prestigious universities. One of such institutions is <?php echo $institution_title; ?>, which stands in <?php echo $city_name . ", " . $country_name; ?>. Aside from its academic subjects, this <?php echo $type; ?> institution also offers a variety of extracurricular activities and opportunities for international students to get involved.</p>
        <?php endif; ?> 

    
    <?php } elseif ($country_name == "Turkey"){?>

        <p>Experience high-quality education in Turkey! The country is located on the border of Southeast Europe and West Asia, which is why its locals showcase diverse cultures and traditions. Beyond its historic places and notable landmarks, Turkey also offers a great place for international students to study and live.</p>
        
        <p>One of the renowned Turkish universities is <?php echo $institution_title; ?>. Since <?php echo $founded_year; ?>, it has already trained students from different parts of the world. It is located in <?php echo $city_name . ", " . $country_name; ?> and considered as one of the best institutions in the country.</p>
    
        <?php } elseif ($country_name == "Taiwan"){?>

        <p>Famous for its delicious street foods and captivating lantern festivals, Taiwan is a stunning location for international students looking for a place to learn. Its vibrant cities and friendly locals are worth considering, especially its affordable living costs!</p>

        <p>In addition, Taiwan is also home to many internationally-recognized universities. One of which is <?php echo $institution_title; ?> located in <?php echo $city_name . ", " . $country_name; ?>. As an international student here, you’ll have the chance to open new learning opportunities for your chosen field!</p>
            
        <?php } elseif ($country_name == "Indonesia"){?>

            <p>Do you want to learn at the world's largest archipelagic state? Then, come to Indonesia and witness its diverse and astonishing landscapes! The country is located in Southeast Asia and is one of the top destinations for international students due to its climate and living standards.</p>

            <p>If you are looking for an educational institution in the country, the prominent <?php echo $institution_title; ?> might be the answer. Located in <?php echo $city_name . ", " . $country_name; ?>, the institution was established in <?php echo $founded_year; ?> and is considered as one of the top institutions in the country!</p>
            <?php } else {?>

            <p>Studying abroad is a one-of-a-lifetime opportunity. Aside from experiencing a new culture, meeting a lot of people, and seeing breathtaking places, studying in a foreign country will give you a global perspective in your chosen field. It will surely boost your career opportunities.</p>

            <p>Now, if you’re looking for your next educational destination, you can consider <?php echo $country_name; ?>. This country is home to <?php echo $institution_title; ?>, and as an international student here, you’ll have the chance to be a part of a global community.</p>

            <p>Founded in <?php echo $founded_year; ?>, <?php echo $institution_title; ?> is a <?php echo $type; ?> in <?php echo $city_name . ", " . $country_name; ?>. As one of the educational institutions in <?php echo $country_name; ?>, studying here can open many avenues for academic and professional growth.</p>
<?php } ?>

<p>Scholarships, grants, and other forms of funding are offered by <?php echo $institution_title; ?> to international students. We’ll discuss them in this article, and you can use them to fulfill your dream of studying abroad without incurring high costs. So, let’s get started!</p>

<?php require get_stylesheet_directory() . '/components/single-institutions/explore-courses.php'; ?>
</div>