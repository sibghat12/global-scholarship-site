<?php
echo do_shortcode('[wpcode id="57138"]');
?>

<?php
/**
 * This is used for ads custom post type
 *
 * @package Avada
 */

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');

}

$siteUrl = home_url();

$program_overview = get_field('program_overview');
$what_you_will_learn = get_field('what_you_will_learn');
$curriculum = get_field('curriculum');
$tuition_and_scholarships = get_field('tuition_and_scholarships');

$adsInsId = get_field('adsInstitution')->ID;

$adsIntCountry = get_field('adsIntCountry', $adsInsId);
$underneath_course_page_description = get_field('underneath_course_page_description', $adsInsId);
$intake_dates = (get_field('intake_dates')) ? get_field('intake_dates') : get_field('intake_dates', $adsInsId);
$short_descriptions = get_field('short_descriptions', $adsInsId);
$accreditations_and_rankings = get_field('accreditations_and_rankings', $adsInsId);

$about_university = get_field('about_university', $adsInsId);
$university_name = get_field('university_name', $adsInsId);
$first_button = $about_university['first_button'];
$second_button = $about_university['second_button'];
$about_university_description = $about_university['about_university_description'];
$logo_link = get_field('logo_link', $adsInsId);
$adsIntLink = get_field('adsIntLink', $adsInsId);
$campus = get_field('campus', $adsInsId);

?>
<?php get_header(); ?>
<!-- <section id="content" -->

