<?php
/**
 * Template Name: Currently Open Scholarhsip
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th, td {
       
        text-align: left;
        border: 2px solid gray !important;
    }
    
    th {
       
        padding-left:px !important;
        background-color: #f2f2f2;
    }
    
    h2 {
        margin-top: 20px;
    }

    hr {
        background: gray;
    }

   li {
    font-size:15px !important;
    line-height: 18px !important;
}



#example_length {
    margin-bottom:20px;
}
#example {
    margin-bottom:50px;
}
.dataTables_info {
    font-size:18px;
}
.dataTables_paginate a {
    font-size:16px !important;
}

.scholarships-table {
    border:none !important;
        border-left: none !important;
        border-right: none !important;
    }
    .scholarships-table td ,.scholarships-table th {
         border-left: none !important;
         border-top:none !important;
         padding-left:10px !important;
         padding-bottom:20px !important;
         padding-top:10px !important;
        border-bottom: 2px solid gray !important;
        width:25% !important;

    }

  .scholarships-table tr:last-child td {
    border-bottom: none !important;
}

.scholarships-table tr:last-child {
    border-bottom: none !important;
}


.dataTables_filter {
    margin-bottom:30px !important;
}

.filter-boxes-wrap {
   justify-content: center !important;
}

@media screen and (max-width: 767px) {
   .page-template-template-currently-open-scholarship .filter-box{
       min-width:450px !important;
   }
}

@media screen and (max-width: 600px) {
   .page-template-template-currently-open-scholarship .filter-box{
       min-width:350px !important;
   }

   

}

@media screen and (max-width: 400px) {
   .page-template-template-currently-open-scholarship .filter-box{
       min-width:270px !important;
   }
}



@media only screen and (max-width: 800px) {
.dtr-control {
    width:50% !important;
    padding-left:20px !important;
}

#example {
    width:96% !important;
}

td ,td a  { font-size:12px !important; }

}

table.dataTable>tbody>tr.child span.dtr-title {
    min-width:100% !important;
}








</style>




<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

<!-- Responsive JS -->
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>







<?php get_header();

$scholarship_details  = acf_get_fields('group_62ca6e3cc910c');


    
    
$published_countries = array_column($scholarship_details, null, 'name')['published_countries'];
$country_list = $published_countries['choices'];



// Get the values from the ACF fields
$acf_country = get_field('country');

$intro = get_field('intro');
$conclusion = get_field('conclusion');

?>

<h1 style="font-size:36px;padding-bottom:20px;text-align:center;"> <?php single_post_title(); ?> </h1>

<div style="margin-bottom:30px;">
<?php echo $intro; ?>
</div>


<section id="content" class="small-text opencourse-template"   style="margin-bottom:30px;width:100% !important;">
        <div id="openCourses" >
            <div class="post-content" style="max-width:100%;">
    <div class="toggle-filterr"  >           
 <center>
<aside style="width:60%;max-width:1000px;">            
<div class="course-filter"> 
    
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>"  style="margin-top:10px;width:100%;" method="POST" class="filterr-wrapper">
    
    <input type="hidden" name="action" value="course_form">
    <div class="filter-boxes-wrap">
        
       <!--  <div class="filter-title">
            Search for Courses:
        </div>  -->       

        <div class="filter-box degree-filter">
            <select class="check-class" name="degree" >
            <option value=""> Any Degree </option> 
            <option value="Bachelor's"> Bachelor's </option>
            <option value="Master's"> Master's </option>
            

            </select>

        </div>
        
        <input type="hidden" value="<?php echo $acf_country; ?>" id="acf_country">

        <div class="filter-box subject-filter">
            <select class="check-class" name="type" >
            <option value="">Any Type</option>
            <option value="Full Funding"> Full Funding </option>  
            <option value="Full Tuition"> Full Tuition </option> 
            <option value="Partial Funding"> Partial Funding </option>     
            </select>

        </div>
     <?php    if ($acf_country == 'All') { ?>
        <div class="filter-box country-filter">
            <select class="check-class" name="country" >
            <option value="All">Any Country</option>
            <?php foreach($country_list as $country) { ?>
            <option value="<?php echo $country; ?>"> <?php echo $country; ?> </option>
            <?php  } ?>

            </select>

        </div>

    <?php } ?>
        

         <div class="filter-btn" style="">
    <button  style="height: 47px;" id="filter-scholarship">Filter</button>

    </div>

    </div>

   

    </form>
</div>
</aside>
</center>
</div>



            
            
               
                

    

    
    
</section>


<section>
    
<div id="preloader" style="width:100%;margin:auto;display: none;">
<center><img style="margin:auto;width:40% !important;" src="https://globalscholarships.com/wp-content/uploads/2023/03/Curve-Loading.gif"> </center>
</div>

    <div id="ajax-response">
        
    </div>

</section>


</div>
  



<script type="text/javascript">
   function getScholarshipsData(degree, country, type, acf_country) {
    $("#preloader").css('display', 'block');
   $('#ajax-response').css('display' , 'none');
    var link = "<?php echo admin_url('admin-ajax.php'); ?>";
    var formData = new FormData();

    formData.append("action", "get_scholarships_ajax");
    formData.append("degree", degree);
    formData.append("country", country);
    formData.append("type", type);
    formData.append("acf_country", acf_country);

    $.ajax({
        url: link,
        data: formData,
        processData: false,
        contentType: false,
        type: 'post',
        success: function(response) {
            $("#more_posts").attr("disabled", false);
            $('#preloader').css("display", "none");
            $('.card-section').css("display", "block");
            $('#ajax-response').css('display' , 'block');
            $('#ajax-response').html(response);

   
   $(document).ready(function() {
    $('#example').DataTable({
        responsive: true
    });
});



        }
    });
}

$(document).ready(function() {
    var defaultDegree = ""; // Default value for degree
    var defaultCountry = "All"; // Default value for country
    var defaultType = ""; // Default value for type
    var acf_country = "<?php echo $acf_country; ?>";
   console.log(acf_country);
    // Set the default values in the select elements
    $('select[name="degree"]').val(defaultDegree);
    $('select[name="country"]').val(defaultCountry);
    $('select[name="type"]').val(defaultType);


    // Get the default data on page load
    getScholarshipsData(defaultDegree, defaultCountry, defaultType, acf_country);

    // Event handler for select change
    $('.check-class').change(function() {

        var degree = $('select[name="degree"]').val();
        var country = $('select[name="country"]').val();
        var type = $('select[name="type"]').val();
        var acf_country = "<?php echo $acf_country; ?>";

        console.log(acf_country);


        console.log(degree);
        console.log(type);
        console.log(country);

        getScholarshipsData(degree, country, type, acf_country);
    });

    $('#filter-scholarship').click(function(event) {
    event.preventDefault(); // Prevent the default behavior

    var degree = $('select[name="degree"]').val();
    var country = $('select[name="country"]').val();
    var type = $('select[name="type"]').val();
    var acf_country = "<?php echo $acf_country; ?>";
   console.log(acf_country);
    console.log(degree);
    console.log(type);
    console.log(country);

    getScholarshipsData(degree, country, type, acf_country);
});


});



</script>



<div style="margin-top:70px !important">
<?php echo $conclusion; ?>
</div>

<!-- <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#example').DataTable();
    




    });
</script> -->

<?php get_footer(); ?>