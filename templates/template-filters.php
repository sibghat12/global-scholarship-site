<?php
/**
 * Template Name: Sidebar Filter
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

?>


<?php get_header(); 


$scholarships_count = get_published_scholarships_count();

$scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
$degrees_array = $scholarship_details[1]['choices'];
$country_array = $scholarship_details[13]['choices'];
$subject_array = $scholarship_details[12]['choices'];
    
   

$published_countries = array_column($scholarship_details, null, 'name')['published_countries'];
$country_list_for_url = $published_countries['choices'];
$country_list = $country_list_for_url;

$nationalites_array = array_column($scholarship_details, null, 'name')['eligible_nationality'];
$nationalites_array = $nationalites_array['choices'];
   
$scholarships_array = get_all_scholarships();  



?>  

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>


<div class="fusion-row f filter-row">

<div class="sticky-wrapper" >

<div class="mobile-sticky-div">

<div class="card-section-mobile">
<h1 class="mobile-title">   <?php echo $scholarships_count; ?> Scholarships for International Students </h1> 
<div id="sp"> <span class="temp" > | Results:  <b> 1-20 of  <?php echo  $scholarships_count; ?>  </b></span>  </div>
</div>

<div class="filter-toggle-btn"> 
  <img src="<?php echo site_url(); ?>/wp-content/uploads/2023/04/filter-1.png"> Filter     
</div> 

</div>
</div>

<div  id="filter-panell">
    <form  action="<?php echo admin_url('admin-ajax.php'); ?>" method="POST"  id="filter-form">
    <div class="clearfix"> </div>
    <div class="div-mobile" > 
      <p id="previous-btnn"> <img src="<?php  echo site_url(); ?>/wp-content/uploads/2023/04/previous.png"> </p>
      <p id="filter-by"> Filter by </p> 
      <p   class="reset_class" > Reset </p>
    </div>
    <div class="clearfix"> </div>
    

     <p class="text-desktop">Filter by:  </p>
     
<ul class="sidebar-menu" >
    
<div class="screen-one">
<p class="select-label degree-label"> Degrees: </p>
  <select class="selectpicker check-class degree_checkbox" name="degree_checkbox" 
   data-live-search="true" >
       <option  value=""> All Degrees </option>
       <?php foreach ($degrees_array as $key => $degree) { ?>
        <option  value="<?php echo $degree; ?>"> <?php echo  $degree; ?> </option>
        <?php  } ?>
 </select>

<br>

<p class="select-label"> Locations: </p>
  <select class="selectpicker check-class location_checkbox" name="location_checkbox"  data-live-search="true" >
        <option value="">  All Locations </option>
       <?php foreach ($country_list as $key => $country) { ?>
        <option  value="<?php if ($country != "All Nationalities"){ echo $country; } ?>"> <?php echo  $country ?> </option>
        <?php  } ?>
 </select>


<p class="select-label"> Scholarship Type: </p>
<select class="selectpicker check-class scholarship_type" name="scholarship_type"  data-live-search="true">
    <option value="">  All Types </option>
       <option value="Full Funding">  Full Funding </option>
       <option value="Full Tuition">  Full Tuition </option>
       <option value="Partial Funding">  Partial Funding </option>
</select>

<p class="select-label"> Scholarship Deadline: </p>
  <select class="selectpicker check-class application_checkbox" name="application_checkbox"  data-live-search="true">
       <option value=""> All Deadlines   </option>
        <option value="open"> <b>Currently Open  </b> </option>
        <option  value="one-month"> Within 1 month </option>
        <option  value="two-month"> Within 2 months </option>
        <option  value="three-month"> Within 3 months </option>
        <option  value="four-month"> Within 4 months </option>

        <option  value="five-month">Within 5 months</option>
        <option   value="six-month"> Within 6 months </option>
        <option  value="twelve-month"> Within 12 months </option>
</select>
    </div>
   <div class="screen-two" >
   <p class="select-label"> Subjects: </p>
  <select class="selectpicker check-class subject_checkbox" name="subject_checkbox"  data-live-search="true">
       
       <?php foreach ($subject_array as $key => $subject) { ?>
        <option  value="<?php if ($subject != "All Subjects"){echo $subject;} ?>"> <?php echo  $subject ?> </option>
        <?php  } ?>
 </select>
    


    
 <p class="select-label"> Nationalities: </p>
  <select class="selectpicker check-class nationality_checkbox" name="nationality_checkbox"  data-live-search="true">
       
       <?php foreach ($country_array as $key => $country) { ?>
        <option  value="<?php if ($country != "All Nationalities"){echo $country;} ?>"> <?php echo  $country ?> </option>
        <?php  } ?>
 </select>
    
<?php 
    $args = array(
        'post_type' => 'institution',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
    );
    $institutes = new WP_Query($args);
    $institute_ids = $institutes->posts; // Get all post IDs

    echo '<p class="select-label"> Institutions: </p>
      <select class="selectpicker check-class institution_checkbox" name="institution_checkbox"  data-live-search="true" >
            <option value="">  All Institutions </option>';

    // Loop through each post ID and get the title
    foreach ($institute_ids as $institute_id) {
        $title = get_the_title($institute_id);
        echo "<option  value='{$institute_id}'> {$title} </option>";
    }
    
    echo '</select>';
?>

<p class="select-label"> Scholarships: </p>
 <select class="selectpicker check-class scholarship_checkbox" name="scholarship_checkbox" data-live-search="true" >
    <option value="">All Scholarships</option>
    <?php foreach ($scholarships_array as $id => $title) {  ?>
        <option value="<?php echo $title; ?>"><?php echo $title; ?></option>
    <?php } ?>
</select>





</div>

<hr class="filter-hr hide-hr">

 <center><p  id="reset" class="reset-desktop" > RESET FILTERS </p>  <br></center>

</ul>
</form>

</div>

<br>

<?php 
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $ad_args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => 20,
        'post_status' => 'publish',
         //'paged' => $paged
    );
$loop = new WP_Query($ad_args);
?>


<center><button class="show-only-mobile">  Show  <span id="show_number"><?php echo $scholarships_count; ?>  </span> Results </button> </center>

<div  id="scholarship-cards">

<div id="preloader" style="display: none;">
<img src="https://globalscholarships.com/wp-content/uploads/2023/03/Curve-Loading.gif"> </center>
</div>




<div class="card-section">
<h1 class="title-textt" style="display: none;">Search Scholarships for International Students </h1>
</div>
<center>
<?php
$currentURL = $_SERVER['REQUEST_URI'];
$modifiedURL_pre = $currentURL;

if (preg_match('/\/page\/\d+/', $currentURL, $matches)) {
    $pageNumber = intval(str_replace('/page/', '', $matches[0])) - 1;
    if ($pageNumber === 1) {
        $modifiedURL_pre = preg_replace('/\/page\/\d+/', '', $currentURL);
    } else {
        $modifiedURL_pre = preg_replace('/\/page\/\d+/', '/page/' . $pageNumber, $currentURL);
    }
} else {
    $modifiedURL_pre = $currentURL;
}
?>


<a  href="<?php echo $modifiedURL_pre; ?>"  style="display:none;" class="prev-page"  id='prev_posts'> Prev Page </a>


<?php
$currentURL = $_SERVER['REQUEST_URI'];
$modifiedURL = $currentURL;

if (preg_match('/\/page\/\d+/', $currentURL, $matches)) {
    $pageNumber = intval(str_replace('/page/', '', $matches[0])) + 1;
    $modifiedURL = preg_replace('/\/page\/\d+/', '/page/' . $pageNumber, $currentURL);
} else {
    $modifiedURL = rtrim($currentURL, '/') . '/page/2';
}
?>


<a href="<?php echo $modifiedURL; ?>"  style="display: none;" class="next-page"  id='more_posts'> Next Page </a> 


</center>

</div>

<ul class="project-tiles"></ul>
<section id="content" class="col-lg-9"> </section>
</div>







<!-- <script type="text/javascript"> var ajaxurl = "";  </script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

function updatePrevPageLink() {
  var currentURL = window.location.href;
  var modifiedURL;

  if (currentURL.match(/\/page\/\d+/)) {
    modifiedURL = currentURL.replace(/(\/page\/)(\d+)/, function(match, prefix, number) {
      var newNumber = parseInt(number) - 1;
      if (newNumber === 1) {
        return '';
      } else {
        return prefix + newNumber;
      }
    });

    // Remove the '/page/1' entirely if it exists in the modified URL
    if (modifiedURL.endsWith('/page/1')) {
      modifiedURL = modifiedURL.replace(/\/page\/1$/, '');
    }

  } else {
    modifiedURL = currentURL;
  }

  jQuery(".prev-page").attr("href", modifiedURL);
}



 function updateNextPageLink() {
  console.log("aa_from_function");
  var currentURL = window.location.href;
  var modifiedURL;

  if (currentURL.match(/\/page\/\d+/)) {
    modifiedURL = currentURL.replace(/(\/page\/)(\d+)/, function(match, prefix, number) {
      var newNumber = parseInt(number) + 1;
      return prefix + newNumber;
    });
  } else {
    modifiedURL = currentURL.replace(/\/$/, '') + '/page/2';
  }

  jQuery(".next-page").attr("href", modifiedURL);
}


$('#reset').on('click' , function(){
   
changeurl('scholarship-search' , "Welcome");
location.reload();

});


$('.reset_class').on('click' , function(){
   
changeurl('scholarship-search' , "Welcome");
$('#filter-panell').hide();
$('#preloader').css("display" , "block");
$('.card-section').css("display" , "none");
location.reload();

});


function removeLastComma(str) {
   return str.replace(/,(\s+)?$/, '');   
}

// Check for Degree Item
function findValueInArray(value,arr){
  var result = "Doesn't exist";
  for(var i=0; i<arr.length; i++){
    var name = arr[i];
    if(name == value){
      result = 'Exist';
      break;
    }
  }
  return result;
}



function findValueInArray_withformat(value,arr){
  var result = "Doesn't exist";

  console.log(arr);

   value = value.replace(/-/g, ' ');
 
  value = value.charAt(0).toUpperCase() + value.slice(1);
  value = value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
  return letter.toUpperCase();
});

    console.log(value);

for(var i=0; i<arr.length; i++){
    var name = arr[i];
    if(name == value){
      result = 'Exist';
      break;
    }
  }
  return result;

}


var link = "<?php echo  admin_url("admin-ajax.php"); ?>";
var ppp = 20;  // Post per page
var page = 1;

$(document).ready(function(){
reload_data();
});

function reload_data(){



$('.next-page').css("display" , "none");
$('#preloader').css("display" , "block");
$('.card-section').css("display" , "none");
$('.prev-page').css("display" , "none");
$('#prev-posts').css("display" , "none");

var current_page_number = "";

// Extract page number from the URL query parameters
const urlParams = new URLSearchParams(window.location.search);
const pageParam = urlParams.get('page_number');

console.log("Full URL: " + window.location.href);
console.log("Page Parameter: " + pageParam);

if (pageParam && !isNaN(pageParam)) {
    current_page_number = parseInt(pageParam, 10);
}




var degree_label_array = ['masters' , 'bachelors' , 'phd'];
var currently_open_label_array = ['open' , 'one-month' , 'two-month' , 'three-month' , 
'four-month' , 'five-month' , 'six-month' , 'twelve-month'];


var scholarship_php_array = <?php echo json_encode($scholarships_array); ?>;
// Converting JS object to an array
    var scholarship_label_array = $.map(scholarship_php_array, function(value, index){
        return [value];
});


var subject_php_array = <?php echo json_encode($subject_array); ?>;
// Converting JS object to an array
    var subject_label_array = $.map(subject_php_array, function(value, index){
        return [value];
});

var nationalities_php_array = <?php echo json_encode($nationalites_array); ?>;
// Converting JS object to an array
    var nationalities_label_array = $.map(nationalities_php_array, function(value, index){
        return [value];
});





var location_label_array = <?php echo json_encode($country_list_for_url); ?>;
// Converting JS object to an array
    var location_label_array = $.map(location_label_array, function(value, index){
        return [value];
});

var scholarship_type_label_array = ['Full Funding' , 'Full Tuition' , 'Partial Funding'];


pathname_string = window.location.pathname;


var result = pathname_string.substring(1, pathname_string.length-1);

var pathArray = result.split('/');
var removeItem = "scholarship-search";
  pathArray = jQuery.grep(pathArray, function(value) {
  return value != removeItem;
});



if(current_page_number) {

}else {
for (let i = 0; i < pathArray.length; i++) {
  if (typeof pathArray[i] === "string" && isNaN(pathArray[i]) === false) {
     current_page_number = pathArray[i];
    break;
  }
}

}

// Get Data from The URL Pathname and filter records accordingly.  
// Degress: Get degree name from the url path
var degree_value = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray(pathArray[i], degree_label_array);
  if(result=="Exist"){
   degree_value = pathArray[i];
   break;
  }
}

// Currently Open: Get open name from the url path
var currenty_open_array = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray(pathArray[i], currently_open_label_array);
  if(result=="Exist"){
   currenty_open_array = pathArray[i];
   break;
  }
}

// Scholarship Type: Get Schloarhsip Type  from the url path
var type_value = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray_withformat(pathArray[i], scholarship_type_label_array);
  if(result=="Exist"){
   type_value = pathArray[i];
   break;
  }
}


type_value = type_value.replace(/-/g, ' ');
    type_value = type_value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});

// Location Name : Get Location Name from the url path


var location_value = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray_withformat(pathArray[i], location_label_array);
  if(result=="Exist"){
   location_value = pathArray[i];
   break;
  }
}



location_value = location_value.replace(/-/g, ' ');
    location_value = location_value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});

    console.log("After" + location_value);


// Subject Name: Get Subject Name from the url path
var subject_value = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray_withformat(pathArray[i], subject_label_array);
  if(result=="Exist"){
   subject_value = pathArray[i];
   break;
  }
}

// Scholarship Name: Get Scholarship Name from the url path
var scholarship_value = "";
for (let i = 0; i < pathArray.length; i++) {
  result =   findValueInArray_withformat(pathArray[i], scholarship_label_array);
  if(result=="Exist"){
   scholarship_value = pathArray[i];
   break;
  }
}

scholarship_value = scholarship_value.replace(/-/g, ' ');
    scholarship_value = scholarship_value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});

subject_value = subject_value.replace(/-/g, ' ');
    subject_value = subject_value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});
    
// Nationalities: Get Nationality from the url path
var nationality_value = "";
if (pathArray.some(item => item.includes('nationality-'))) {
   

   nationalities_label_array = nationalities_label_array.map(item => 
    "Nationality " + item
   );


    // Using find() method to get the first item that includes "nationality-"
     nationality_value = pathArray.find(item => item.includes('nationality-'));
    
    console.log("English" + nationality_value);
   
    if (nationality_value) {
        const result = findValueInArray_withformat(nationality_value, nationalities_label_array);

        

        if (result == "Exist") {
            console.log("hashim sibi");
            console.log("final " + nationality_value);
            
        }
    }

    pathArray = pathArray.map(item => item.replace(/nationality-/g, ''));



}



nationality_value = nationality_value.replace(/-/g, ' ');
    nationality_value = nationality_value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});


nationality_value = nationality_value.replace("Nationality ", "");






if(degree_value=="masters"){
    degree_value = "Master's";
}if(degree_value=="bachelors"){
    degree_value="Bachelor's";
}if(degree_value=="phd"){
     degree_value = "PhD";
}

var formData = new FormData;

if(currenty_open_array){
setSelectedValue('.application_checkbox', currenty_open_array);
    var open_array = new Array();
    open_array.push(currenty_open_array);
    formData.append("applications" , open_array);
}

if(nationality_value){
setSelectedValue('.nationality_checkbox', nationality_value);
    var nationalityArr = new Array();
    nationalityArr.push(nationality_value);
    formData.append("nationality" , nationalityArr);
}


if(degree_value){
setSelectedValue('.degree_checkbox', degree_value);
    var degreeArr = new Array();
    degreeArr.push(degree_value);
    formData.append("degrees" , degreeArr);
}


if(subject_value){
  setSelectedValue('.subject_checkbox', subject_value);
   var subjectArr = new Array();
   subjectArr.push(subject_value);
   formData.append("subjects" , subjectArr);
}

console.log(scholarship_value);
if(scholarship_value){
  setSelectedValue('.scholarship_checkbox', scholarship_value);
   var scholarshipArr = new Array();
   scholarshipArr.push(scholarship_value);
   formData.append("scholarship" , scholarshipArr);
}


if(location_value){
setSelectedValue('.location_checkbox', location_value);
    var locationArr = new Array();
   locationArr.push(location_value);
   formData.append("locations" , location_value);
}


if(type_value){
setSelectedValue('.scholarship_type', type_value);
var typeArr = new Array(); 
  typeArr.push(type_value);
  formData.append("scholarship_type" , typeArr);
}


if(current_page_number) {
page = current_page_number;
}

formData.append("action" ,"get_data");
if(page === 1){
   formData.append("offset", 0);
}else {
   formData.append("offset", (page - 1) * ppp);
}



formData.append("page_count" , page);
formData.append("ppp" , ppp);
formData.append("checkk" , true);
formData.append("reload" , true);

var check_call = true;

let isEmpty = val => val === "";

// Assuming degree_value, subject_value, etc. are string values
let validValues = [degree_value, subject_value, location_value, type_value, currenty_open_array, nationality_value];
// Convert array values to lowercase, replace spaces with dashes, and remove apostrophes
validValues = validValues.map(value => 
    value.toLowerCase() // Convert to lowercase
        .replace(/ /g, '-') // Replace spaces with dashes
        .replace(/'/g, '') // Remove apostrophes
);



if (isEmpty(degree_value) && isEmpty(subject_value) && isEmpty(location_value) 
    && isEmpty(type_value) && isEmpty(currenty_open_array) && isEmpty(nationality_value)) {

    // Additional check for ["page", "2"] or ["page", any_number]
    if (pathArray.length === 2 && pathArray[0] === 'page' && !isNaN(pathArray[1])) {
        // This is a valid path, your code continues...
    } else if (pathArray.length > 0) {
        console.log("pagenotfound");
        // Redirect to '/page-not-found'
        check_call = false;
      window.location.href = '/page-not-found';
    }
} else {
    // If pathArray has more than one value
    if (pathArray.length > 1) {
        // Check if there's any value in pathArray (ignoring the first one) that doesn't match any of the valid values
        for(let i = 1; i < pathArray.length; i++) {
            // If it's not a valid value and not a page number
            if (!validValues.includes(pathArray[i]) && 
                !(pathArray[i] === 'page' && pathArray[i+1] && !isNaN(pathArray[i+1]))) {
                console.log("pagenotfound due to invalid value in pathArray");
                // Redirect to '/page-not-found'
             check_call = false;
                window.location.href = '/page-not-found';
                break;
            }
            // If current path is 'page' and next is a number, skip next path
            if(pathArray[i] === 'page' && pathArray[i+1] && !isNaN(pathArray[i+1])) {
                i++;
            }
        }
    }
    // Your code continues...
}



$('.prev-page').css("display" , "none");

if(check_call) {
$.ajax({
    url : link,
    data: formData, 
    processData: false,
    contentType: false,
    type : 'post',
      success:function(response){

        $('.title-textt').css("display" , "block");
 
          $('#prev-posts').css("display" , "none");

    if (response.includes('No Scholarships Available')) {
  window.location.href = '/page-not-found'; // Redirect to the custom 404 page or not found URL
}  else {
        


        $("#more_posts").attr("disabled",false);
        $('#preloader').css("display" , "none");
        $('.card-section').css("height" , "0px");
        $('.card-section').html(response);

        
        //changeurl('scholarship-search'+url_update , "Welcome");

        show_pre_or_not();
        var title_text = $('.title-textt').text();
        var numberOnly = parseInt(title_text.match(/\d+/));
        
        if(numberOnly==0){
           $('.prev-page').hide();
               window.location.href = '/page-not-found';
          }else {
            $('.card-section').css("display" , "block");
            $('.card-section').css("height" , "auto");

          }

        

        

         $('.next-page').show();
          $('.temp').hide();
           var  spanElements = $('.ss');
         var targetDiv = $('#sp');

         targetDiv.empty();

  spanElements.each((index, element) => {
    const content = $(element).html();
    targetDiv.append(content); // Add a line break between each content
  });

  if (response.includes('Unfortunately, we don’t keep track of PhD deadlines since they vary a lot by department.')) {
   $('#more_posts').hide();
   $('.next-page').hide();
    }
    
    $('.mobile-title').text(title_text);
    
          
          

         let page_number = Math.ceil(numberOnly / 20);

         console.log("page_number" + page_number + "  - Page:" + page );
         
        if(page_number == page || page_number < page) {
            console.log("shamima");
            $('.next-page').hide();
            $('#more_posts').hide();
          }
         
          
        
           if(numberOnly <= 20){
              console.log("dd+ayaan");
              $('#more_posts').hide();
              $('.desktop_page_count').hide();
              $('.mobile_page_count').hide();
            }else {
                
            }



           if (is_numeric(numberOnly)) { 
              if (numberOnly==0) {
              $('#more_posts').hide();
              $('.next-page').hide();
              $('.prev-page').hide();
              }
            }else {
             $('#more_posts').hide();
              $('.next-page').hide();
           }




    $('#show_number').text(numberOnly);
     
    document.title = title_text;
    document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
          el.setAttribute("content", title_text);
          page++;
    });   

    }
  }
    });
}

}


// Filter Based on the Input Change

var ppp = 20;  // Post per page
var page = 1;

$('select.check-class').change(function() {

 page = 1; // What page we are on.

 console.log(page);

 $("#more_posts").attr("disabled",true);

var check = $(this).is(":checked");
var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

$('#preloader').css("display" , "block");
$('.card-section').css("display" , "none");

$('.prev-page').css("display" , "none");
$('.next-page').css("display" , "none");

var locationArr = new Array();
var loc = $('select.location_checkbox').find(":selected").val();
locationArr.push(loc);

var scholarshipArr = new Array();
var scholarship_idd = $('select.scholarship_checkbox').find(":selected").val();
scholarshipArr.push(scholarship_idd);

var degreeArr = new Array();
var deg = $('select.degree_checkbox').find(":selected").val();
degreeArr.push(deg);

var typeArr = new Array(); 
var typee = $('select.scholarship_type').find(":selected").val();
typeArr.push(typee);

var applicationArr = new Array(); 
var app = $('select.application_checkbox').find(":selected").val();
applicationArr.push(app);


var subjectArr = new Array();
var sub = $('select.subject_checkbox').find(":selected").val();
subjectArr.push(sub);



var institutionArr = new Array();
var inst = $('select.institution_checkbox').find(":selected").val();

institutionArr.push(inst);
if(institutionArr[0]==''){
    
       
}else {
     locationArr =  new Array();
}


console.log(institutionArr);

var nationalityArr = new Array();
var national = $('select.nationality_checkbox').find(":selected").val();
nationalityArr.push(national);


var formData = new FormData;

formData.append("action" ,"get_data");
formData.append("degrees" , degreeArr);
formData.append("scholarship" , scholarshipArr);
formData.append("subjects" , subjectArr);
formData.append("locations" , locationArr);
formData.append("scholarship_type" , typeArr);
formData.append("applications" , applicationArr);
formData.append("institutions" , institutionArr);
formData.append("nationality" , nationalityArr);

if(page===1){
   formData.append("offset" , 0);
}else {
   formData.append("offset" , ( ( page-1 ) * ppp) + 1);
}

formData.append("page_count" , page);
formData.append("ppp" , ppp);

degreeArr = degreeArr.toString().replaceAll(",", '-');
degreeArr = degreeArr.toString().replaceAll("'", "");
degreeArr = degreeArr.toLowerCase();


scholarshipArr = scholarshipArr.toString().replaceAll(" ", "-");
scholarshipArr = scholarshipArr.toLowerCase();


locationArr = locationArr.toString().replaceAll(" ", "-");
locationArr = locationArr.toLowerCase();

subjectArr = subjectArr.toString().replaceAll(" ", "-");
subjectArr = subjectArr.toString().replaceAll(",", "-");
subjectArr = subjectArr.toLowerCase();

nationalityArr = nationalityArr.toString().replaceAll(" ", "-");
nationalityArr = nationalityArr.toString().replaceAll(",", "-");
nationalityArr = nationalityArr.toLowerCase();

typeArr = typeArr.toString().replaceAll(" ", "-");
typeArr = typeArr.toLowerCase();

nationalityArr = nationalityArr.toString().replaceAll(" ", "-");
nationalityArr = nationalityArr.toLowerCase();

    var url_update = "";
    
    //  if(nationalityArr){
    // url_update += "/" + nationalityArr;
    // }
    
     if(nationalityArr){
    url_update +=  "/" + "nationality-"+nationalityArr;
    }

    if(degreeArr){
    url_update += "/" + degreeArr;
    }

    if(scholarshipArr){
    url_update += "/" + scholarshipArr;
    }


    if(locationArr){
    url_update += "/" + locationArr;
    }
    if(subjectArr){
    url_update +=  "/" + subjectArr;
    }
    
    if(typeArr){
    url_update +=  "/" + typeArr;
    }

    if(applicationArr){
    url_update +=  "/" + applicationArr;
    }
   
    
   

    // const filterPanel = document.getElementById('filter-panell');
    // if (window.innerWidth <= 767) {
    //   filterPanel.style.display = 'none';
    // } else {
    //   filterPanel.style.display = 'block';
    // }


$.ajax({
    url : link,
    data: formData, 
    processData: false,
    contentType: false,
    type : 'post',
   success:function(response){
       
        $("#more_posts").attr("disabled",false);
        $('#preloader').css("display" , "none");
        $('.card-section').css("display" , "block");
        $('.card-section').html(response);

        changeurl('scholarship-search'+url_update  , "Welcome");

          show_pre_or_not();
          $('.next-page').show();

          var title_text = $('.title-textt').text();
            $('.mobile-title').text(title_text);
            
            var numberOnly = parseInt(title_text.match(/\d+/));

       let page_number = Math.ceil(numberOnly / 20);

         console.log("page_number" + page_number + "  - Page:" + page );
         
         if(page_number == page || page_number < page) {
            console.log("shamima");
            $('.next-page').hide();
            $('#more_posts').hide();
          }

            $('#show_number').text(numberOnly);
            
            if(numberOnly <= 20){
              $('#more_posts').hide();
              $('.desktop_page_count').hide();
              $('.mobile_page_count').hide();
            }
            
           page_number = parseInt(numberOnly / 20);
          
          if(page_number == page) {
            console.log("shamima");
            $('.next-page').hide();
           }
            

            $('.temp').hide();
             var  spanElements = $('.ss');
            var targetDiv = $('#sp');

        targetDiv.empty();

  spanElements.each((index, element) => {
    const content = $(element).html();
    targetDiv.append(content); // Add a line break between each content
  });

            
           
    // const filterPanel = $('.title-textt');
    // if (window.innerWidth <= 767) {
    //   filterPanel.style.display = 'none';
    // } else {
    //   filterPanel.style.display = 'block';
    // }
       
    if (response.includes('Unfortunately')) {
      console.log("ayaan");
   $('#more_posts').hide();
   $('.next-page').hide();
    }
        
    document.title = title_text;
    document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
          el.setAttribute("content", title_text);

           page++;
    });   

    }
    });
});



$(document).ready(function(){

    $(".sidebar-menu > li.have-children a").on("click", function(i){
          i.preventDefault();
    if( ! $(this).parent().hasClass("active") ){

$(".sidebar-menu li ul").slideUp();
      $(this).next().slideToggle();
      $(".sidebar-menu li").removeClass("active");
      $(this).parent().addClass("active");
    }
    else{
      $(this).next().slideToggle();
      $(".sidebar-menu li").removeClass("active");
        }
    });
});   


(function($){
  $(".keyword-location").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".addto-playlists-location li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);




(function($){
  $(".keyword").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".addto-playlists li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);




(function($){
  $(".keyword1").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".addto-playlists1 li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);



(function($){
  $(".keyword2").on('keyup', function(e) {
    var $this = $(this);
    var exp = new RegExp($this.val(), 'i');
    $(".addto-playlists2 li label").each(function() {
      var $self = $(this);
      if(!exp.test($self.text())) {
        $self.parent().hide();
      } else {
        $self.parent().show();
      }
    });
  });
})(jQuery);
    
function changeurl(url, title ) {
    var new_url = '/' + url;
    window.history.pushState('data', title, new_url);
     
     

   }

</script>




<script type="text/javascript">
    
    var title_text = $('.title-textt').text();
    //document.title = title_text;
    document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
          el.setAttribute("content", title_text);
    });   
   
</script>


<script type="text/javascript">

$(document).on("click", "#prev_posts", function(event){
  
   event.preventDefault(); // Prevent default behavior
    page = page -  2;
  
    if(page==0) {
        page=1;
    }
    
    load_more_button();
});


$(document).on("click", "#more_posts", function(event){
  event.preventDefault(); // Prevent default behavior
     if(page==1){
        page=2;
    }
load_more_button();
});






function load_more_button(){

   
var check = $(this).is(":checked");
var link = "<?php echo  admin_url("admin-ajax.php"); ?>";

$('#preloader').css("display" , "block");
$('.card-section').css("display" , "none");
$('.prev-page').css("display" , "none");
$('.next-page').css("display" , "none");

$('#preloader').css("display" , "block");
$('.card-section').css("display" , "none");

var locationArr = new Array();
var loc = $('select.location_checkbox').find(":selected").val();
locationArr.push(loc);

var degreeArr = new Array();
var deg = $('select.degree_checkbox').find(":selected").val();
degreeArr.push(deg);

var typeArr = new Array(); 
var typee = $('select.scholarship_type').find(":selected").val();
typeArr.push(typee);

var applicationArr = new Array(); 
var app = $('select.application_checkbox').find(":selected").val();
applicationArr.push(app);


var subjectArr = new Array();
var sub = $('select.subject_checkbox').find(":selected").val();
subjectArr.push(sub);



var institutionArr = new Array();
var inst = $('select.institution_checkbox').find(":selected").val();

institutionArr.push(inst);
if(institutionArr[0]==''){
    
       
}else {
     locationArr =  new Array();
}


console.log(institutionArr);

var nationalityArr = new Array();
var national = $('select.nationality_checkbox').find(":selected").val();
nationalityArr.push(national);


var formData = new FormData;

formData.append("action" ,"get_data");
formData.append("degrees" , degreeArr);
formData.append("subjects" , subjectArr);
formData.append("locations" , locationArr);
formData.append("scholarship_type" , typeArr);
formData.append("applications" , applicationArr);
formData.append("institutions" , institutionArr);
formData.append("nationality" , nationalityArr);


if(page === 1){
   formData.append("offset", 0);
}else {
   formData.append("offset", (page - 1) * ppp);
}




formData.append("page_count" , page);
formData.append("ppp" , ppp);


degreeArr = degreeArr.toString().replaceAll(",", '-');
degreeArr = degreeArr.toString().replaceAll("'", "");
degreeArr = degreeArr.toLowerCase();

locationArr = locationArr.toString().replaceAll(" ", "-");
locationArr = locationArr.toLowerCase();

subjectArr = subjectArr.toString().replaceAll(" ", "-");
subjectArr = subjectArr.toString().replaceAll(",", "-");
subjectArr = subjectArr.toLowerCase();

typeArr = typeArr.toString().replaceAll(" ", "-");
typeArr = typeArr.toLowerCase();

    var url_update = "";
    
    // if(degreeArr){
    // url_update += "/" + degreeArr;
    // }
    // if(locationArr){
    // url_update += "/" + locationArr;
    // }
    // if(subjectArr){
    // url_update += "/" + subjectArr;
    // }

  
pathname_string = window.location.pathname;

var updatedString = $.trim(pathname_string.replace("/scholarship-search", ""));
console.log("sibi+ " + updatedString);


var updatedUrl = updatedString.replace(/\/page\/\d+/, "");

if (updatedUrl.endsWith("/")) {
 updatedUrl = updatedUrl.slice(0, -1);
}


 $.ajax({
    url : link,
    data: formData, 
    processData: false,
    contentType: false,
    type : 'post',
    success:function(response){
        page++;
        $("#more_posts").attr("disabled",false);
        $('#preloader').css("display" , "none");
        $('.card-section').css("display" , "block");
        $('.card-section').html(response);
         $(window).scrollTop(0);
         pagee = page - 1;
         
         if(pagee < 2) {
        changeurl("scholarship-search" + updatedUrl, "Welcome"); 
         
         $('.next-page').show();
         }else {
         changeurl("scholarship-search" + updatedUrl + "/?page_number=" + pagee , "Welcome");
         $('.prev-page').show();
         $('.next-page').show(); 
         }
         
         
        updateNextPageLink();
        updatePrevPageLink();
          
        var title_text = $('.card-section .title-textt').text();
         
          $('.mobile-title').text(title_text);
          var numberOnly = parseInt(title_text.match(/\d+/));

            
            let page_number = Math.ceil(numberOnly / 20);

         console.log("page_number" + page_number + "  - Page:" + page );
         page = page -1 ;
          if(page_number == page || page_number < page) {
            console.log("shamima");
            $('.next-page').hide();
            $('#more_posts').hide();
          }
           page= page+1;


           console.log("Page" + page);
         

           if (is_numeric(numberOnly)) { 
              if (numberOnly==0) {
              $('#more_posts').hide();
              $('.next-page').hide();
              }
            }else {
            
           }

      
            if(numberOnly <= 20){
              $('#more_posts').hide();
              $('.desktop_page_count').hide();
              $('.mobile_page_count').hide();
            }else {
                
            }




          $('#show_number').text(numberOnly);
          $('.temp').hide();
         var  spanElements = $('.ss');
         var targetDiv = $('#sp');

  targetDiv.empty();
  spanElements.each((index, element) => {
    const content = $(element).html();
    targetDiv.append(content + '<br>'); // Add a line break between each content
  });

         
           
    // const filterPanel = $('.title-textt');
    // if (window.innerWidth <= 767) {
    //   filterPanel.style.display = 'none';
    // } else {
    //   filterPanel.style.display = 'block';
    // }

    
    document.querySelectorAll('meta[property="og:title"]').forEach(function(el) {
          el.setAttribute("content", title_text);
    });   

    }
    });

}

</script>

<script type="text/javascript">
  $('select').selectpicker();
</script>

<script>

 $(document).ready(function() {
  var filterToggleBtn = $('.filter-toggle-btn');
  var filterPanel = $('#filter-panell');

  $(window).on('resize', function() {
    if ($(this).width() <= 767) {
      filterToggleBtn.show();
    } else {
      filterToggleBtn.hide();
    }
  }).trigger('resize');

  filterToggleBtn.on('click', function() {
    // Scroll to the top of the page
    $('html, body').animate({ scrollTop: 0 }, 'slow');

    // Toggle filter panel and other elements
    $('#filter-panell').toggle(); // Replace 'filter-panel' with the actual ID of your filter panel
    $('.show-only-mobile').toggle();
    $('#scholarship-cards').toggle();
});

 $('.show-only-mobile').on('click', function() {
  $('html, body').animate({ scrollTop: 0 }, 'slow');
  $('#scholarship-cards').show();
  $('.show-only-mobile').hide();
   filterPanel.toggle();
  });

});


document.getElementById('previous-btnn').addEventListener('click', (function() {
    let rotationDegrees = 0;

    return function() {
        //jQuery('#filter-panell').hide();

        rotationDegrees = (rotationDegrees + 180) % 360;
        $("#previous-btnn img").css("transform", "rotate(" + rotationDegrees + "deg)");

        $('.screen-one').toggle();
        $('.screen-two').toggle();
        
        //$('#scholarship-cards').show();
    };
})());






// // Update the next page link when the page loads
// jQuery(document).ready(function() {
//   updateNextPageLink();
// });

// // Update the next page link whenever the browser's URL changes without a page reload
// window.addEventListener("popstate", function() {
//   updateNextPageLink();
// });



//  jQuery(document).ready(function() {
//   var currentURL = window.location.href;
//   var modifiedURL;

//   if (currentURL.match(/\/page\/\d+/)) {
//     modifiedURL = currentURL.replace(/(\/page\/)(\d+)/, function(match, prefix, number) {
//       var newNumber = parseInt(number) - 1;
//       if (newNumber === 1) {
//         return '';
//       } else {
//         return prefix + newNumber;
//       }
//     });

//     if (modifiedURL.endsWith('/page/1')) {
//       modifiedURL = modifiedURL.replace(/\/page\/1$/, '');
//     }
//   } else {
//     modifiedURL = currentURL;
//   }

//   jQuery(".prev-page").attr("href", modifiedURL);
// });
  

  // Update the prev page link when the page loads
jQuery(document).ready(function() {
  // jQuery('.prev-page, .next-page').hide();
  var url = window.location.href;
  

    // Check if the card section is not empty
  // if (jQuery('.card-section').html().trim() !== '') {
  //   jQuery('.prev-page, .next-page').show(); // Show the buttons with classes '.prev-page' and '.next-page'
  // } else {
  //   jQuery('.prev-page, .next-page').hide(); // Hide the buttons with classes '.prev-page' and '.next-page'
  // }



  // Check if the URL contains '?page=' followed by a number
if (url.match(/\?page=\d+/)) {
    jQuery('.prev-page').show(); // Show the link with class '.prev-page'
} else {
    jQuery('.prev-page').hide(); // Hide the link with class '.prev-page'
}


});

function show_pre_or_not(){
  var url = window.location.href;
  

    // Check if the card section is not empty
  // if (jQuery('.card-section').html().trim() !== '') {
  //   jQuery('.prev-page, .next-page').show(); // Show the buttons with classes '.prev-page' and '.next-page'
  // } else {
  //   jQuery('.prev-page, .next-page').hide(); // Hide the buttons with classes '.prev-page' and '.next-page'
  // }
  // Check if the URL contains '/page/' followed by a number

 // Check if the URL contains '?page=' followed by a number
if (url.match(/\?page=\d+/)) {
    jQuery('.prev-page').show(); // Show the link with class '.prev-page'
} else {
    jQuery('.prev-page').hide(); // Hide the link with class '.prev-page'
}

}

        function updateFilterPanelMarginTop() {
            const mobileStickyDiv = document.getElementById('mobile-sticky-div');
            const filterPanel = document.getElementById('filter-panell');

            // Get the height of the mobile-sticky-div
            const mobileStickyDivHeight = mobileStickyDiv.offsetHeight;

            // Set the margin-top of the filter panel based on the height of the mobile-sticky-div
            filterPanel.style.marginTop = mobileStickyDivHeight + 'px';
        }

        // Call the function initially to set the margin-top
        updateFilterPanelMarginTop();

        // Update the filter panel margin-top when the window is resized
        window.addEventListener('resize', updateFilterPanelMarginTop);
    </script>


<script type="text/javascript">
  function setSelectedValue(selector, value) {
  // Get the select element
  var selectElement = document.querySelector(selector);
  // Set the value of the select element to the desired value
  selectElement.value = value;
}
</script>




<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();


   

/* Omit closing PHP tag to avoid "Headers already sent" issues. */