<?php while (have_posts()) : ?>

    <?php the_post(); ?>


    <div class="back-color-bcs-section">
        <div class="bcs-section">
            <div class="bcs-part">
                <div class="bcs-logo-part">
                    <div class="logo"><img class="alignnone size-medium wp-image-54639"
                                           src="<?php echo $logo_link['url'] ?> " alt="" width="300"
                                           height="300"/></div>

                    <div class="logo-text">

                        <p><?php echo $short_descriptions['first_description'] ?></p>
                        <p><?php echo $short_descriptions['second_description'] ?></p>

                    </div>
                </div>
                <div class="bcs-title">
                    <h1><?php the_title() ?></h1>
                    <p> <?php echo $underneath_course_page_description ?></p>
                    <p class="bcs-icon"><img class="alignnone size-full wp-image-54650"
                                             src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-1.png' ?>"
                                             alt="" width="1080" height="1080"/>
                        <span class="location-container">
                            <span class="campus-name"><?php echo $campus ?></span>,
                            <span class="campus-country"><?php echo $adsIntCountry ?></span>
                        </span>
                    </p>
                    <p class="bcs-icon degree"><img class="alignnone size-full wp-image-54651"
                                                    src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-2.png' ?>"
                                                    alt="" width="1080"
                                                    height="1080"/><?php echo get_field('course_format') ?></p>
                    <p class="bcs-icon degree"><img class="alignnone size-full wp-image-55144"
                                                    src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-3-1.png' ?>"
                                                    alt="" width="1080" height="1080"/>

                        <span class="intake">
                            <span class="bold">
                            Intake Dates:
                        </span>
                      <span class="intakes-date">
                          <?php echo $intake_dates ?>
                      </span>
                       </span>

                    </p>
                    <a class="bcs-btn" href="#contact-form">APPLY NOW</a>

                </div>
            </div>
        </div>
    </div>


    <div class="bcs-page-links">
        <button id="tab-1" aria-selected="true" aria-controls="tab-panel-1" role="tab" type="button" tabindex="0">Study
            Duration and Intensity
        </button>
        <button id="tab-2" aria-selected="false" aria-controls="tab-panel-2" role="tab" type="button" tabindex="-1">
            Program Overview
        </button>
        <button id="tab-3" aria-selected="false" aria-controls="tab-panel-3" role="tab" type="button" tabindex="-1">
            About University
        </button>
        <button id="tab-4" aria-selected="false" aria-controls="tab-panel-4" role="tab" type="button" tabindex="-1">
            Admission Requirements
        </button>
        <button id="tab-5" aria-selected="false" aria-controls="tab-panel-5" role="tab" type="button" tabindex="-1">
            Curriculum
        </button>
        <button id="tab-6" aria-selected="false" aria-controls="tab-panel-6" role="tab" type="button" tabindex="-1">
            Tuition and Scholarships
        </button>


    </div>

    <div id="tab-panel-1" aria-labelledby="tab-1" role="tabpanel" tabindex="0">
        <div class="Study-Duration-and-Intensity">
            <div class="Study-Duration-title">
                <h2 class="heading-1"><?php echo get_field_object('study_duration_and_intensity')['label'] ?></h2>
            </div>


            <div class="Study-Duration-part">
                <div class="Study-Duration-icons">

                    <img class="alignnone size-full wp-image-55215"
                         src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-5-1-1.png' ?>"
                         alt="" width="810" height="810"/>
                    <p class="Study-Duration-text">LANGUAGE OF INSTRUCTION
                        <span
                            class="text-color"><?php echo get_field('study_duration_and_intensity')['language_of_instruction'] ?></span>
                    </p>

                </div>
                <div class="Study-Duration-icons">

                    <img class="alignnone size-full wp-image-55213"
                         src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-6-1.png' ?>"
                         alt="" width="810" height="810"/>
                    <p class="Study-Duration-text">DELIVERY
                        <span
                            class="text-color"><?php echo get_field('study_duration_and_intensity')['delivery'] ?></span>
                    </p>

                </div>
            </div>
        </div>

        <div class="back-image">
            <div class="bcs-section">
                <?php foreach (get_field('duration') as $durations): ?>

                    <div class="image-flex">
                        <div class="study-duration-box">
                            <p class="study-duration-box-text"><?php echo $durations['duration_part']['label'] ?></p>
                            <p class="study-duration-box-text text-2"><?php echo $durations['duration_part']['description'] ?></p>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </div>
    </div>


    <div id="tab-panel-2" aria-labelledby="tab-2" role="tabpanel" tabindex="-1" hidden>
        <div class="Program-Overview">
            <h2 class="heading-1"><?php echo get_field_object('program_overview')['label'] ?></h2>
            <div class="Program-Overview-inner-text">
                <?php foreach ($program_overview as $value): ?>
                    <p class="Program-Overview-text">
                    <p class="Program-Overview-text">
                        <?php echo $value['paragraphs'] ?>
                    </p>
                <?php endforeach; ?>
                <a class="Program-Overview-btn" href="#contact-form">Learn More</a>
            </div>


        </div>

        <div class="what-will-you-learn">
            <h2 class="heading-1"><?php echo get_field_object('what_you_will_learn')['label'] ?></h2>
            <div class="what-will-part">
                <div class="what-will-image"><img class="alignnone size-full wp-image-55239"
                                                  src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/2-1-1.png' ?>"
                                                  alt="" width="945" height="945"/></div>
                <div class="what-will-text">
                    <h3><?php echo $what_you_will_learn['heading'] ?></h1>
                    <p><?php echo $what_you_will_learn['paragraph'] ?></p>
                </div>
            </div>
        </div>
        <div class="accreditations-and-rankings">
            <h2 class="heading-1">Accreditations and rankings</h2>
            <div class="accreditations-and-rankings-parts">
                <div class="rankings-image"><img class="alignnone size-full wp-image-54641"
                                                 src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/3.png' ?>"
                                                 alt=""
                                                 width="945" height="945"/></div>
                <div class="rankings-text">
                    <h3><?php echo $accreditations_and_rankings['heading'] ?></h3>
                    <p><?php echo $accreditations_and_rankings['paragraph'] ?></p>

                </div>
            </div>
        </div>
    </div>

    <div id="tab-panel-3" aria-labelledby="tab-3" role="tabpanel" tabindex="-1" hidden>
        <div class="about-university">
            <h2 class="heading-1">About the university</h2>
            <h3><?php echo $about_university['university_name'] ?></h3>
        </div>
        <div class="about-university-bg-color">
            <div class="about-university-part">
                <div class="about-uni-part-1">
                    <div class="about-uni-box">
                        <div class="about-uni-image"><img class="alignnone size-full wp-image-54639"
                                                          src="<?php echo $logo_link['url'] ?>"
                                                          alt="" width="945" height="945"/></div>
                        <div class="about-uni-text">

                            <p><?php echo $first_button ?></p>

                        </div>
                    </div>
                    <div class="about-uni-box">
                        <div class="about-uni-image"><img class="alignnone size-full wp-image-55250"
                                                          src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-7-1.png' ?>"
                                                          alt="" width="945" height="945"/></div>
                        <div class="about-uni-text about-bg-color">

                            <p><?php echo $second_button ?></p>

                        </div>
                    </div>
                </div>
                <div class="about-uni-part-2">
                   <p> <?php echo $about_university_description ?> </p>
                </div>
            </div>
        </div>
    </div>


    <div id="tab-panel-4" aria-labelledby="tab-4" role="tabpanel" tabindex="-1" hidden>
        <div class="admission-reqiure">
            <h2 class="heading-1">ADMISSION REQUIREMENTS</h2>
            <div class="admission-reqiure-parts">
                <div class="admission-reqiure-text">
                    <h2 class="admission-reqiure-title"><span class="">General</span> Requirements</h2>
                    <?php foreach (get_field('general_requirements') as $value): ?>
                        <p class="admission-dot-text"><?php echo $value['general_requirements_parts'] ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="admission-reqiure-image"><img class="alignnone size-full wp-image-54648"
                                                          src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/10.png' ?>"
                                                          alt="" width="945" height="945"/></div>
            </div>
        </div>

        <?php if (get_field('english_requirements')): ?>
            <div class="admission-reqiure">
                <div class="admission-reqiure-parts">
                    <div class="admission-reqiure-text">
                        <h1 class="admission-reqiure-title"><span class="">ENGLISH</span> Requirements</h1>
                        <p>International students need to submit at least one of the following tests for Engish
                            proficiency:</p>
                        <?php foreach (get_field('english_requirements') as $value): ?>
                            <p class="admission-dot-text"><?php echo $value['english_requirements_parts'] ?></p>
                        <?php endforeach; ?>


                    </div>
                    <div class="admission-reqiure-image"><img class="alignnone size-fusion-600 wp-image-55252"
                                                              src="<?php echo $siteUrl . '/wp-content/uploads/2023/04/English-Requirements.png' ?>"
                                                              alt="" width="600" height="600"/></div>
                </div>
            </div>


        <?php endif; ?>


        <div class="important-date">
            <h2 class="heading-1"><?php echo get_field_object('important_dates')['label'] ?></h2>
            <div class="important-date-parts">
                <div class="important-date-text">
                    <h2 class="except">Applications Accepted</h2>
                    <h3 class="blue-text"><?php echo get_field('important_dates')['application_accepted_text'] ?></h3>
                    <p class="important-date-para"><?php echo get_field('important_dates')['paragraph_text'] ?></p>

                    <div class="important-date-btn">
                        <div class="date-btn">
                            <p class=""><?php echo get_field('important_dates')['scholarship_application_text'] ?></p>

                        </div>
                        <div class="date-btn-2"><img class="alignnone size-full wp-image-54652"
                                                     src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/icon-3.png' ?>"
                                                     alt="" width="945" height="945"/></div>
                    </div>
                </div>
                <div class="important-date-image"><img class="alignnone size-fusion-600 wp-image-54643"
                                                       src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/5-600x600.png' ?>"
                                                       alt="" width="600" height="600"/>
                    <a class="apply-btn" href="#contact-form">APPLY NOW</a></div>
            </div>
        </div>
    </div>

    <div id="tab-panel-5" aria-labelledby="tab-5" role="tabpanel" tabindex="-1" hidden class="Curriculum">
        <h2 class="heading-1"><?php echo get_field_object('curriculum')['label'] ?></h2>
        <div class="modules">
            <div class="module-part-one">

                <?php foreach ($curriculum as $curriculum_part): ?>


                    <div class="box-content">
                        <div class="module-box">
                            <div class="box-title">

                                <p><?php echo $curriculum_part['curriculum_part']['heading'] ?></p>

                            </div>
                            <ul class="box-text">
                                <?php foreach ($curriculum_part['curriculum_part']['parts'] as $part): ?>
                                    <li><?php echo $part['courses_list'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>


                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <div id="tab-panel-6" aria-labelledby="tab-6" role="tabpanel" tabindex="-1" hidden class="tuition-scholarships">
        <h2 class="heading-1"><?php echo get_field_object('tuition_and_scholarships')['label'] ?></h2>
        <div class="tuition-scholarships-parts">
            <div class="tuition-scholarships-image">


                <img class="alignnone size-fusion-600 wp-image-54649"
                     src="<?php echo $siteUrl . '/wp-content/uploads/2023/03/11-600x600.png' ?>" alt="" width="600"
                     height="600"/>
                <div class="image-text">
                    <p class="image-text-para"><?php echo get_field('tuition_and_scholarships')['text_in_the_circle'] ?></p>

                </div>
            </div>
            <div class="tuition-scholarships-text">
                <div class="tuition-scholarships-box">
                    <div class="tuition-scholarships-box-title">
                        <h2>Tuition and Fees</h2>
                    </div>

                    <div class="tuition-scholarships-box-text">
                        <?php foreach ($tuition_and_scholarships['tuition_and_fees_'] as $fees): ?>
                            <h2><?php echo $fees['heading'] ?></h2>
                            <?php foreach ($fees['fees_parts'] as $price): ?>
                                <p class="box-dot"><span
                                        class=""><?php echo $price['price_label'] ?> </span><?php echo $price['price_value'] ?>
                                </p>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                    <a class="box-btn" href="#contact-form">LEARN MORE</a>

                </div>
            </div>
        </div>
    </div>


    <div id="contact-form" class="contact-form">
        <h2 class="heading-1 contant-title">Get in touch with us</h2>
        <div class="form-field">
            <?php //echo do_shortcode('[contact-form-7 id="57195" title="Get in touch with us"]'); ?>
            <div class="form-area">
                <div class="form-inner">
                    <form method='post' action=''>
                        <div class="form-group-ch">
                            <label for="">What is your Name? <span class="required-icon">*</span></label>
                            <input type="text" class="form-control" placeholder="" value="" required/>
                        </div>
                        <div class="form-group-ch">
                            <label for="">What is your email address? <span class="required-icon">*</span></label>
                            <input type="email" class="form-control" placeholder="" value="" required/>
                        </div>
                        <div class="form-group-ch">
                            <label for="">What is your mobile number? <span class="required-icon">*</span></label>
                            <input type="number" id="mobile_code" class="form-control" placeholder="" name="name"
                                   required>
                        </div>
                        <div class="form-group-ch select-wraper">
                            <label for="">What is your country of citizenship? <span
                                    class="required-icon">*</span></label>

                            <select class="form-select form-control" id="country" name="country">
                                <option></option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Aland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, Democratic Republic of the Congo</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Cote D'Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curacao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and Mcdonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="XK">Kosovo</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libyan Arab Jamahiriya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="AN">Netherlands Antilles</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Reunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="BL">Saint Barthelemy</option>
                                <option value="SH">Saint Helena</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MF">Saint Martin</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="CS">Serbia and Montenegro</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.s.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-ads-ch">Submit</button>
                    </form>
                </div>
            </div>


            <script>
                // -----Country Code Selection
                $("#mobile_code").intlTelInput({
                    initialCountry: "",
                    separateDialCode: true,
                    // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
                });
            </script>

        </div>
    </div>


<?php endwhile; ?>

<!-- </section> -->

<?php get_footer(); ?>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>

    const tabElements = document.querySelectorAll('button[role="tab"]');
    const panelElements = document.querySelectorAll('[role="tabpanel"]');
    let activeIndex = 0;

    // Listen to clicks and key presses on tabs
    tabElements.forEach(function (tab, index) {
        tab.addEventListener("click", function (event) {
            setActiveTab(index);
        });

        tab.addEventListener("keydown", function (event) {
            const lastIndex = tabElements.length - 1;

            if (event.code === "ArrowLeft" || event.code === "ArrowUp") {
                if (activeIndex === 0) {
                    // First element, jump to end
                    setActiveTab(lastIndex);
                } else {
                    // Move left
                    setActiveTab(activeIndex - 1);
                }
            } else if (event.code === "ArrowRight" || event.code === "ArrowDown") {
                if (activeIndex === lastIndex) {
                    // Last element, jump to beginning
                    setActiveTab(0);
                } else {
                    // Move right
                    setActiveTab(activeIndex + 1);
                }
            } else if (event.code === "Home") {
                // Move to beginning
                setActiveTab(0);
            } else if (event.code === "End") {
                // Move to end
                setActiveTab(lastIndex);
            }
        });
    });

    function setActiveTab(index) {
        // Make currently active tab inactive
        tabElements[activeIndex].setAttribute("aria-selected", "false");
        tabElements[activeIndex].tabIndex = -1;

        // Set the new tab as active
        tabElements[index].setAttribute("aria-selected", "true");
        tabElements[index].tabIndex = 0;
        tabElements[index].focus();

        setActivePanel(index);
        activeIndex = index;
    }

    function setActivePanel(index) {
        // Hide currently active panel
        panelElements[activeIndex].setAttribute("hidden", "");
        panelElements[activeIndex].tabIndex = -1;

        // Show the new active panel
        panelElements[index].removeAttribute("hidden");
        panelElements[index].tabIndex = 0;
    }


    //scroll


    $(document).ready(function () {
        $("#mobile_code").intlTelInput({
            initialCountry: "",
            separateDialCode: true,
            // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });
        // Add smooth scrolling to all links
        $("a").on('click', function (event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });
    });


</script>
