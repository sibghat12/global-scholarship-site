<?php
/**
 * Template Name: Open Courses 
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

?>

<?php get_header(); 

    $countries_array_Ads_INT  = acf_get_fields('group_62533afa917bb');
    $countries_array = array_column($countries_array_Ads_INT, null, 'name')['adsIntCountry'];
    $countries_array = $countries_array['choices']; 
    $countries_array['Europe'] = 'Europe';

    
    
    $degrees_array_Ads  = acf_get_fields('group_6240a27fc5d85');
    $degrees_array = array_column($degrees_array_Ads, null, 'name')['degrees'];
    $degrees_array = $degrees_array['choices']; 
   
    $subjects_array_Ads  = acf_get_fields('group_6240a27fc5d85');
    $subjects_array = array_column($degrees_array_Ads, null, 'name')['ads_subject'];
    $subjects_array = $subjects_array['choices']; 


    $courses_details  = acf_get_fields('group_64c9f01dd1837');
    $courses_subject = array_column($courses_details, null, 'name')['subjects'];
    $ads_subject = $courses_subject['choices'];

    $courses_countries = array_column($courses_details, null, 'name')['countries'];
    $courses_countries = $courses_countries['choices'];

    $params = get_query_info();

    $subject = $params["subject"];
    //$location = $params["location"];
    $degrees = $params["degrees"];
    $country = $params["country"];
    


    $pro_ip_api_key = '2fNMZlFIbNC1Ii8';
    // Get Current Device Data
    $ip_api = file_get_contents('https://pro.ip-api.com/json/'.$_SERVER['REMOTE_ADDR'] . '?key='.$pro_ip_api_key);

    // Data Decoded
    $data = json_decode($ip_api);
 
    // Turn Object into Associative Array
    $data_array = get_object_vars($data);
   
    // Get Country Code to use to get other related content (Courses)
    if($data_array) {
        $country_code = $data_array['countryCode'];
    } else {
        // In case IP API is not working
        $country_code = $_SERVER['GEOIP_COUNTRY_CODE'];
    }

    // Location
    $location = $country_code;
    
    //List of institutions in that country
    $institute_ids_country = get_institution_ids($country);

    if ($country == "europe"){
        $institute_ids_country = array_merge(get_institution_ids("germany"), get_institution_ids("united kingdom"));      
    }

    $location = code_to_country($location);


    if ($location == FALSE) {
        $location_string = "around the World";
    } else {
        $location_string = "from " . $location; 
    }

    $active_institutions = get_active_institutions();

    $excluded = exclude_institutions ($location);

    $excluded_by_tier = exclude_institutions_by_tier($location);
    $excluded = array_merge($excluded, $excluded_by_tier);

    $ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 30,
        'meta_key' => 'tuition_USD',
        'orderby' => "meta_value_num",
        'order' => "DESC",
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
        ),
    );



    
    if(isset($subject) && $subject){
        $ad_args['meta_query'][] = array('key' => 'ads_subject', 'value' => $subject, 'compare' => 'LIKE');
    }

    if(isset($degrees) && $degrees){
        $ad_args['meta_query'][] = array('key' => 'degrees', 'value' => $degrees, 'compare' => 'LIKE');
    }

    if(isset($country) && $country){
        $ad_args['meta_query'][] = array('key' => 'adsInstitution', 'value' => $institute_ids_country, 'compare' => "IN");
    }


        $loop = new WP_Query($ad_args);
        $total_count = $loop->found_posts;

   


    $first = "" . ucwords($degrees) . " ". ucwords($subject) . " Courses ";
    $second = "in " . ucwords($country) . " ";
    $third = "for Students " . $location_string;

    if(isset($country) && $country){
        $text = $first . $second . $third;
    } else {
        $text = $first . $third;
    }
?>  

<div class="opencourse-title-div" style="display:none; max-width:1000px;margin:auto;" >
    <h1> <?php echo $text; ?> </h1>
</div>

<div class="filter-toggle-btn" style=" font-size:18px;padding-top:10px;padding-bottom:10px;" > 
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/filter-sort-fee.png"
 style="padding-right:0px;text-align: center;height: 22px;"> Filter     
 </div> 

<section id="content" class="small-text opencourse-template"   style="width:100% !important;">
        <div id="openCourses" style="max-width: 1000px;margin: auto;">
            <div class="post-content" style="max-width:100%;">
    <div class="toggle-filter"  >           
 <center>
<aside style="width:80%;max-width:1000px;">            
<div class="course-filter" style="display: none;"> 
    
   <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" 
    method="POST" class="filter-wrapper" id="ajax-course-form">
    
   
    
    <div class="filter-boxes-wrap">
        
       <!--  <div class="filter-title">
            Search for Courses:
        </div>  -->       

        <div class="filter-box degree-filter">
            <select name="degree" >
            <option value="">Any Degree</option> 
            <option value="undergraduate" <?php echo $degrees == 'undergraduate' ? 'selected' : ''; ?>>Undergraduate</option> 
            <option value="masters" <?php echo $degrees == 'masters' ? 'selected' : ''; ?>>Master's</option> 
            <option value="mba" <?php echo $degrees == 'mba' ? 'selected' : ''; ?>>MBA</option> 

            </select>

        </div>


        <div class="filter-box subject-filter">
            <select name="subject" >
            <option value="">Any Subject</option>
            <?php
            

              foreach($ads_subject as $sub) { 
                     $sub_value =  str_replace(" ", "-", strtolower($sub));
                 ?>
             <option value="<?php echo $sub_value; ?>" <?php echo $subject == $sub_value ? 'selected' : ''; ?>> 
                <?php echo $sub ?> </option>
              <?php }
             ?>
                            
            </select>

        </div>
        
        <div class="filter-box country-filter">
            <select name="country" >
            <option value="">Any Country</option>
            <?php
            

              foreach($courses_countries as $country_name) { 
                     $country_value =  str_replace(" ", "-", strtolower($country_name));
                 ?>
             <option value="<?php echo $country_value; ?>" <?php echo $country == $country_value ? 'selected' : ''; ?>> 
                <?php echo $country_name ?> </option>
              <?php }
             ?>

            </select>

        </div>
        

         <div class="filter-btn" style="">
    <button  style="height: 47px;" type="submit">Filter</button>

    </div>

    </div>

   

    </form>
</div>
</aside>
</center>
</div>



            
 <div class="clearfix"> </div> 
            
 <div class="sort-by-fee" style="display:none;margin-top:40px;margin-bottom:20px;margin-bottom:20px;">
    <span class="fee-text" style="font-size:14px;font-weight:600;"> Sort by: Tuition Fee 
        


             <img id="flipImage" style="margin-left:5px;border-radius:3px;background: white !important; padding:5px; width:auto;height:27px; box-shadow: 0 0 10px rgba(128, 128, 128, 0.5);" 
     src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fee-sorting-icon.png">



    </span>
    <br>
</div>

<div id="preloader" style=" margin:auto !important;max-width:600px !important;">
<img src="https://globalscholarships.com/wp-content/uploads/2023/03/Curve-Loading.gif"> </center>
</div>


 

<div class="clearfix"></div>

<div class="card-section-new" style="max-width:1000px;margin:auto;padding-top:15px;"> </div>
           
 <div class="clearfix"> </div>
                
 <div class="opencourse-pagination" style="display:none;">
                 <p style="margin-bottom:20px !important;text-align: center !important;"> 
                    <span class="number-bold">1</span> to 
                    <span class="number-bold">10 </span>  of
                    <span class="number-bold">100 </span> 
                 Courses </p> 
               
               <a  class="pagination-button pag-pre"  style="border:1px solid #008ec5;background:transparent;color:blue;padding-left:20px;padding-right:20px;padding-top:5px;padding-bottom:5px;
               width:40px;"> Prev </a>

                <a  class="pagination-button pag-next"  style="border:1px solid #559cc6;background:#559cc6;color:white !important;padding-left:20px;padding-right:20px;padding-top:5px;padding-bottom:5px;
               width:40px;"> Next </a>

            </div>

    
    <?php wp_reset_postdata(); ?>
    
    
<div class="feature-course-section">
        
  
    <div  class="feature-course-div">

   <div class="col-md-8" style="margin-top:10px;">
        <h2> Feature your <span class="courses-text-color"> Courses </span></h2>
        <p style="line-height: 28px !important;"> If you want to feature courses on our website for your institution, please contact us at:
         <br>
        <a style="font-weight:600;color:#626262 !important;" href="mailto:partnerships@globalscholarships.com"> partnerships@globalscholarships.com </a>
        </p>
   </div>

    <div class="col-md-4 " style="margin-top:-10px;">
        <img src="<?php echo site_url(); ?>/wp-content/uploads/2023/07/image.png">
    </div>

</div>
</div>



</section>



            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

var currentPage = 1;
var adsPerPage = 30;
var openCourseCount = 0;
var hasBeenClicked = false;
jQuery( document ).ready( function($){
     
   reload_data();

    $(document).on('click', '.ad-read-more', function (e) {
        $(this).siblings(".line-clamp-3").removeClass('line-clamp-3');
        e.preventDefault();
        $(this).addClass("display-none-text");
        $(this).siblings(".ad-read-less").removeClass('display-none-text');        
    });

    $(document).on('click', '.ad-read-less', function (e) {
        $(this).siblings(".description").addClass('line-clamp-3');
        e.preventDefault();
        $(this).addClass("display-none-text");
        $(this).siblings(".ad-read-more").removeClass('display-none-text');        
    });
                      
});    
    

jQuery('.fusion-search-field input').attr('placeholder', 'Search for Courses');

function adjustHeight() {
    
    if (window.matchMedia("(min-width: 991px)").matches) {
        var height_col_md_4 = jQuery('.col-md-4').height();
        var height_col_md_8 = jQuery('.col-md-8').height();

        console.log(height_col_md_8);

        var elementId = 'disclaimerr';
        var element = document.getElementById(elementId);

        if (element && element.innerText.trim().length > 0) {
            console.log("ddfinal");
            var max_height = Math.max(height_col_md_4, height_col_md_8);

            // Add 15px extra height to the col-md-8 div
            jQuery('.col-md-4').height(max_height+10);
            jQuery('.col-md-8').height(max_height + 10);
        } else {
            console.log('The element does not have text or is empty.');
            var max_height = Math.max(height_col_md_4, height_col_md_8);

            // Reset the height of both divs to the same height
            jQuery('.col-md-4').height(max_height);
            jQuery('.col-md-8').height(max_height);
        }
    } else {
        // Optional: Reset to automatic height when viewport is less than 991px
        jQuery('.col-md-4').height('auto');
        jQuery('.col-md-8').height('auto');
    }
}


  jQuery(window).on('load', function() {
    // Update on window resize
    jQuery(window).resize(adjustHeight);
  });

  

 jQuery(document).ready(function() {
 adjustHeight();
  var filterToggleBtn = jQuery('.filter-toggle-btn');
  var filterPanel = jQuery('.toggle-filter');
  filterToggleBtn.on('click', function() {
  filterPanel.toggle();
 });

});


jQuery(function() {
    var tooltips = jQuery('[title]').tooltip({
        position: {
            my: 'center bottom',
            at: 'center top-0',
        },
        tooltipClass: "custom-tooltip-styling",
        show: null,
        hide: { effect: "" },
        open: function(event, ui) {
            ui.tooltip.animate({ top: ui.tooltip.position().top - 4 }, "fast" );
        }
    });
});



jQuery(document).ready(function($) {
    // Using event delegation for dynamic content
    $(document).on('click', '.read-more', function(event) {
        event.preventDefault();
        event.stopPropagation();

        // Assuming '.card' class wraps each card. Adjust the class name based on your actual HTML structure.
        var card = $(this).closest('.card'); 

        var short = $(this).parent(); // Adjust if the short content is not the direct parent
        var full = short.next(); // Adjust based on your actual structure

        $(short).hide();
        $(full).show();

        if (window.innerWidth > 991) {
            // Assuming each card contains its own .col-md-8 and .col-md-4. Adjust these selectors based on your actual HTML structure.
            var colMd8 = card.find('.col-md-8');
            var colMd4 = card.find('.col-md-4');

            var fullHeight = $(full).height();

            // Adjust heights based on the full div's height
            if (fullHeight > 140) {
                colMd8.height('370');
                colMd4.height('370');
            } else if (fullHeight > 100) {
                colMd8.height('320');
                colMd4.height('320');
            } else if (fullHeight > 70) {
                colMd8.height('280');
                colMd4.height('280');
            } else {
                colMd8.height('250');
                colMd4.height('250');
            }

            card.find('.funded-line').css('position', 'absolute').css('bottom', '10px');
            colMd4.css('border-left', '1px solid #77a6c9');
            card.find('.annual-tuition-div').css({'position': 'absolute', 'bottom': '0px', 'left': '0px'});
        }
    });
});


function adjustHeight_disclaimer() {
    jQuery('.course-card-new').each(function() {
        var row = jQuery(this);
        var col_md_4 = row.find('.col-md-4');
        var col_md_8 = row.find('.col-md-8');
        var disclaimerrElement = col_md_8.find('#disclaimerr');

        if (disclaimerrElement.length && disclaimerrElement.text().trim().length > 0) {
            var max_height = Math.max(col_md_4.height(), col_md_8.height()) + 15;
            col_md_4.css('height', max_height + 'px');
            col_md_8.css('height', max_height + 'px');
        }
    });
}

// Call the adjustHeight function when the document is ready
jQuery(document).ready(function($) {
    adjustHeight_disclaimer();
});

// Optional: Recalculate heights when the window is resized (if needed)
jQuery(window).resize(function() {
    adjustHeight_disclaimer();
});

function readLess(){
    jQuery('#short').show();
    jQuery('#full').hide();
}

</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        
<script>
 


    // jQuery('.card-section-new').css("display" , "none");
    // jQuery('#preloader').css("display" , "block");
    // jQuery.ajax({
    //     url: '<?php echo admin_url('admin-ajax.php'); ?>',
    //     type: 'POST',
    //     data: {
    //         'action': 'toggle_order',
    //         'order': order
    //     },
    //     success: function(response) {
    //         jQuery('#preloader').css("display" , "none");
    //         // Replace the content of your cards section with the response
    //         jQuery('.card-section-new').css("display" , "block");
    //         jQuery('.card-section-new').html(response);
    //     }
    // });


</script>      

<script>

// Function to Remove the Comma

function removeLastComma(str) {
   return str.replace(/,(\s+)?$/, '');
}
// Check for Degree Item
function findValueInArray(value, arr) {
   var result = "Doesn't exist";
   for (var i = 0; i < arr.length; i++) {
      var name = arr[i];
     console.log("aray " + name);
     console.log("value " + value);
      if (name == value) {
         result = 'Exist';
         break;
      }
   }
   return result;
}


var reload = false;

function findValueInArray_withformat(value, arr) {
    var result = "Doesn't exist";
    for (var i = 0; i < arr.length; i++) {
        // Convert each array element to lowercase, replace spaces with hyphens, and remove special characters
        var name = arr[i].toLowerCase().replace(/\s/g, '-').replace(/'/g, '');
        if (name === value) {
            result = 'Exist';
            break;
        }
    }
    return result;
}

function isValidPathElement(element, array) {
    return findValueInArray_withformat(element, array) === "Exist";
}

function setSelectedValue(selector, value) {
    var selectElement = document.querySelector(selector);
    var transformedValue = value.toLowerCase().replace(/\s/g, '-').replace(/'/g, '');
    selectElement.value = transformedValue;
}

 
function loadCourses(degree_value, country_value, subject_value, adminAjaxUrl, adsPerPage, currentPage , reload) {

    jQuery('.card-section-new').css("display", "none");
    jQuery('#preloader').css("display", "block");
      
    currentOrder = getCurrentOrder(); 
     
    var formData = new FormData();
    if(country_value) {
        formData.append('country', country_value);
    } if(degree_value) {
        formData.append('degree', degree_value);
    } if(subject_value) {
      formData.append('subject', subject_value);  
    } 
    formData.append("action", "load_courses");

     formData.append("page", currentPage);
     formData.append("order", currentOrder);
    
    

    url_update = "";

    if(degree_value){
    degree_value = degree_value.replace(/\s+/g, '-').toLowerCase();
    url_update +=  "/" + degree_value;
    }

    if(country_value){
    country_value = country_value.replace(/\s+/g, '-').toLowerCase();
    url_update +=  "/" + country_value;
    }

    if(subject_value){
    subject_value = subject_value.replace(/\s+/g, '-').toLowerCase();
    url_update +=  "/" + subject_value;
    }

    // Extract page number from the URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const pageParam = urlParams.get('pages');
     
    

    jQuery.ajax({
        url: adminAjaxUrl,
        data: formData,
        processData: false,
        contentType: false,
        type: 'post',
        success: function(response) {

            jQuery('#preloader').css("display", "none");
            var $response = jQuery('<div>').html(response);
            var openCourseTitle = $response.find('.opencourse-ajax-title').text();
            openCourseCount = $response.find('.opencourse-ajax-count').text();
            
           
            jQuery('.opencourse-title-div h1').text(openCourseTitle);
            $response.find('.opencourse-ajax-title, .opencourse-ajax-count').remove();

            jQuery('.card-section-new').css("display", "block").html($response.html());
            
             $('.course-filter').css("display" , "block");
             $('.opencourse-title-div').css("display" , "block");
             $('.sort-by-fee').css("display" , "block");
             $('.opencourse-pagination').css("display" , "block");
             
             

            var totalPages = Math.ceil(openCourseCount / adsPerPage);

            if(currentPage == totalPages ) {
             jQuery('.pag-next').hide();
           } else {
            jQuery('.pag-next').show();
           }
           
           if(currentPage > 1) {
            jQuery('.pag-pre').show();
           }

            
             if (openCourseCount <= 30) {
                 jQuery('.opencourse-pagination').hide();
               }

                if(pageParam) {
               // changeurl("opencourses"  + url_update + "/?pages=" + pageParam);
               } else {
               //  changeurl("opencourses"  + url_update);
               }

                           
               var startNumber, endNumber;

if (currentPage == 1) {
    startNumber = 1;
} else {
    startNumber = (currentPage - 1) * adsPerPage + 1;
}

// Calculate the end number, making sure it does not exceed openCourseCount
endNumber = currentPage * adsPerPage;
if (endNumber > openCourseCount) {
    endNumber = openCourseCount;
}

// Update the text in the spans
jQuery('.opencourse-pagination .number-bold').first().text(startNumber);
jQuery('.opencourse-pagination .number-bold').eq(1).text(endNumber);
jQuery('.opencourse-pagination .number-bold').last().text(openCourseCount);



        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            jQuery('.card-section-new').html("<p>Sorry, there was a problem loading the content.</p>");
        }
    });
}




function reload_data() {
   
     

    $('#preloader').css("display" , "block");
    
    // Extract page number from the URL query parameters
    const urlParams = new URLSearchParams(window.location.search);
    const pageParam = urlParams.get('pages');
    
    const subject_query = urlParams.get('subject');
    const degree_query = urlParams.get('degrees');
    const country_query = urlParams.get('country');
    
    if(pageParam) {
    currentPage = pageParam;
    jQuery('.pag-pre').show();
    } else {
         jQuery('.pag-pre').hide();
         reload = true;
         
    }

    var pathname_string = window.location.pathname;
    var result = pathname_string.substring(1, pathname_string.length-1);
    var pathArray = result.split('/').filter(value => value !== "opencourses");

    var countries_array_js = convertPhpArrayToJson(<?php echo json_encode($countries_array); ?>);
    var degrees_array_js = convertPhpArrayToJson(<?php echo json_encode($degrees_array); ?>);
    var subjects_array_js = convertPhpArrayToJson(<?php echo json_encode($subjects_array); ?>);

    if (!isValidPath(pathArray, countries_array_js, degrees_array_js, subjects_array_js)) {
        window.location.href = '/404';
        return;
    } else {
        $('.card-section-new').css("display" , "block");
        $('#preloader').css("display" , "none");
    }

    var country_value = getValueFromPath(pathArray, countries_array_js);
    var degree_value = getValueFromPath(pathArray, degrees_array_js);
    var subject_value = getValueFromPath(pathArray, subjects_array_js);
   
if (!country_value && country_query) {
    country_value = country_query;
}
if (!degree_value && degree_query) {
    degree_value = degree_query;
}
if (!subject_value && subject_query) {
    subject_value = subject_query;
}
     

    country_value = formatValue(country_value);
    degree_value = formatValue(degree_value);
    subject_value = formatValue(subject_value);

    

    if(degree_value=="masters") {
    degree_value = "Master's";
    } if(degree_value=="bachelors") {
    degree_value="Bachelor's";
    }

      if(degree_value){
    degree_input = degree_value.replace(/\s+/g, '-').toLowerCase();
     $('.degree-filter select').val(degree_input);
    }

    if(country_value){
    country_input = country_value.replace(/\s+/g, '-').toLowerCase();
     $('.country-filter select').val(country_input);
    }

    if(subject_value){
    subject_input = subject_value.replace(/\s+/g, '-').toLowerCase();
     $('.subject-filter select').val(subject_input);
    }
    
      
    
    // Example usage
     loadCourses(degree_value, country_value, subject_value, '<?php echo admin_url('admin-ajax.php'); ?>', 
    adsPerPage, currentPage , reload);
     

     }

function formatValue(value) {
    value = value.replace(/-/g, ' ');
    return value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}


function convertPhpArrayToJson(phpArray) {
    return $.map(phpArray, function(value) {
        return [value];
    });
}


function isValidPath(pathArray, countries, degrees, subjects) {
    return pathArray.every(element => 
        isValidPathElement(element, countries) || 
        isValidPathElement(element, degrees) || 
        isValidPathElement(element, subjects)
    );
}

function getValueFromPath(pathArray, array) {
    for (let i = 0; i < pathArray.length; i++) {
        if (isValidPathElement(pathArray[i], array)) {
            return pathArray[i];
        }
    }
    return "";
}



jQuery(document).ready(function($) {

   
    jQuery('.opencourse-pagination a').click(function(e) {
     e.preventDefault();
     
       var totalPages = Math.ceil(openCourseCount / adsPerPage);
       var currentOrder = 'DESC';
       var direction = jQuery(this).text().trim();
       
       currentOrder = getCurrentOrder(); 
       
       // Extract page number from the URL query parameters
       const urlParams = new URLSearchParams(window.location.search);
       const pageParam = urlParams.get('pages');
       if (direction === 'Next' && currentPage < totalPages) {
       
    if (pageParam && !isNaN(pageParam)) {
    currentPage = parseInt(pageParam, 10); 
    currentPage++; 
    }  else {
        currentPage++;
    }
    
    const current_url = new URL(window.location.href);
if (!current_url.pathname.endsWith('/')) {
    current_url.pathname += '/';
}
current_url.searchParams.set('pages', currentPage);
window.history.pushState({}, '', current_url); 

updateURLForPageOne();
    
       
       loadAds(currentPage, currentOrder , totalPages , openCourseCount);
       
        } else if (direction === 'Prev' && currentPage > 1) {
            
    if (pageParam && !isNaN(pageParam)) {
    currentPage = parseInt(pageParam, 10); 
    currentPage--; }
    else {
        currentPage--;
    }
    

    const current_url = new URL(window.location.href);
if (!current_url.pathname.endsWith('/')) {
    current_url.pathname += '/';
}
current_url.searchParams.set('pages', currentPage);
window.history.pushState({}, '', current_url);

updateURLForPageOne();

            loadAds(currentPage, currentOrder ,   totalPages , openCourseCount);
        }
      });




     function loadAds(pageNumber, order , totalPages , total_courses) {
      
       var degreeValue = $('.degree-filter select').val();
       var subjectValue = $('.subject-filter select').val();
       var countryValue = $('.country-filter select').val(); 

     jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
     jQuery('#preloader').css("display" , "block");
     jQuery('.card-section-new').css("display", "none");

    
        
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                'action': 'load_ads',
                'page': pageNumber,
                'order': order, 
                'degree' : degreeValue,
                'subject' : subjectValue, 
                'country' : countryValue
            },
            success: function(response) {
             jQuery('#preloader').css("display" , "none");
            jQuery('.card-section-new').css("display", "block");
            jQuery('.card-section-new').html(response);

        currentPage = pageNumber

        if(currentPage == totalPages ) {
            jQuery('.pag-next').hide();
           } else {
            jQuery('.pag-next').show();
           }

           if(currentPage > 1) {
            jQuery('.pag-pre').show();
           } else {
             jQuery('.pag-pre').hide();
           }
        
                  var startNumber, endNumber;

if (currentPage == 1) {
    startNumber = 1;
} else {
    startNumber = (currentPage - 1) * adsPerPage + 1;
}

// Calculate the end number, making sure it does not exceed openCourseCount
endNumber = currentPage * adsPerPage;
if (endNumber > openCourseCount) {
    endNumber = openCourseCount;
}

// Update the text in the spans
jQuery('.opencourse-pagination .number-bold').first().text(startNumber);
jQuery('.opencourse-pagination .number-bold').eq(1).text(endNumber);
jQuery('.opencourse-pagination .number-bold').last().text(openCourseCount);
                  
        jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
           }
        
        });
}

var order = ""; 


function flipImage() {
    var image = document.getElementById('flipImage');
    image.classList.toggle('flipped');

     hasBeenClicked = true;

    var order = image.classList.contains('flipped') ? 'ASC' : 'DESC';

    var currentPage = 1;
    var adsPerPage = 30;
    var openCourseCount = parseInt(jQuery('.opencourse-pagination .number-bold').last().text(), 10);

    const url = new URL(window.location.href);
    const pageParam = parseInt(url.searchParams.get('pages'), 10);
   
    if (pageParam) {
        url.searchParams.delete('pages');
        window.history.pushState({}, '', url.toString());
    }
    
    var totalPages = Math.ceil(openCourseCount / adsPerPage);
    var currentOrder = '';
    currentOrder = getCurrentOrder(); 
    
    loadAds(currentPage, currentOrder , totalPages , openCourseCount);
}

document.getElementById('flipImage').addEventListener('click', flipImage);

});



jQuery(document).ready(function($) {
    $('#ajax-course-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
       
    // currentPage = 1;
    // const urlParams = new URLSearchParams(window.location.search);
    // const url = new URL(window.location.href);
    // const pageParam = parseInt(url.searchParams.get('pages'), 10);
   
    currentPage = 1;
        const url = new URL(window.location.href);
        url.search = ''; // Clear all query parameters

        window.history.pushState({}, '', url.pathname); // Update the URL without reloading the page


   let subject_value, degree_value, country_value;


    var selectDegreeValue = $('.degree-filter select').val() || null;
    var selectSubjectValue = $('.subject-filter select').val() || null;
    var selectCountryValue = $('.country-filter select').val() || null;
    

    // Fallback to URL parameters if select values are not provided
    // subject_value = selectSubjectValue || urlParams.get('subject');
    // degree_value = selectDegreeValue || urlParams.get('degrees');
    // country_value = selectCountryValue || urlParams.get('country');

    subject_value = selectSubjectValue;
    degree_value = selectDegreeValue;
    country_value = selectCountryValue;


    loadCourses(degree_value, country_value, subject_value, '<?php echo admin_url('admin-ajax.php'); ?>', adsPerPage, currentPage, reload);
    
    });
});

function changeurl(url, title ) {
    var new_url = '/' + url;
    window.history.pushState('data', title, new_url);
}

 // function getCurrentOrder() {
 //        return jQuery('#flipImage').hasClass('flipped') ? 'ASC' : 'DESC';
 //    }



function getCurrentOrder() {
    // Check if the image has been clicked at least once
    if (!hasBeenClicked) {
        return ""; // Return an empty string if not clicked
    } else {
        // Return 'ASC' if the 'flipped' class is present, 'DESC' otherwise
        return jQuery('#flipImage').hasClass('flipped') ? 'ASC' : 'DESC';
    }
}




// Function to update the URL
function updateURLForPageOne() {
    const url = new URL(window.location.href);
    const currentPage = parseInt(url.searchParams.get('pages'), 10);

    // Check if currentPage is 1, and if so, remove the 'pages' parameter
    if (currentPage === 1) {
        $('.pag-pre').hide();

        url.searchParams.delete('pages');
        window.history.pushState({}, '', url.toString());
    }
}

// Event listener for popstate event
window.addEventListener('popstate', function() {
    updateURLForPageOne();
});

// Initial call to the function when the page loads

updateURLForPageOne();



</script>


<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();