<?php

// filter
function institutions_where( $where ) {
    
    $where = str_replace("meta_key = 'admission_deadlines_$", "meta_key LIKE 'admission_deadlines_%", $where);

    return $where;
}

include ('functions/scholarships-functions.php'); 

add_filter('posts_where', 'institutions_where');

function add_datatables_scripts() {
    $page_template_slug = get_page_template_slug();
    if ($page_template_slug != 'templates/template-deadlines.php') {
        return;
    }

    wp_enqueue_style('deadline_bootstrap_css', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.css');
    wp_enqueue_style( 'deadline_datatables-css', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.css');
    wp_enqueue_script( 'deadline_datatables-js', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.js', array('jquery'), '1.10.25', true );

    wp_enqueue_script( 'deadlines-js',  get_stylesheet_directory_uri(). '/assets/deadlines.js', array('jquery', 'deadline_datatables-js'), '1.10.25', true );
    
}
add_action( 'wp_enqueue_scripts', 'add_datatables_scripts' );

// BOOTSTRAP For Accordion in Articles By Topics
function enqueue_bootstrap_scripts() {  
    $page_template_slug = get_page_template_slug();
    if ($page_template_slug != 'templates/template-articles-by-topic.php') {
        return;
    }
    
    // Check if Current Page is template articles by topic
        wp_enqueue_script( 'bootstrap_javascript',  get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.js', array(), '5.3.0', true );

        wp_enqueue_style('bootstrap_css',  get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.css');
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap_scripts' );



function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [] );

    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('scholarships')) {
        wp_enqueue_script('single-scholarship',  get_stylesheet_directory_uri() . '/assets/single-scholarship.js', array('jquery'), '1.0.0', true);
        wp_localize_script( 'single-scholarship', 'frontendajax', array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));

        
    }
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('institution') || is_singular('scholarships')) {
        wp_enqueue_script('gs-comments',  get_stylesheet_directory_uri() . '/assets/gs-comments.js', array('jquery'), '1.0.0', true);
    }

    wp_enqueue_script('gs_scholarships_update',  get_stylesheet_directory_uri() . '/assets/update-scholarships.js', array('jquery'),
    '1.0.45',
    false );

    
    wp_localize_script( 'gs_scholarships_update', 'my_ajax_object',
      array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
      )
    );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );


function update_scholarships_shortcode() {
    if( is_user_logged_in() &&  current_user_can('administrator') ) {
        return '<button id="update-gs-scholarships">Update Scholarships</button>';
    }
}
add_shortcode('update_scholarships', 'update_scholarships_shortcode');


function avada_lang_setup() {
    $lang = get_stylesheet_directory() . '/languages';
    load_child_theme_textdomain( 'Avada', $lang );

   // wp_enqueue_script('jquery-form'); 
   // wp_enqueue_script('jquery');
    
}


add_action( 'after_setup_theme', 'avada_lang_setup' );



function my_deregister_scripts(){
  wp_dequeue_script('wp-embed');
   wp_dequeue_script('comment-reply');
}

add_action( 'wp_footer', 'my_deregister_scripts' );

add_action( 'wp_enqueue_scripts', 'custom_disable_theme_js' );

function custom_disable_theme_js() {

    
    Fusion_Dynamic_JS::deregister_script('avada-comments');
    Fusion_Dynamic_JS::deregister_script('avada-general-footer');
    Fusion_Dynamic_JS::deregister_script('avada-mobile-image-hover');
    Fusion_Dynamic_JS::deregister_script('avada-quantity');
    Fusion_Dynamic_JS::deregister_script('avada-scrollspy');
    Fusion_Dynamic_JS::deregister_script('avada-select');
    Fusion_Dynamic_JS::deregister_script('avada-sidebars');
    Fusion_Dynamic_JS::deregister_script('avada-tabs-widget');


    
    Fusion_Dynamic_JS::deregister_script('bootstrap-collapse');
    Fusion_Dynamic_JS::deregister_script('bootstrap-modal');
    Fusion_Dynamic_JS::deregister_script('bootstrap-popover');
    Fusion_Dynamic_JS::deregister_script('bootstrap-scrollspy');
    //Fusion_Dynamic_JS::deregister_script('bootstrap-tab'); //Helps with tabs
    Fusion_Dynamic_JS::deregister_script('bootstrap-tooltip');
    //Fusion_Dynamic_JS::deregister_script('bootstrap-transition'); //Helps with transition in the tabs
    
    //Fusion_Dynamic_JS::deregister_script('cssua'); /Helps with flexslider


    
    Fusion_Dynamic_JS::deregister_script('fusion-alert');
    //Fusion_Dynamic_JS::deregister_script('fusion-blog'); // !
    //Fusion_Dynamic_JS::deregister_script('fusion-button'); // !
    Fusion_Dynamic_JS::deregister_script('fusion-carousel');
    Fusion_Dynamic_JS::deregister_script('fusion-chartjs');
    Fusion_Dynamic_JS::deregister_script('fusion-column-bg-image');
    Fusion_Dynamic_JS::deregister_script('fusion-count-down');
    Fusion_Dynamic_JS::deregister_script('fusion-equal-heights');

    //Fusion_Dynamic_JS::deregister_script('fusion-flexslider');
    Fusion_Dynamic_JS::deregister_script('fusion-image-before-after');
    //Fusion_Dynamic_JS::deregister_script('fusion-lightbox'); //Helps with the alignment of posts and loading
    Fusion_Dynamic_JS::deregister_script('fusion-parallax'); // !
    Fusion_Dynamic_JS::deregister_script('fusion-popover');


    Fusion_Dynamic_JS::deregister_script('fusion-recent-posts');
    Fusion_Dynamic_JS::deregister_script('fusion-sharing-box');
    Fusion_Dynamic_JS::deregister_script('fusion-syntax-highlighter');


    //Fusion_Dynamic_JS::deregister_script('fusion-title');
    Fusion_Dynamic_JS::deregister_script('fusion-tooltip');
    //Fusion_Dynamic_JS::deregister_script('fusion-video-bg'); These both help with the loading for index page
    //Fusion_Dynamic_JS::deregister_script('fusion-video-general');
    //Fusion_Dynamic_JS::deregister_script('fusion-waypoints'); Needed for tabs
    


    
    //Fusion_Dynamic_JS::deregister_script('images-loaded'); // ! Helps with infinite scroll
    //Fusion_Dynamic_JS::deregister_script('isotope'); // !! Helps with infinite scroll


    
    Fusion_Dynamic_JS::deregister_script('jquery-appear');
    Fusion_Dynamic_JS::deregister_script('jquery-caroufredsel');
    Fusion_Dynamic_JS::deregister_script('jquery-count-down');
    Fusion_Dynamic_JS::deregister_script('jquery-count-to');
    Fusion_Dynamic_JS::deregister_script('jquery-easy-pie-chart');
    Fusion_Dynamic_JS::deregister_script('jquery-event-move');


    Fusion_Dynamic_JS::deregister_script('jquery-fade'); // !!
    //Fusion_Dynamic_JS::deregister_script('jquery-fitvids'); Helps with homepage video
    Fusion_Dynamic_JS::deregister_script('jquery-fusion-maps');



    Fusion_Dynamic_JS::deregister_script('jquery-hover-flow');
    Fusion_Dynamic_JS::deregister_script('jquery-hover-intent');

    //Fusion_Dynamic_JS::deregister_script('jquery-infinite-scroll'); // !
    //Fusion_Dynamic_JS::deregister_script('jquery-lightbox'); Helps with infinite scroll and image loading

    //Fusion_Dynamic_JS::deregister_script('jquery-mousewheel'); // ! Helps with infinite scroll and image loading
    Fusion_Dynamic_JS::deregister_script('jquery-placeholder');
    Fusion_Dynamic_JS::deregister_script('jquery-request-animation-frame');


    Fusion_Dynamic_JS::deregister_script('jquery-sticky-kit');
    Fusion_Dynamic_JS::deregister_script('jquery-to-top');
    Fusion_Dynamic_JS::deregister_script('jquery-touch-swipe'); // !
    Fusion_Dynamic_JS::deregister_script('jquery-waypoints'); // !


                                                Fusion_Dynamic_JS::deregister_script('lazysizes');
    //Fusion_Dynamic_JS::deregister_script('packery'); // !! Helps with loading images
    Fusion_Dynamic_JS::deregister_script('vimeo-player');  



    //Fusion_Dynamic_JS::deregister_script('jquery-easing');   Helps with image loading homepage
    //Fusion_Dynamic_JS::deregister_script('modernizr'); Helps with image loading homepage
    Fusion_Dynamic_JS::deregister_script('fusion-testimonials');
    Fusion_Dynamic_JS::deregister_script('jquery-cycle'); // !    
//     Fusion_Dynamic_JS::deregister_script('jquery-flexslider'); // !

}

function dequeue_jquery_migrate( $scripts ) {
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
}



/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
    // Remove from TinyMCE
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}


// die();

// add_filter( 'avada_render_blog_post_content', 'your_prefix_excerpt_length', 20, 1);
// function your_prefix_excerpt_length($length) {
//     var_dump($length); die();


// }




function hks_generate_filters_html($atts) {

    // $form_action_url = '';


    $form_action_url = get_home_url();

    $current_category_filter = (isset($_GET['category']) && $_GET['category'] != '') ? $_GET['category'] : '';
    $current_region_filter = (isset($_GET['region']) && $_GET['region'] != '') ? $_GET['region'] : '';
    $current_degree_filter = (isset($_GET['degree']) && $_GET['degree'] != '') ? $_GET['degree'] : '';
    $current_subject_filter = (isset($_GET['subject']) && $_GET['subject'] != '') ? $_GET['subject'] : '';
    $current_opening_date_filter = (isset($_GET['opening_date']) && $_GET['opening_date'] != '') ? $_GET['opening_date'] : '';


    $category_options_html = '';
    $region_options_html = '';
    $degree_options_html = '';
    $subject_options_html = '';
    $opening_date_options_html = '';


    $category_options = array(
        'full_funding' => 'Full Funding',
        'full_tuition' => 'Full Tuition',
        'partial_funding' => 'Partial Funding',
        'no_funding' => 'No Funding',
        
    );
    
    
    $degree_options = array(
        'diploma' => 'Diploma',
        'undergraduate' => 'Undergraduate',
        'masters' => 'Master’s',
        'phd' => 'PhD',
        'md' => 'Doctor of Medicine',

        
    );
    
    

    $region_options = array(
        'united_states' => 'United States',
        'canada' => 'Canada',
        'united_kingdom' => 'United Kingdom',
        'germany' => 'Germany',
        'europe' => 'Europe',
        'australia' => 'Australia',
        'china' => 'China',
        'korea' => 'Korea',
        'middle_east' => 'Middle East',
        'asia' => 'Asia',
        'africa' => 'Africa',
    
    );

    $subject_options = array(

        'business' => 'Business',
        'computer_science' => "Computer Science",
        'data_analytics' => 'Data Analytics',
        'medicine' => 'Medicine',
        'health_related_field' => 'Health Related Field',
        'humanities' => 'Humanities',
        'engineering' => 'Engineering',
        'sciences' => 'Sciences',
    
    );

    $opening_date_options = array(
    
        'Ongoing' => 'ongoing',
        '2 Weeks' => '2_weeks',
        '30_days' => '30 Days',
        '90_days' => '90 Days',
        '180_days' => '180 Days',

    );

    

foreach($category_options as $value => $label) {

    $category_options_html .= sprintf('<option %s value="%s">%s</option>',(($value == $current_category_filter) ? 'selected' : ''),$value, $label);

}
foreach($region_options as $value => $label) {

    $region_options_html .= sprintf('<option %s value="%s">%s</option>',(($value == $current_region_filter) ? 'selected' : ''),$value, $label);

}
foreach($degree_options as $value => $label) {

    $degree_options_html .= sprintf('<option %s value="%s">%s</option>',(($value == $current_degree_filter) ? 'selected' : ''),$value, $label);

}
foreach($subject_options as $value => $label) {

    $subject_options_html .= sprintf('<option %s value="%s">%s</option>',(($value == $current_subject_filter) ? 'selected' : ''),$value, $label);

}
foreach($opening_date_options as $value => $label) {

    $opening_date_options_html .= sprintf('<option %s value="%s">%s</option>',(($value == $current_opening_date_filter) ? 'selected' : ''),$value, $label);

}


$finalOutput = '';

$finalOutput .= ' <div class="custom-search-box"><p class="custom-search-heading">Search Scholarships</p> <form method="GET" action="'.$form_action_url.'" class="filter-wrapper">
<input type="hidden" name="s" value="none" />
<div class="filter-boxes-wrap">
<div class="filter-box category-filter">
<select name="category">
<option value="">Any Scholarship</option> 
'.$category_options_html.'

</select>

</div>

<div class="filter-box region-filter">
<select name="degree" >
<option value="">Any Degree</option> 
'.$degree_options_html.'

</select>

</div>

<div class="filter-box funding-type-filter">
<select name="region">
<option value="">Any Region</option>
'.$region_options_html.'

</select>

</div>

<div class="filter-box deadline-filter">
<select name="subject" >
<option value="">Any Subject</option>
'.$subject_options_html.'

</select>

</div>




</div>

<div class="filter-btn">
<button type="submit">Search</button>

</div>


</form>
</div>
';


return $finalOutput;


}


add_shortcode('hks_generate_filters','hks_generate_filters_html');



function hks_print_filters_markup() {

    if(!is_search()) {
        return;
    }

    echo do_shortcode('[hks_generate_filters]');
    // echo '<h3>Hello</h3>';

}



//add_action('avada_before_main_container','hks_print_filters_markup');



function hks_handle_filter_functions($query) {
    
    
    $sticky_posts = get_option('sticky_posts');
    


    $default_posts_array = array(
        'post_type' => 'post'
    );





    if(isset($_GET['search'])) {
        $query->is_home = false;
        $query->is_search = true;
    }

    if($query->is_search()  && $query->is_main_query() ) {
        // return $query;


        $filter_array_post_meta = array('relation' => 'AND');

        if(isset($_GET['s']) && $_GET['s'] == 'none' ) {
            $query->set('s',null); 
            unset($query->query_vars['s']);
            unset($query->query['s']);

            add_filter('get_search_query',function() {  return 'none'; });
            $query->set('post_type','post'); 

            add_action('avada_override_current_page_title_bar',function () {

                // if(is_search_page()) {

                $output ='<div class="fusion-page-title-bar fusion-page-title-bar-breadcrumbs fusion-page-title-bar-center">
                <div class="fusion-page-title-row">
                    <div class="fusion-page-title-wrapper">
                        <div class="fusion-page-title-captions a">
                                <h1 class="entry-title" data-fontsize="37" data-lineheight="48">Search results for:</h1>
                                <div class="fusion-page-title-secondary">
                                    <div class="fusion-breadcrumbs"><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="https://globalscholarships.com"><span itemprop="title">Home</span></a></span><span class="fusion-breadcrumb-sep">/</span><span class="breadcrumb-leaf">Search: none</span></div>                        
                                </div>                
                        </div>
                    </div>
                </div>
            ';
                echo $output;
            // }
            });
            
        }

        if(isset($_GET['category']) && $_GET['category'] != '') {

            $filter_array_post_meta[] = array(
                'key' => 'any_category',
                'value' => sanitize_text_field($_GET['category']),
                'compare' => 'LIKE'
            );


        }


        if(isset($_GET['degree']) && $_GET['degree'] != '') {

            $filter_array_post_meta[] = array(
                'key' => 'any_region',
                'value' => sanitize_text_field($_GET['degree']),
                'compare' => 'LIKE'
            );

        }



        if(isset($_GET['region']) && $_GET['region'] != '') {

            $filter_array_post_meta[] = array(
                'key' => 'any_fields',
                'value' => sanitize_text_field($_GET['region']),
                'compare' => 'LIKE'
            );

        }


        if(isset($_GET['subject']) && $_GET['subject'] != '') {

            $filter_array_post_meta[] = array(
                'key' => 'any_deadline',
                'value' => sanitize_text_field($_GET['subject']),
                'compare' => 'LIKE'
            );

        }

        if(isset($_GET['opening_date']) && $_GET['opening_date'] != '') {

            $filter_array_post_meta[] = array(
                'key' => 'any_opening',
                'value' => sanitize_text_field($_GET['opening_date']),
                'compare' => 'LIKE'
            );

        }

        if(array_key_exists('meta_query',$query->query_vars)) {
            $filter_array_post_meta = array_merge( $filter_array_post_meta,$query->query_vars['meta_query']);
        }

        if(count($filter_array_post_meta) > 1) {
            $query->set('meta_query', $filter_array_post_meta);
            
        }

        $default_posts_array['order'] = 'DESC';
        $default_posts_array['order_by'] = 'date';        
        $default_posts_array['posts_per_page'] = -1;


        $get_default_posts = new WP_Query($default_posts_array);

        wp_reset_postdata();

        $post_ids = array();

        if($get_default_posts->post_count > 0) {

           for($i = 0; $i < count($get_default_posts->posts); $i++) {

                $post_ids[] = $get_default_posts->posts[$i]->ID;

           }

        }

        $query->set('orderby','post__in');
        $query->set('post__in',$post_ids);


        
        return $query;



    }

    // var_dump(json_encode($query->query_vars)); die();
    return $query;



}

//add_filter('pre_get_posts','hks_handle_filter_functions',5,1);


function uscollege_custom_post_types() {
    
    $labels = array(
        'name'              => __( 'AdsINT' ),
        'singular_name'     => __( 'AdsINT' ),
        'add_new'           => __( 'Add New Int' ),
        'add_new_item'      => __( 'Add New Int' ),
        'edit_item'         => __( 'Edit School' ),
        'new_item'          => __( 'Add New School' ),
        'view_item'         => __( 'View School' ),
        'search_items'      => __( 'Search School' ),
        'not_found'         => __( 'No School found' ),
        'not_found_in_trash' => __( 'No School found in trash' )
    );
    $supports = array(
        'title',
        'author',
        'thumbnail',
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'adshool' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'cpt_institution_meta_boxes'
    );
    register_post_type( 'adschool', $args );    
    
    
    $labels = array(
        'name'              => __( 'Ads' ),
        'singular_name'     => __( 'ads' ),
        'add_new'           => __( 'Add New Ads' ),
        'add_new_item'      => __( 'Add New Ads' ),
        'edit_item'         => __( 'Edit Ads' ),
        'new_item'          => __( 'Add New Ads' ),
        'view_item'         => __( 'View Ads' ),
        'search_items'      => __( 'Search Ads' ),
        'not_found'         => __( 'No Ads found' ),
        'not_found_in_trash' => __( 'No Ads found in trash' )
    );
    $supports = array(
        'title',
        'author',
        'thumbnail',
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'ads' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'cities'
    );
    register_post_type( 'ads', $args );
    
        $labels = array(
        'name'              => __( 'Scholarships' ),
        'singular_name'     => __( 'scholarships' ),
        'add_new'           => __( 'Add New Scholarships' ),
        'add_new_item'      => __( 'Add New Scholarships' ),
        'edit_item'         => __( 'Edit Scholarships' ),
        'new_item'          => __( 'Add New Scholarships' ),
        'view_item'         => __( 'View Scholarships' ),
        'search_items'      => __( 'Search Scholarships' ),
        'not_found'         => __( 'No Scholarships found' ),
        'not_found_in_trash' => __( 'No Scholarships found in trash' ),

    );
    $supports = array(
        'title',
        'author',
        'thumbnail',
        'comments'
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'page',
        'rewrite'               => array( 'slug' => 'scholarships' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'show_ui '              => true,  
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'scholarships',
       
    );
    register_post_type( 'scholarships', $args );  
    
    
    $labels = array(
        'name'              => __( 'Institutions' ),
        'singular_name'     => __( 'institutions' ),
        'add_new'           => __( 'Add New Institution' ),
        'add_new_item'      => __( 'Add New Institution' ),
        'edit_item'         => __( 'Edit Institution' ),
        'new_item'          => __( 'Add New Institution' ),
        'view_item'         => __( 'View Institution' ),
        'search_items'      => __( 'Search institutions' ),
        'not_found'         => __( 'No Institution found' ),
        'not_found_in_trash' => __( 'No Institution found in trash' )
    );
    $supports = array(
        'title',
        'author',
        'thumbnail',
        'comments'
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'page',
        'rewrite'               => array( 'slug' => 'institutions' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'cpt_institution_meta_boxes'
    );
    register_post_type( 'institution', $args );
    
    $labels = array(
        'name'              => __( 'City' ),
        'singular_name'     => __( 'cities' ),
        'add_new'           => __( 'Add New City' ),
        'add_new_item'      => __( 'Add New City' ),
        'edit_item'         => __( 'Edit City' ),
        'new_item'          => __( 'Add New City' ),
        'view_item'         => __( 'View City' ),
        'search_items'      => __( 'Search City' ),
        'not_found'         => __( 'No City found' ),
        'not_found_in_trash' => __( 'No City found in trash' )
    );
    $supports = array(
        'title',
        'author',
        'thumbnail',
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'cities' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'cities'
    );
    register_post_type( 'city', $args );  


    

     $labels = array(
        'name'              => __( 'Scholarship Recipient Posts' ),
        'singular_name'     => __( 'Scholarship Post' ),
        'add_new'           => __( 'Add New Post' ),
        'add_new_item'      => __( 'Scholarship Post' ),
        'edit_item'         => __( 'Edit Post' ),
        'new_item'          => __( 'New Post' ),
        'view_item'         => __( 'View Post' ),
        'search_items'      => __( 'Search Post' ),
        'not_found'         => __( 'No Posts found' ),
        'not_found_in_trash' => __( 'No Posts found in trash' )
    );
    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
    );
    
    $args = array(
        'labels'                => $labels,
        'supports'              => $supports,
        'public'                => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'scholarship-posts' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'menu_icon'             => 'dashicons-admin-multisite',
        'register_meta_box_cb'  => 'scholarships_blog'
    );
    register_post_type( 'scholarship_post', $args );


    $labels = array(
        'name'              => _x( 'Scholarship Blog Post Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Scholarship Blog Post Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Scholarship Categories' ),
        'all_items'         => __( 'All Scholarship Categories' ),
        'parent_item'       => __( 'Parent Scholarship Category' ),
        'parent_item_colon' => __( 'Parent Scholarship Category:' ),
        'edit_item'         => __( 'Edit Scholarship Blog Post Category' ),
        'update_item'       => __( 'Update Scholarship Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Scholarship Category Name' ),
        'menu_name'         => __( 'Scholarship Blog Post Categories' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'scholarship-category' ), // Customize the slug as per your requirement
    );

    register_taxonomy( 'scholarship_category', 'scholarship_post', $args ); // Attach taxonomy to scholarship_post




    
}

add_action( 'init', 'uscollege_custom_post_types' );

function scholarships_blog( $post ) {
    // Your meta box code here
}





// add_action('init','hks_test_query_vars');

//Add Query Values 
function add_query_vars_filter( $vars ){
  $vars[] = "subject";
  $vars[] = "university";
  $vars[] = "location";
  $vars[] = "degrees";
  $vars[] = "country";


  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function get_query_info(){

    $s_param_subject       = urldecode( htmlspecialchars ( get_query_var( 'subject' ) ) );
    $s_param_university   = urldecode( htmlspecialchars ( get_query_var( 'university' ) ) );
    $s_param_location      = urldecode( htmlspecialchars ( get_query_var( 'location' ) ) );
    $s_param_degrees      = urldecode( htmlspecialchars ( get_query_var( 'degrees' ) ) );
    $s_param_country      = urldecode( htmlspecialchars ( get_query_var( 'country' ) ) );
    
    $s_param_subject =  str_replace('-', ' ', $s_param_subject);
    $s_param_university =  str_replace('-', ' ', $s_param_university);
    $s_param_location =  str_replace('-', ' ', $s_param_location);
    $s_param_degrees      = str_replace('-', ' ', $s_param_degrees);
    $s_param_country      = str_replace('-', ' ', $s_param_country);
    
    $query_array = array();
    $query_array["subject"] = $s_param_subject;
    $query_array["degrees"] = $s_param_degrees;
    $query_array["university"] = $s_param_university;
    $query_array["location"] = $s_param_location;
    $query_array["country"] = $s_param_country;
    
    return $query_array;
};

function get_institution_ids ($country){
    global $wpdb;
    
    $text = $wpdb->prepare("SELECT post_id FROM wp_postmeta WHERE meta_key = 'adsintcountry' AND meta_value = %s", $country);
    
    $db_queries = $wpdb->get_results($text, ARRAY_A);
    
    $institutions = array();
    foreach ($db_queries as $db_query){
        array_push($institutions, $db_query["post_id"]); 
    };
    
    return $institutions;
    
};

function code_to_country($code){

    $code = strtoupper($code);

$countryList = array(
'AF' => 'Afghanistan',
'AX' => 'Aland Islands',
'AL' => 'Albania',
'DZ' => 'Algeria',
'AS' => 'American Samoa',
'AD' => 'Andorra',
'AO' => 'Angola',
'AI' => 'Anguilla',
'AQ' => 'Antarctica',
'AG' => 'Antigua and Barbuda',
'AR' => 'Argentina',
'AM' => 'Armenia',
'AW' => 'Aruba',
'AU' => 'Australia',
'AT' => 'Austria',
'AZ' => 'Azerbaijan',
'BS' => 'Bahamas',
'BH' => 'Bahrain',
'BD' => 'Bangladesh',
'BB' => 'Barbados',
'BY' => 'Belarus',
'BE' => 'Belgium',
'BZ' => 'Belize',
'BJ' => 'Benin',
'BM' => 'Bermuda',
'BT' => 'Bhutan',
'BO' => 'Bolivia',
'BA' => 'Bosnia and Herzegovina',
'BW' => 'Botswana',
'BV' => 'Bouvet Island',
'BR' => 'Brazil',
'IO' => 'British Indian Ocean Territory',
'VG' => 'British Virgin Islands',
'BN' => 'Brunei',
'BG' => 'Bulgaria',
'BF' => 'Burkina Faso',
'BI' => 'Burundi',
'KH' => 'Cambodia',
'CM' => 'Cameroon',
'CA' => 'Canada',
'CV' => 'Cabo Verde',
'KY' => 'Cayman Islands',
'CF' => 'Central African Republic',
'TD' => 'Chad',
'CL' => 'Chile',
'CN' => 'China',
'CX' => 'Christmas Island',
'CC' => 'Cocos Islands',
'CO' => 'Colombia',
'KM' => 'Comoros',
'CD' => 'Democratic Republic of the Congo',
'CG' => 'Congo',
'CK' => 'Cook Islands',
'CR' => 'Costa Rica',
'CI' => 'Cote d\'Ivoire',
'HR' => 'Croatia',
'CU' => 'Cuba',
'CY' => 'Cyprus',
'CZ' => 'Czech Republic',
'DK' => 'Denmark',
'DJ' => 'Djibouti',
'DM' => 'Dominica',
'DO' => 'Dominican Republic',
'EC' => 'Ecuador',
'EG' => 'Egypt',
'SV' => 'El Salvador',
'GQ' => 'Equatorial Guinea',
'ER' => 'Eritrea',
'EE' => 'Estonia',
'ET' => 'Ethiopia',
'FO' => 'Faroe Islands',
'FK' => 'Falkland Islands',
'FJ' => 'Fiji',
'FI' => 'Finland',
'FR' => 'France',
'GF' => 'French Guiana',
'PF' => 'French Polynesia',
'TF' => 'French Southern Territories',
'GA' => 'Gabon',
'GM' => 'Gambia',
'GE' => 'Georgia',
'DE' => 'Germany',
'GH' => 'Ghana',
'GI' => 'Gibraltar',
'GR' => 'Greece',
'GL' => 'Greenland',
'GD' => 'Grenada',
'GP' => 'Guadeloupe',
'GU' => 'Guam',
'GT' => 'Guatemala',
'GG' => 'Guernsey',
'GN' => 'Guinea',
'GW' => 'Guinea-Bissau',
'GY' => 'Guyana',
'HT' => 'Haiti',
'HM' => 'Heard Island and McDonald Islands',
'VA' => 'Holy See',
'HN' => 'Honduras',
'HK' => 'Hong Kong',
'HU' => 'Hungary',
'IS' => 'Iceland',
'IN' => 'India',
'ID' => 'Indonesia',
'IR' => 'Iran',
'IQ' => 'Iraq',
'IE' => 'Ireland',
'IM' => 'Isle of Man',
'IL' => 'Israel',
'IT' => 'Italy',
'JM' => 'Jamaica',
'JP' => 'Japan',
'JE' => 'Jersey',
'JO' => 'Jordan',
'KZ' => 'Kazakhstan',
'KE' => 'Kenya',
'KI' => 'Kiribati',
'KP' => 'North Korea',
'KR' => 'South Korea',
'KW' => 'Kuwait',
'KG' => 'Kyrgyzstan',
'LA' => 'Laos',
'LV' => 'Latvia',
'LB' => 'Lebanon',
'LS' => 'Lesotho',
'LR' => 'Liberia',
'LY' => 'Libya',
'LI' => 'Liechtenstein',
'LT' => 'Lithuania',
'LU' => 'Luxembourg',
'MO' => 'Macao',
'MK' => 'Macedonia',
'MG' => 'Madagascar',
'MW' => 'Malawi',
'MY' => 'Malaysia',
'MV' => 'Maldives',
'ML' => 'Mali',
'MT' => 'Malta',
'MH' => 'Marshall Islands',
'MQ' => 'Martinique',
'MR' => 'Mauritania',
'MU' => 'Mauritius',
'YT' => 'Mayotte',
'MX' => 'Mexico',
'FM' => 'Micronesia',
'MD' => 'Moldova',
'MC' => 'Monaco',
'MN' => 'Mongolia',
'ME' => 'Montenegro',
'MS' => 'Montserrat',
'MA' => 'Morocco',
'MZ' => 'Mozambique',
'MM' => 'Myanmar',
'NA' => 'Namibia',
'NR' => 'Nauru',
'NP' => 'Nepal',
'AN' => 'Netherlands Antilles',
'NL' => 'Netherlands',
'NC' => 'New Caledonia',
'NZ' => 'New Zealand',
'NI' => 'Nicaragua',
'NE' => 'Niger',
'NG' => 'Nigeria',
'NU' => 'Niue',
'NF' => 'Norfolk Island',
'MP' => 'Northern Mariana Islands',
'NO' => 'Norway',
'OM' => 'Oman',
'PK' => 'Pakistan',
'PW' => 'Palau',
'PS' => 'Palestine State',
'PA' => 'Panama',
'PG' => 'Papua New Guinea',
'PY' => 'Paraguay',
'PE' => 'Peru',
'PH' => 'Philippines',
'PN' => 'Pitcairn Islands',
'PL' => 'Poland',
'PT' => 'Portugal',
'PR' => 'Puerto Rico',
'QA' => 'Qatar',
'RE' => 'Reunion',
'RO' => 'Romania',
'RU' => 'Russia',
'RW' => 'Rwanda',
'BL' => 'Saint Barthelemy',
'SH' => 'Saint Helena',
'KN' => 'Saint Kitts and Nevis',
'LC' => 'Saint Lucia',
'MF' => 'Saint Martin',
'PM' => 'Saint Pierre and Miquelon',
'VC' => 'Saint Vincent and the Grenadines',
'WS' => 'Samoa',
'SM' => 'San Marino',
'ST' => 'Sao Tome and Principe',
'SA' => 'Saudi Arabia',
'SN' => 'Senegal',
'RS' => 'Serbia',
'SC' => 'Seychelles',
'SL' => 'Sierra Leone',
'SG' => 'Singapore',
'SK' => 'Slovakia',
'SI' => 'Slovenia',
'SB' => 'Solomon Islands',
'SO' => 'Somalia',
'ZA' => 'South Africa',
'GS' => 'South Georgia and the South Sandwich Islands',
'ES' => 'Spain',
'LK' => 'Sri Lanka',
'SD' => 'Sudan',
'SR' => 'Suriname',
'SJ' => 'Svalbard and Jan Mayen Islands',
'SZ' => 'Eswatini',
'SE' => 'Sweden',
'CH' => 'Switzerland',
'SY' => 'Syria',
'TW' => 'Taiwan',
'TJ' => 'Tajikistan',
'TZ' => 'Tanzania',
'TH' => 'Thailand',
'TL' => 'Timor-Leste',
'TG' => 'Togo',
'TK' => 'Tokelau',
'TO' => 'Tonga',
'TT' => 'Trinidad and Tobago',
'TN' => 'Tunisia',
'TR' => 'Turkey',
'TM' => 'Turkmenistan',
'TC' => 'Turks and Caicos Islands',
'TV' => 'Tuvalu',
'UG' => 'Uganda',
'UA' => 'Ukraine',
'AE' => 'United Arab Emirates',
'GB' => 'United Kingdom',
'US' => 'USA',
'UM' => 'United States Minor Outlying Islands',
'VI' => 'United States Virgin Islands',
'UY' => 'Uruguay',
'UZ' => 'Uzbekistan',
'VU' => 'Vanuatu',
'VE' => 'Venezuela',
'VN' => 'Vietnam',
'WF' => 'Wallis and Futuna',
'EH' => 'Western Sahara',
'YE' => 'Yemen',
'ZM' => 'Zambia',
'ZW' => 'Zimbabwe',
'XK' => 'Kosovo',

);

    if ($countryList[$code]){
        return $countryList[$code];
    } else {
        return FALSE;
    }
}

function get_active_institutions(){
    global $wpdb;
    
    $text = $wpdb->prepare("SELECT post_id FROM wp_postmeta WHERE meta_key = 'active' AND meta_value = 1;");
    
    $db_queries = $wpdb->get_results($text, ARRAY_A);
    
    $ids = array();
    foreach ($db_queries as $db_query){
        array_push($ids, $db_query["post_id"]); 
    };
    
    return $ids;
    
};

function exclude_institutions($location){
   
    global $wpdb;
    
    $query = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'excludeCountries' AND meta_value LIKE '%%" . $location . "%%'";
    $text = $wpdb->prepare($query);
    
    $db_queries = $wpdb->get_results($text, ARRAY_A);
        
    $ids = array();
    
    if (is_array($db_queries)){
    
        foreach ($db_queries as $db_query){
            array_push($ids, $db_query["post_id"]); 
        };
    }

    
    return $ids;
    
};

function exclude_institutions_by_tier($location){
    
$countryList = array(
    
'Afghanistan' => 3,
'Aland Islands' => 2,
'Albania' => 2,
'Algeria' => 3,
'American Samoa' => 2,
'Andorra' => 1,
'Angola' => 3,
'Anguilla' => 3,
'Antarctica' => 2,
'Antigua and Barbuda' => 2,
'Argentina' => 2,
'Armenia' => 1,
'Aruba' => 2,
'Australia' => 1,
'Austria' => 1,
'Azerbaijan' => 2,
'Bahamas' => 3,
'Bahrain' => 2,
'Bangladesh' => 3,
'Barbados' => 2,
'Belarus' => 1,
'Belgium' => 1,
'Belize' => 2,
'Benin' => 3,
'Bermuda' => 3,
'Bhutan' => 3,
'Bolivia' => 2,
'Bosnia and Herzegovina' => 1,
'Botswana' => 3,
'Bouvet Island' => 2,
'Brazil' => 2,
'British Indian Ocean Territory' => 2,
'British Virgin Islands' => 2,
'Brunei' => 3,
'Bulgaria' => 1,
'Burkina Faso' => 3,
'Burundi' => 3,
'Cambodia' => 3,
'Cameroon' => 3,
'Canada' => 1,
'Cabo Verde' => 3,
'Cayman Islands' => 2,
'Central African Republic' => 3,
'Chad' => 3,
'Chile' => 2,
'China' => 1,
'Christmas Island' => 2,
'Cocos Islands' => 2,
'Colombia' => 2,
'Comoros' => 2,
'Democratic Republic of the Congo' => 3,
'Congo' => 3,
'Cook Islands' => 2,
'Costa Rica' => 2,
'Cote d\'Ivoire' => 3,
'Croatia' => 1,
'Cuba' => 2,
'Cyprus' => 1,
'Czech Republic' => 1,
'Denmark' => 1,
'Djibouti' => 3,
'Dominica' => 2,
'Dominican Republic' => 2,
'Ecuador' => 2,
'Egypt' => 3,
'El Salvador' => 2,
'Equatorial Guinea' => 3,
'Eritrea' => 2,
'Estonia' => 2,
'Ethiopia' => 3,
'Faroe Islands' => 2,
'Falkland Islands' => 3,
'Fiji' => 3,
'Finland' => 1,
'France' => 1,
'French Guiana' => 3,
'French Polynesia' => 3,
'French Southern Territories' => 3,
'Gabon' => 3,
'Gambia' => 3,
'Georgia' => 1,
'Germany' => 1,
'Ghana' => 3,
'Gibraltar' => 3,
'Greece' => 1,
'Greenland' => 1,
'Grenada' => 3,
'Guadeloupe' => 3,
'Guam' => 2,
'Guatemala' => 3,
'Guernsey' => 3,
'Guinea' => 3,
'Guinea-Bissau' => 3,
'Guyana' => 3,
'Haiti' => 3,
'Heard Island and McDonald Islands' => 3,
'Holy See' => 1,
'Honduras' => 3,
'Hong Kong' => 2,
'Hungary' => 1,
'Iceland' => 1,
'India' => 3,
'Indonesia' => 2,
'Iran' => 2,
'Iraq' => 2,
'Ireland' => 1,
'Isle of Man' => 2,
'Israel' => 2,
'Italy' => 1,
'Jamaica' => 2,
'Japan' => 2,
'Jersey' => 3,
'Jordan' => 2,
'Kazakhstan' => 3,
'Kenya' => 3,
'Kiribati' => 3,
'North Korea' => 3,
'South Korea' => 1,
'Kuwait' => 2,
'Kyrgyzstan' => 3,
'Laos' => 2,
'Latvia' => 2,
'Lebanon' => 2,
'Lesotho' => 2,
'Liberia' => 3,
'Libya' => 3,
'Liechtenstein' => 3,
'Lithuania' => 2,
'Luxembourg' => 1,
'Macao' => 2,
'Macedonia' => 2,
'Madagascar' => 3,
'Malawi' => 3,
'Malaysia' => 2,
'Maldives' => 3,
'Mali' => 3,
'Malta' => 3,
'Marshall Islands' => 2,
'Martinique' => 3,
'Mauritania' => 3,
'Mauritius' => 2,
'Mayotte' => 3,
'Mexico' => 2,
'Micronesia' => 2,
'Moldova' => 3,
'Monaco' => 3,
'Mongolia' => 3,
'Montenegro' => 3,
'Montserrat' => 3,
'Morocco' => 3,
'Mozambique' => 3,
'Myanmar' => 2,
'Namibia' => 3,
'Nauru' => 2,
'Nepal' => 3,
'Netherlands Antilles' => 3,
'Netherlands' => 1,
'New Caledonia' => 3,
'New Zealand' => 1,
'Nicaragua' => 3,
'Niger' => 3,
'Nigeria' => 3,
'Niue' => 3,
'Norfolk Island' => 3,
'Northern Mariana Islands' => 3,
'Norway' => 1,
'Oman' => 2,
'Pakistan' => 3,
'Palau' => 3,
'Palestine State' => 2,
'Panama' => 2,
'Papua New Guinea' => 3,
'Paraguay' => 2,
'Peru' => 2,
'Philippines' => 2,
'Pitcairn Islands' => 2,
'Poland' => 1,
'Portugal' => 1,
'Puerto Rico' => 2,
'Qatar' => 2,
'Reunion' => 3,
'Romania' => 1,
'Russia' => 2,
'Rwanda' => 3,
'Saint Barthelemy' => 2,
'Saint Helena' => 3,
'Saint Kitts and Nevis' => 2,
'Saint Lucia' => 2,
'Saint Martin' => 2,
'Saint Pierre and Miquelon' => 2,
'Saint Vincent and the Grenadines' => 2,
'Samoa' => 3,
'San Marino' => 3,
'Sao Tome and Principe' => 3,
'Saudi Arabia' => 2,
'Senegal' => 3,
'Serbia' => 1,
'Seychelles' => 3,
'Sierra Leone' => 3,
'Singapore' => 2,
'Slovakia' => 1,
'Slovenia' => 1,
'Solomon Islands' => 3,
'Somalia' => 3,
'South Africa' => 2,
'South Georgia and the South Sandwich Islands' => 3,
'Spain' => 1,
'Sri Lanka' => 3,
'Sudan' => 3,
'Suriname' => 3,
'Svalbard and Jan Mayen Islands' => 3,
'Eswatini' => 3,
'Sweden' => 1,
'Switzerland' => 1,
'Syria' => 2,
'Taiwan' => 2,
'Tajikistan' => 3,
'Tanzania' => 3,
'Thailand' => 2,
'Timor-Leste' => 3,
'Togo' => 3,
'Tokelau' => 3,
'Tonga' => 3,
'Trinidad and Tobago' => 2,
'Tunisia' => 3,
'Turkey' => 2,
'Turkmenistan' => 3,
'Turks and Caicos Islands' => 2,
'Tuvalu' => 3,
'Uganda' => 3,
'Ukraine' => 1,
'United Arab Emirates' => 2,
'United Kingdom' => 1,
'USA' => 1,
'United States Minor Outlying Islands' => 2,
'United States Virgin Islands' => 2,
'Uruguay' => 3,
'Uzbekistan' => 3,
'Vanuatu' => 3,
'Venezuela' => 2,
'Vietnam' => 2,
'Wallis and Futuna' => 3,
'Western Sahara' => 2,
'Yemen' => 2,
'Zambia' => 3,
'Zimbabwe' => 3
);
    
$tier = "Tier" . $countryList[$location];
    
    global $wpdb;

    $query = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'exclude_by_tiers' AND meta_value LIKE '%%" . $tier . "%%'";
    $text = $wpdb->prepare($query);

    $db_queries = $wpdb->get_results($text, ARRAY_A);

    $ids = array();

    if (is_array($db_queries)){

        foreach ($db_queries as $db_query){
            array_push($ids, $db_query["post_id"]); 
        };
    }
    return $ids;


    
};




// //Submitting Course Form
// function course_form_submit() {

//     $newURL = site_url()."/opencourses/?subject=" . $_POST["subject"] . "&degrees=" .$_POST["degree"] . "&country=" .$_POST["country"];

//     wp_redirect( $newURL );
//     exit;

// }

// add_action( 'admin_post_nopriv_course_form', 'course_form_submit' );
// add_action( 'admin_post_course_form', 'course_form_submit' );


//Submitting Course Form
function course_form_submit() {
    $newURL = site_url() . "/opencourses";
    $query_args = array();

    if (!empty($_POST["subject"])) {
        $query_args["subject"] = $_POST["subject"];
    }

    if (!empty($_POST["degree"])) {
        $query_args["degrees"] = $_POST["degree"];
    }

    if (!empty($_POST["country"])) {
        $query_args["country"] = $_POST["country"];
    }

    if (!empty($query_args)) {
        $newURL .= "?" . build_query($query_args);
    }

    wp_redirect($newURL);
    exit;
}

add_action( 'admin_post_nopriv_course_form', 'course_form_submit' );
add_action( 'admin_post_course_form', 'course_form_submit' );


function show_ads_card( $ad_id ){
    
    $ad = get_post( $ad_id );
    $fields = get_fields( $ad_id );
    
    require get_stylesheet_directory() .'/components/ad-card.php';

};

function show_ads_card_new( $ad_id ){
    
    $ad = get_post( $ad_id );
    $fields = get_fields( $ad_id );
    
    require get_stylesheet_directory() .'/components/ad-card-new.php';

};

function course_shortcode($atts){
    $text = $atts['text'];
    $link = $atts['link'];
    $html =  '<aside class="course-aside">
    <a href="' . $link . '">
    <button class="course-buttons">'
. $text . '</button>
    </a>
</aside>';
    
    return $html;
}

add_shortcode('courseButton','course_shortcode');

function course_filter_shortcode($atts = [], $content = null, $tag = '' ){

    // Fetch fields from ACF Courses Group
    $courses_details = acf_get_fields('group_64c9f01dd1837');

    // Get subjects and their choices
    $courses_subject = array_column($courses_details, null, 'name')['subjects'];
    $ads_subject = $courses_subject['choices'];

    // Get countries and their choices
    $courses_countries = array_column($courses_details, null, 'name')['countries'];
    $courses_countries = $courses_countries['choices'];

    // Parse shortcode attributes
    shortcode_atts(array(
        'filter_word' => 'Search',
    ), $atts);

    // Start the HTML for the filter form
    $html = '<aside><div class="course-filter">';

    $html .= '<form action="' . esc_url( admin_url("admin-post.php") ) . '" method="POST" class="filter-wrapper">';

    $html .= '<input type="hidden" name="action" value="course_form">';
    $html .= '<div class="filter-boxes-wrap">';

    $html .= '<div class="filter-title">Search Courses:</div>'; 

    $html .= '<div class="filter-box degree-filter">';
    $html .= '<select name="degree"><option value="">Any Degree</option>'; 
    $html .= '<option value="undergraduate">Undergraduate</option>'; 
    $html .= '<option value="masters">Masters</option>'; 
    $html .= '<option value="mba">MBA</option></select></div>';

    // Dynamic subject dropdown
    $html .= '<div class="filter-box subject-filter">';
    $html .= '<select name="subject"><option value="">Any Subject</option>';
    foreach($ads_subject as $sub) {
        $sub_value = str_replace(" ", "-", strtolower($sub));
        $html .= '<option value="' . esc_attr($sub_value) . '">' . esc_html($sub) . '</option>';
    }
    $html .= '</select></div>';

    // Dynamic country dropdown
    $html .= '<div class="filter-box country-filter">';
    $html .= '<select name="country"><option value="">Any Country</option>';
    foreach($courses_countries as $country) {
        $country_value = str_replace(" ", "-", strtolower($country));
        $html .= '<option value="' . esc_attr($country_value) . '">' . esc_html($country) . '</option>';
    }
    $html .= '</select></div>';

    // Close out the HTML for the form and filter
    $html .= '<div class="filter-btn">';
    $html .= '<button type="submit">'.(isset($atts['filter_word']) ? $atts['filter_word'] : 'Search').'</button>';
    $html .= '</div></form></div></aside>';

    return $html;
}

add_shortcode('courseFilter', 'course_filter_shortcode');






// function course_nav_shortcode(){
    
//     $html = '
//     <aside>
// <div class="course-nav"> 
  
// <div class="course-filter"> 
    
//     <form action="' . esc_url( admin_url("admin-post.php") ) . '" method="POST" class="filter-wrapper">

//     <input type="hidden" name="action" value="course_form">
//     <div class="filter-boxes-wrap">
        
//         <div class="filter-title">
//             Search Courses:
//         </div>        

//         <div class="filter-box subject-filter">
//             <select name="degree" >
//             <option value="">Any Degree</option> 
//             <option value="undergraduate">Undergraduate</option> 
//             <option value="masters">Masters</option> 
//             <option value="mba" >MBA</option> 

//             </select>

//         </div>
        
//     </div>

//     <div class="filter-btn">
//     <button type="submit">Search</button>

//     </div>

//     </form>
// </div>
// </div>
// </aside>';
        
//     return $html;
// }

/*
        <div class="filter-box subject-filter">
            <select name="subject" >
            <option value="">Any Subject</option>
            <option value="business" >Business</option>
            <option value="computer-science" >Computer Science</option>
            <option value="data-science" >Data Science</option>
            <option value="design" >Design</option>
            <option value="marketing" >Marketing</option>
            <option value="hospitality-and-tourism-management">Hospitality and Tourism Management</option>
            <option value="law" >Law</option>                
            </select>

        </div>
*/

// add_shortcode('coursenav','course_nav_shortcode');

function update_rankings_post_meta(){
  
    $args = array(
    'post_type' => 'institution',
    'post_status' => "any",
     'posts_per_page' => 100,
     );
    
    $query = new WP_Query( $args );
    
    //Add two just in case. Should be enough with adding 1, but I just want to make sure that we go through all the posts
    //We are batching 100 posts per query so that we don't run out of memory 
    $page_count = $query->max_num_pages + 2;
    
    $count = 1;
    
    while ($count <= $page_count){
        
        $args = array(
        'post_type' => 'institution',
       'post_status' => "any", 
        'posts_per_page' => 100,
        'paged' => $count,
         );

        $query = new WP_Query( $args );   
        
        
           if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
    
                $rankings = get_field('rankings');
                $enrollments = get_field('enrollment');
                $total = $enrollments['total'];
                $international = $enrollments['international'];

                $counter = 0; 
                $sum = 0;
                $final_rank = 0;

                foreach($rankings as $value) {
                    if($value==-1){
                    continue;
                   }else {
                    $sum = $sum + (int) $value;
                    $counter++;
                   }
                }

            // To Prevent Infinity as a result of division
            //since if counter > 0, that means that atleast one  ranking is not -1.

                 if( $counter > 0 ) {
                  $final_rank = $sum / $counter;
                 } 

            //Field key for average rankings post meta
                
                $field_key = "average_rankings";
                if($final_rank == 0){
                 update_field($field_key, 5000);
                } else {
                 update_field($field_key, floatval($final_rank));    
                }

                endwhile; endif;
                wp_reset_query();

        $count = $count + 1;
        
    
    } //End of while loop
    
}

add_action( 'update_rankings_international', 'update_rankings_post_meta' );

add_action( 'save_deadlines', 'save_deadline_post_meta' );
add_action( 'save_open_dates', 'save_scholarships_open_date_post_meta' );
add_action( 'update_open_dates', 'update_open_dates' );
add_action("update_generated_posts", "update_generated_posts");
add_action("calculate_resulted_posts", "calculate_resulted_posts");
add_action("update_number_of_resulted_posts", "update_number_of_resulted_posts");
add_action("update_post_institutions", "update_post_institutions");
add_action("calculate_resulted_institutions", "calculate_resulted_institutions"); 
add_action("update_number_of_resulted_institutions", "update_number_of_resulted_institutions"); 


//Submitting Course Form
function searchscholarship_form_submit() {


$newURL = "https://globalscholarships.com/scholarship-search/?location=" . $_POST["country"] . "&degrees=" . $_POST["degree"] . "&subject=" .$_POST["subject"];
    wp_redirect( $newURL );
    exit;
}

add_action( 'admin_post_nopriv_scholarship_form', 'searchscholarship_form_submit' );
add_action( 'admin_post_scholarship_form', 'searchscholarship_form_submit' );



   // Call the function with an input parameter


function my_ajax_handler() {

 // Get the new title from the AJAX request

   $offset = $_POST["offset"];
   $ppp = $_POST["ppp"];
   $page_count = $_POST['page_count'];
  
   //$offset = $offset - 1;
  
   $degrees = stripslashes($_POST['degrees']);
   $degrees_array = explode(',', $degrees); 

   $subjects = $_POST['subjects'];
   $subject_array = explode(',', $subjects); 

   $scholarship = $_POST['scholarship'];
   $scholarship_array = explode(',', $scholarship);

  
   $locations = $_POST['locations'];
   $locations_array = explode(',', $locations); 

   $nationality = $_POST['nationality'];
   $nationality_array = explode(',', $nationality); 

   $scholarship_type = $_POST['scholarship_type'];
   $type_array = explode(',', $scholarship_type); 

   $applications = $_POST['applications'];
   $application_array = explode(',', $applications);

   $institution_array = $_POST['institutions'];
   $institution_array = explode(',', $institution_array);  
   
$scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
$published_countries = array_column($scholarship_details, null, 'name')['published_countries'];
$country_list = $published_countries['choices'];
  

$reload_true = $_POST["reload"];
$location = $locations_array[0];



if($reload_true){
     
  if($location){

    
    if( !in_array($location, $country_list)) {
       echo '<p style="font-size:20px;color:black;"> Unfortunately,
    No Scholarships Available in <b>' .  $locations_array[0] . ' </b> <p>';
    die(); 
    }
}
   
}



$loop_institute =  get_institutions_location($locations_array[0]);
$institute_ids = $loop_institute->get_posts();

//echo $institute_ids->found_posts;
	
/* if (empty($institute_ids)) {
		if($reload_true){
  echo '<p style="font-size:20px;color:black;"> Unfortunately,
    No Scholarships Available in <b>' .  $locations_array[0] . ' </b> <p>';
   }
	} */
	
    $current_date = date("Y-m-d H:i:s");
                            

                            $next_due_date = '';
                            
                            if($application_array[0]=="open"){


                            $next_due_date = date('Y-m-d H:i:s', strtotime("+3820 days"));
                              


                          }

                            if($application_array[0]=="one-month"){
                            $next_due_date = date('Y-m-d H:i:s', strtotime("+30 days"));

                            }

                            if($application_array[0]=="two-month"){
                            $next_due_date = date('Y-m-d H:i:s', strtotime("+60 days"));
                            }

                            if($application_array[0]=="three-month"){
                            $next_due_date = date('Y-m-d H:i:s', strtotime("+90 days"));
                            }

                            if($application_array[0]=="four-month"){
                            $next_due_date = date('Y-m-d H:i:s', strtotime("+120 days"));

                            }

                            if($application_array[0]=="five-month"){
                            $next_due_date = date('Y-m-d H:i:s', strtotime("+150 days"));
                            }

                            if($application_array[0]=="six-month"){
                            $next_due_date = date('Y-m-d H:i:s',  strtotime("+180 days"));
                            }

                            if($application_array[0]=="twelve-month"){
                            $next_due_date = date('Y-m-d H:i:s',  strtotime("+364 days"));
                            }

                            
    
    if($application_array[0]) {
    if($degrees_array[0]){
       if($degrees_array[0]=="PhD"){
        echo '<p style="font-size:20px;color:black;"> Unfortunately, we don’t keep track of PhD deadlines since they vary a lot by department. <p>';
        die();
       }
    }else {
        echo '<p style="font-size:20px;color:black;">Please select the degree to filter by scholarship  deadlines since different degrees <br> can have different deadlines. <p>';
        die();
    }
    }

   
    if(isset($subject_array[0]) && $subject_array[0]){
    
        $subject_query = array('type' => 'string' , 'key' => 'eligible_programs', 'value' => $subject_array[0], 'compare' => 'LIKE');
        }
    


if(isset($nationality_array[0]) && $nationality_array[0]){
      
        $nationality_query = array('type' => 'string' , 'key' => 'eligible_nationality', 'value' => $nationality_array[0], 'compare' => 'LIKE');
        
    }

    if(isset($degrees_array[0]) && $degrees_array[0]){
        $degree_query = array('key' => 'eligible_degrees',  'value' => $degrees_array[0],  'compare' => 'LIKE');
    }

        if(isset($application_array[0]) && $application_array[0]){
         
            if($degrees_array[0]=="Master's"){
                
                if($application_array[0]=="open"){

            $application_query = array (
                             'relation' => 'AND',
                              array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=' ,   'value' =>  $next_due_date  , 'type' => 'date' ,   ), 
                              array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=' ,   'value' =>  $current_date  ,  'type' => 'date' ,  ),
                              array('key' => 'master_open_date',      'value' => 'Yes',    'compare' => "LIKE"),
                            );

                      //  if($application_array[0]=="open"){
                      //  $opendate_query  = array('key' => 'master_open_date',      'value' => 'Yes',    'compare' => "LIKE");
                      // } 
            }  else {
             
             $application_query = array (
                             'relation' => 'AND',
                              array('key' => 'current_masters_scholarship_deadline', 'compare' => '<=' ,   'value' =>  $next_due_date  , 'type' => 'date' ,   ), 
                              array('key' => 'current_masters_scholarship_deadline', 'compare' => '>=' ,   'value' =>  $current_date  ,  'type' => 'date' ,  ),
                             
                            );


            } 
        }

            
            if($degrees_array[0]=="Bachelor's"){
            
            if($application_array[0]=="open"){
            $application_query = array (
                             'relation' => 'AND',
                              array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=' ,   'value' =>  $next_due_date  , 'type' => 'date' ,  ), 
                              array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=' ,   'value' =>  $current_date  ,  'type' => 'date' ,  ) ,
                              array('key' => 'bachelor_open_date',      'value' => 'Yes',    'compare' => "LIKE"),
                            );

                             // if($application_array[0]=="open"){
                             // $opendate_query  = array('key' => 'bachelor_open_date',      'value' => 'Yes',    'compare' => "LIKE");
                             //  } 
            } else {
                $application_query = array (
                             'relation' => 'AND',
                              array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '<=' ,   'value' =>  $next_due_date  , 'type' => 'date' ,  ), 
                              array('key' => 'current_bachelors_scholarship_deadline', 'compare' => '>=' ,   'value' =>  $current_date  ,  'type' => 'date' ,  ) ,
                              
                            );
            }
        }
    }

    if(isset($type_array[0]) && $type_array[0]){
        $type_query  = array('key' => 'amount_category', 'value' => $type_array[0], 'compare' => "LIKE");
    }
  

  
    if(isset($institution_array[0]) && $institution_array[0]){
       $institution_query  = array('key' => 'scholarship_institution', 'value' => $institution_array, 'compare' => "IN");
     } else {
        if(isset($locations_array[0]) && $locations_array[0]){
        $location_query  = array('key' => 'scholarship_institution', 'value' => $institute_ids, 'compare' => "IN");
        }
     } 

    $meta_query = array( 'relation' => 'AND');    
        
    if ($subject_query) { 
    $meta_query[] = $subject_query; 
    }
    
    if ($degree_query)  {
    $meta_query[] = $degree_query;
    }

    if ($location_query) { 
    $meta_query[] = $location_query; 
    }
    
    if ($type_query) { 
    $meta_query[] = $type_query; 
    }

    if ($nationality_query) { 
    $meta_query[] = $nationality_query; 
    }

    if ($institution_query) { 
    $meta_query[] = $institution_query; 
    }

     if ($application_query) { 
    $meta_query[] = $application_query; 
    }
    
   
 if($scholarship_array[0]){
 $ad_args = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => $ppp,
    'offset' => $offset,
    'fields' => 'ids', // Only return post IDs
    'meta_key' => 'scholarship_weights',  // name of custom field
    'orderby' => 'meta_value_num',  // we want to order by numeric value
    'order' => 'DESC',  // highest to lowest
    'title' => $scholarship_array[0]
);
   }
   else {
    $ad_args = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => $ppp,
    'offset' => $offset,
    'fields' => 'ids', // Only return post IDs
    'meta_key' => 'scholarship_weights',  // name of custom field
    'orderby' => 'meta_value_num',  // we want to order by numeric value
    'order' => 'DESC',  // highest to lowest
    );
    }

   if ($meta_query){
        $ad_args['meta_query'] = $meta_query;
   }
      
     
    $loop = new WP_Query($ad_args);
    
    $text = "";
  

if($type_array[0]=="Full Funding"){
    $type_array[0] = "Fully Funded";
}if($type_array[0]=="Partial Funding"){
    $type_array[0] = "Partially Funded";
}

if($type_array[0]) {
  if($degrees_array[0]){
     $text .= $loop->found_posts . " ". $type_array[0] . " ". $degrees_array[0]. " Scholarships";
  } else {
    $text .= $loop->found_posts .  " " . $type_array[0] ." Scholarships";
  }
} else {

 if($degrees_array[0]){
     $text .= $loop->found_posts . " " . $degrees_array[0]. " Scholarships";
  } else {
    $text .= $loop->found_posts . " Scholarships";
  }

}



   if($locations_array[0]){
     $text .= " in " . $locations_array[0];
  } 
  if($subject_array[0]){
     $text .= " for " . $subject_array[0];
  } 


   if($nationality_array[0]){
     $text .= " for " . $nationality_array[0] . " Students";
  }else {
     $text .= " for International Students ";
  }

   
  

   



  
  $checkk = stripslashes($_POST['checkk']);
  // if($checkk) {
  //   $text  = $loop->found_posts . " Scholarships for International Students "; 
  // }
   echo "<h1 class='title-textt' style=' margin-bottom:0px;padding-bottom:10px;'>" . $text . "</h1>";
  
   
    if($degrees_array[0]){
    echo "<span class='ss' style='font-size:16px;margin-bottom:20px;padding-left:7px;'>| Degrees: <b>" . convert_array_to_text($degrees_array) . "</b></span>";
    }
    if($locations_array[0]){
    echo "<span class='ss'  style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Locations: <b>" . $locations_array[0] . "</b></span>";
    }

    if($nationality_array[0]){
    echo "<span  class='ss' style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Nationality: <b>" . $nationality_array[0] . "</b></span>";
    }
    if($subject_array[0]){
    echo "<span class='ss' style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Subject: <b>" . convert_array_to_text($subject_array) . "</b></span> ";
    }
     if($type_array[0]){
    echo "<span  class='ss' style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Scholarship Type: <b>" . convert_array_to_text($type_array) . "</b></span> ";
    }

    if($application_array[0]){
        if($application_array[0]=="open"){
            $application_text = "Currently Open";
        }
        if($application_array[0]=="one-month"){
            $application_text = "Within one Month";
        }
        if($application_array[0]=="two-month"){
            $application_text = "Within two Month";
        }
        if($application_array[0]=="three-month"){
            $application_text = "Within three Month";
        }
        if($application_array[0]=="four-month"){
            $application_text = "Within four Month";
        }
        if($application_array[0]=="five-month"){
            $application_text = "Within five Month";
        }
        if($application_array[0]=="six-month"){
            $application_text = "Within Six Month";
        }
        if($application_array[0]=="twelve-month"){
            $application_text = "WIthin Twelve Month";
        }
    echo "<span  class='ss' style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Deadline: <b>" . $application_text . "</b></span>";

    }

    if($institution_array[0]){
    $result = get_institution_by_id($institution_array[0]);
        while ($result->have_posts() ) {
        $result->the_post();

    echo "<span class='ss' style='font-size:16px;padding-bottom:10px;padding-left:7px;'> | Institution:  <b>" . get_the_title() . " </b></span> ";
       }
    }

    $start = ( $page_count - 1 ) * $ppp;
    if($start === 0){
        $start = 1;
    }

    

    $modulus =  fmod($loop->found_posts , $ppp);
    $page_addition = 0;
    if($modulus > 0 ){
    $page_addition++;
    }
   
    $current = $page_count * $ppp;
    if( ($page_count * $ppp) > $loop->found_posts ) {
        $current = $loop->found_posts;
        
    }
 
   


 $current_date = date("F d,Y");
    echo "<span class='ss' style='font-size:16px;padding-bottom:10px;padding-left:14px;'> | Results:  <b> " . $start .  "-" . $current  . " of " . $loop->found_posts  . " </b></span> <br>";

    $html = "";
        
          if ($loop->have_posts() ){
                while ($loop->have_posts() ) {
                        $loop->the_post();
                       
                        $scholarship_id = $post->ID;
                        $html   .= '<div class="col-sm-12 my-2 course-card" >';
                        $html   .= scholarship_card($scholarship_id);
                        $html   .= '</div>'; 
 
                    }

                    $html .= ' <div class="clearfix"> </div> ';
                  $html .= '<br>';
            
            $html .= "  <center>  <span class='mobile_page_count' style='display:none;text-align:center;width:100%;margin-top:30px;font-size:18px;padding-left:0px;margin-bottom:40px !important;'> Page " . $page_count .  " of " .  intval( ( $loop->found_posts / $ppp ) + $page_addition )  . " </span> </center>  ";
            if($page_count > 1 ) {
            // $html .=  " </center> </div> <center>  <span style='background:#f7f7f7;color:white;width:160px !important;border:1px solid #cdcdcd; padding:10px;padding-left:30px;padding-right:30px;font-size:18px !important;' id='prev_posts'> Prev Page </span> ";
            }

    $html .= "  <center>  <span class='desktop_page_count' style='width:100%;margin-bottom:30px; display:block; text-align:center !important;font-size:20px;padding-left:20px;'> Page " . $page_count .  " of " .  intval( ( $loop->found_posts / $ppp ) + $page_addition )  . " </span> </center>  ";
            if($current == $loop->found_posts) {

            }else {
               // $html .=  "<span style='background:#f7f7f7;width:160px !important;border:1px solid #cdcdcd; padding:10px;padding-left:30px;padding-right:30px;font-size:18px !important;' id='more_posts'> Next Page </span> </center>";
            }
           
        } 

    echo $html;

    die();
   }

add_action('wp_ajax_nopriv_get_data', 'my_ajax_handler' );
add_action( 'wp_ajax_get_data', 'my_ajax_handler' );


function generate_scholarships_table($country="" , $degree="" , $type="", $acf_country="") {
    


$degree = wp_unslash($degree);

$meta_query = array();

if ($acf_country !== 'All') {
    $meta_query[] = array(
        'key' => 'institution_country',
        'value' => $acf_country,
        'compare' => '=',
    );
} else {
    if ($country !== 'All') {
        $meta_query[] = array(
            'key' => 'institution_country',
            'value' => $country,
            'compare' => '=',
        );
    }
}


if (!empty($degree)) {
    $meta_query[] = array(
        'relation' => 'OR',
        array(
            'key' => 'eligible_degrees',
            'value' => $degree,
            'compare' => 'LIKE',
        ),
        array(
            'key' => 'eligible_degrees',
            'value' => 'All',
            'compare' => '=',
        ),
    );
if($degree=="Bachelor's") {
    $meta_query[] = array(
        'key' => 'bachelor_open_date',
        'value' => 'Yes',
        'compare' => '=',
    );
 }
if($degree=="Master's") {
    $meta_query[] = array(
        'key' => 'master_open_date',
        'value' => 'Yes',
        'compare' => '=',
    );
 }

} 
else {
    $meta_query[] = array(
    'relation' => 'OR',
    array(
        'key' => 'bachelor_open_date',
        'value' => "Yes",
        'compare' => '=',
    ),
    array(
        'key' => 'master_open_date',
        'value' => "Yes",
        'compare' => '=',
    ),
);

}

if (!empty($type)) {
    $meta_query[] = array(
        'key' => 'amount_category',
        'value' => $type,
        'compare' => '=',
    );
}

$scholarships_ids = get_posts(array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'cache_results' => false,
    'fields' => 'ids',
    'posts_per_page' => -1,
    'meta_query' => $meta_query,
));



    // Fetch scholarship info
    $institution_scholarships = get_scholarships_info($scholarships_ids, $allowed_countries);

    $previous_institution = '';
    $row_color = '';
  
    $table_html = '<div id="example-wrapper" style="width:100%;">';
    $table_html .= '<table id="example" style="border-collapse: collapse; border: 1px solid black; width: 100%;">';
    $table_html .= '<thead><tr style="border:none !important;">';
    $table_html .= '<th style="width:20%;">Institution Name</th>';
    if ($acf_country === 'All') {
        $table_html .= '<th style="width:15%;">Country</th>';
    }
    $table_html .= '<th style="width:65%;padding:0px !important;">';
    $table_html .= '<table style="border:none !important;border-collapse:none !important;"><thead><tr style="width:100% !important;">';
    $table_html .= '<th style="border:none !important;border-right:2px solid gray !important;width:25% !important;">Scholarship</th>';
    $table_html .= '<th style="border:none !important;border-right:2px solid gray !important;width:25% !important;">Coverages</th>';
    $table_html .= '<th style="border:none !important;border-right:2px solid gray !important;width:25% !important;">Eligible Degrees</th>';
    $table_html .= '<th style="border:none !important;width:25%;
    border-right:2px solid gray !important !important;">Scholarship Deadlines</th>';
    $table_html .= '</tr></thead></table></th></tr></thead>';
    $table_html .= '<tbody>';

    foreach ($institution_scholarships as $country_name => $country_institutions) {
        foreach ($country_institutions as $institution_name => $institution) {
            // Switch row color when institution changes
            if ($previous_institution != $institution_name) {
                //$row_color = ($row_color == '#F5F5F5') ? '#ffffff' : '#F5F5F5';
            }
            $previous_institution = $institution_name;

            $table_html .= '<tr style="border: 1px solid #ddd; background-color: ' . $row_color . ';">';
            $table_html .= '<td style="width:20% !important;padding: 10px;"><a style="font-weight:500;font-size:18px;" href="' . $institution['institution_permalink'] . '">' . $institution_name . '</a></td>';
            if ($acf_country === 'All') {
                $table_html .= '<td style="width:15% !important;padding: 10px;"><a href="' . site_url() . '/scholarship-search/' . str_replace(' ', '-', strtolower($country_name)) . '/">' . $country_name . '</a></td>';
            }
            $table_html .= '<td style="width:65% !important;padding: 0px;">';

            // start nested table for scholarships
            $table_html .= '<table class="scholarships-table" style="width: 100%;  border-collapse: collapse; margin-top:0px;">';
            

            $scholarships = $institution['scholarships'];
            foreach ($scholarships as $scholarship) {
                $table_html .= '<tr style="border-bottom: 1px solid #ddd;">';

                $table_html .= '<td style="max-width:25% !important;width:25% !important; ">';
$scholarship_permalink = $scholarship['scholarship_permalink'];
$scholarship_title = $scholarship['scholarship_title'];
$scholarship_type = strtolower($scholarship['scholarship_type']);
$category_amount = str_replace(' ', '-', $scholarship_type);
$category_amount = str_replace("'", '', $category_amount);

if ($category_amount === 'partial-funding') {
    $category_amount_url = 'partial-funding';
} else {
    $category_amount_url = $category_amount;
}

$table_html .= '<a style="font-size:16px;font-weight:600;" href="' . $scholarship_permalink . '">' . $scholarship_title . '</a><br> ';
$table_html .= '<a href="' . site_url() . '/scholarship-search/' . $category_amount_url . '">  (' . $scholarship['scholarship_type'] . ')</a>';

$table_html .= '</td>';

                

                $table_html .= '<td style="max-width:25% !important;max-width:25% !important;"><ul>';
                foreach (array_column($scholarship['coverages'], 'coverage') as $coverage) {
                    $table_html .= '<li>' . $coverage . '</li>';
                }
                $table_html .= '</ul></td>';
               $table_html .= '<td style="width:25% !important; ">';

foreach ($scholarship['eligible_degrees'] as $eligible_degree) {
    $degree_name = '';

    if ($eligible_degree === "Master's") {
        $degree_name = 'masters';
    } elseif ($eligible_degree === "Bachelor's") {
        $degree_name = 'bachelors';
    } else {
        // Handle other degree names here
        $degree_name = strtolower($eligible_degree);
    }

    $eligible_degree_url = site_url() . '/scholarship-search/' . urlencode($degree_name);
    $table_html .= '<a href="' . $eligible_degree_url . '">' . $eligible_degree . '</a><br>';
}

$table_html .= '</td>';
                $table_html .= '<td style="width:25% !important;padding: 10px 15px;">';
                $degreeDeadlines = array();
                $currentDate = date('Y-m-d');
                foreach ($scholarship['deadlines'] as $deadline) {
                    if (strtotime($deadline['deadline']) >= strtotime($currentDate) && in_array($deadline['degree'], $scholarship['eligible_degrees']) && $deadline['degree'] !== 'PhD') {
                        // Only store the deadline for each degree type if it doesn't already exist in the array
                        if (!array_key_exists($deadline['degree'], $degreeDeadlines)) {
                            $degreeDeadlines[$deadline['degree']] = '<strong>' . $deadline['degree'] . '</strong>: ' . $deadline['deadline'];
                        }
                    }
                }
                $table_html .= implode('<br>', $degreeDeadlines);
                $table_html .= '</td>';
                $table_html .= '</tr>';
            }
            $table_html .= '</table>'; // end nested table
            $table_html .= '</td>';
            $table_html .= '</tr>';
        }
    }

    $table_html .= '</tbody>';
    $table_html .= '</table>';
    $table_html .= '</div>';
    

   

    return $table_html;

}



 function get_scholarships_ajax() {
    
    $degree = $_POST["degree"];
    $country = $_POST["country"];
    $type = $_POST["type"];
    $acf_country = $_POST["acf_country"];



    // Generate the scholarships table HTML
    $table_html = generate_scholarships_table($country , $degree, $type , $acf_country);



    // Return the table HTML as the AJAX response
    echo $table_html;



    // Terminate the AJAX request
    wp_die();
}

add_action('wp_ajax_nopriv_get_scholarships_ajax', 'get_scholarships_ajax');
add_action('wp_ajax_get_scholarships_ajax', 'get_scholarships_ajax');

add_action( 'init', function() {

add_rewrite_rule(
        '^scholarship-search/.*?$',
        'index.php?pagename=scholarship-search',
        'top'
    );
});


// Add Rewrite Rule for Best Universities Template.
add_action( 'init',  function() {
    add_rewrite_rule(
        '^deadlines-by-country-([^/]*)?',
        'index.php?pagename=deadlines-by-country&country=$matches[1]',
        'top'
    );
} );
    


// $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
// echo $url;

// if (strpos($url,'/scholarship-search/bachelors') !== false) {
//    header("location: https://staging-globalscholarshipsa-staging.kinsta.cloud/scholarship-search/");
// } else {
//     echo 'No cars.';
// }


// $the_array = explode('/', trim($_SERVER['REQUEST_URI'],  '/'));
// $size = sizeof($the_array);
// echo $size;
// if($size > 1 ){
//     echo "if block";
// } else {
// echo "tt";
// }

// add_action( 'init',  function() {

//     add_rewrite_rule(
//         '^scholarship-search/([^/]*)/?',
//         'index.php?pagename=scholarship-search/$matches[1]',
//         'top'
//     );


//call_user_func_array([new $this->controller, $this->action], array $args);


function scholarships(){ }

function cities(){ }

function cpt_institution_meta_boxes(){}





function add_scholarship_user_role() {
    // Check if role already exists
    
    remove_role("scholarship_editor");

    $role = get_role( 'scholarship_editor' );
    if ( ! $role ) {
        $the_scholarship_editor_capabilities = get_role( 'editor' )->capabilities;
        add_role( 'scholarship_editor', 'Scholarship Editor',  $the_scholarship_editor_capabilities );
    }
}
add_action( 'after_setup_theme', 'add_scholarship_user_role' );


// Add Scholarship Capabilities to Administrator
function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

     // Add Edit Institution capabilities to editor
    $admins->add_cap( 'edit_institution' ); 
    $admins->add_cap( 'edit_institutions' ); 
    $admins->add_cap( 'edit_others_institutions' );
    $admins->add_cap( 'edit_published_institutions' );
    $admins->add_cap( 'publish_institutions' ); 
    $admins->add_cap( 'read_institution' ); 
    $admins->add_cap( 'read_private_institutions' ); 
    $admins->add_cap( 'delete_institutions' ); 
    $admins->add_cap( 'delete_institution' ); 
    $admins->add_cap( 'delete_others_institutions' ); 
    $admins->add_cap( 'delete_published_institutions' ); 

    // Add Edit Institution capabilities to Administrator
    $admins->add_cap( 'edit_scholarship' ); 
    $admins->add_cap( 'edit_scholarships' ); 
    $admins->add_cap( 'edit_others_scholarships' );
    $admins->add_cap( 'edit_published_scholarships' );
    $admins->add_cap( 'publish_scholarships' ); 
    $admins->add_cap( 'read_scholarship' ); 
    $admins->add_cap( 'read_private_scholarships' ); 
    $admins->add_cap( 'delete_scholarship' ); 
    $admins->add_cap( 'delete_scholarships' ); 
    $admins->add_cap( 'delete_others_scholarships' ); 
    $admins->add_cap( 'delete_published_scholarships' ); 

    // Add Edit Cities capabilities to Administrator
    $admins->add_cap( 'edit_city' ); 
    $admins->add_cap( 'edit_cities' ); 
    $admins->add_cap( 'edit_others_cities' );
    $admins->add_cap( 'edit_published_cities' );
    $admins->add_cap( 'publish_cities' ); 
    $admins->add_cap( 'read_city' ); 
    $admins->add_cap( 'read_private_cities' ); 
    $admins->add_cap( 'delete_cities' ); 
    $admins->add_cap( 'delete_city' ); 
    $admins->add_cap( 'delete_others_cities' ); 
    $admins->add_cap( 'delete_published_cities' ); 

    // Scholarships Feedback Access
    $admins->add_cap( 'scholarship_access' ); 

    // gets the editor role
    $admins = get_role( 'editor' );

    // Add Edit Institution capabilities to editor
    $admins->add_cap( 'edit_institution' ); 
    $admins->add_cap( 'edit_institutions' ); 
    $admins->add_cap( 'edit_others_institutions' );
    $admins->add_cap( 'edit_published_institutions' );
    $admins->add_cap( 'publish_institutions' ); 
    $admins->add_cap( 'read_institution' ); 
    $admins->add_cap( 'read_private_institutions' ); 
    $admins->add_cap( 'delete_institutions' ); 
    $admins->add_cap( 'delete_institution' ); 
    $admins->add_cap( 'delete_others_institutions' ); 
    $admins->add_cap( 'delete_published_institutions' ); 

    // Add Scholarship capabilities to institute_editor
    $admins->add_cap( 'edit_scholarship' ); 
    $admins->add_cap( 'edit_scholarships' );
    $admins->add_cap( 'edit_others_scholarships' );  // institute_editor Can edit others scholarships
    $admins->add_cap( 'publish_scholarships' );
    $admins->add_cap( 'edit_published_scholarships' );
    $admins->add_cap( 'read_scholarship' );
    $admins->add_cap( 'delete_scholarship' );
    $admins->add_cap( 'delete_scholarships' );
    $admins->add_cap( 'delete_others_scholarships' );
    $admins->add_cap( 'manage_scholarships' ); // institute_editor Can delete others scholarships
    $admins->add_cap( 'delete_published_scholarships' );


    // Add Edit Cities capabilities to editor
    $admins->add_cap( 'edit_city' ); 
    $admins->add_cap( 'edit_cities' ); 
    $admins->add_cap( 'edit_others_cities' );
    $admins->add_cap( 'edit_published_cities' );
    $admins->add_cap( 'publish_cities' ); 
    $admins->add_cap( 'read_city' ); 
    $admins->add_cap( 'read_private_cities' ); 
    $admins->add_cap( 'delete_cities' ); 
    $admins->add_cap( 'delete_city' ); 
    $admins->add_cap( 'delete_others_cities' ); 
    $admins->add_cap( 'delete_published_cities' ); 
      
    // Scholarships Feedback Access
    $admins->add_cap( 'scholarship_access' ); 

}


add_action( 'after_setup_theme', 'add_theme_caps');



function add_scholarship_caps_to_scholarship_editor() {

$scholarship_editor = get_role( 'scholarship_editor' );
    


    $scholarship_editor->remove_cap('edit_ads');
    $scholarship_editor->remove_cap('publish_ads');
    $scholarship_editor->remove_cap('read_ads');
    $scholarship_editor->remove_cap('read_private_ads');
    $scholarship_editor->remove_cap('delete_ads');
   
    $scholarship_editor->remove_cap('delete_private_ads');
    $scholarship_editor->remove_cap('delete_published_ads');

    // Add capabilities for institutions
    $scholarship_editor->add_cap( 'edit_institution' );
    $scholarship_editor->add_cap( 'read_institution' );
    $scholarship_editor->add_cap( 'delete_institution' );
    $scholarship_editor->add_cap( 'edit_institutions' );
    $scholarship_editor->add_cap( 'edit_others_institutions' );
    $scholarship_editor->add_cap( 'publish_institutions' );
    $scholarship_editor->add_cap( 'read_private_institutions' );
    $scholarship_editor->add_cap( 'delete_institutions' );
    $scholarship_editor->add_cap( 'delete_private_institutions' );
    $scholarship_editor->add_cap( 'delete_published_institutions' );
    $scholarship_editor->add_cap( 'delete_others_institutions' );
    $scholarship_editor->add_cap( 'edit_private_institutions' );
    $scholarship_editor->add_cap( 'edit_published_institutions' );
    $scholarship_editor->add_cap( 'manage_institution_terms' );
    $scholarship_editor->add_cap( 'edit_institution_terms' );
    $scholarship_editor->add_cap( 'delete_institution_terms' );
    $scholarship_editor->add_cap( 'assign_institution_terms' );



    $scholarship_editor->add_cap( 'edit_scholarship' );
    $scholarship_editor->add_cap( 'read_scholarship' );
    $scholarship_editor->add_cap( 'delete_scholarship' );
    $scholarship_editor->add_cap( 'edit_scholarships' );

    $scholarship_editor->add_cap( 'edit_others_scholarships' );

    $scholarship_editor->add_cap( 'publish_scholarships' );
    $scholarship_editor->add_cap( 'read_private_scholarships' );
    $scholarship_editor->add_cap( 'delete_scholarships' );
    $scholarship_editor->add_cap( 'delete_private_scholarships' );
    $scholarship_editor->add_cap( 'delete_published_scholarships' );
    $scholarship_editor->add_cap( 'delete_others_scholarships' );
    $scholarship_editor->add_cap( 'edit_private_scholarships' );
    $scholarship_editor->add_cap( 'edit_published_scholarships' );
    $scholarship_editor->add_cap( 'manage_scholarship_terms' );
    $scholarship_editor->add_cap( 'edit_scholarship_terms' );
    $scholarship_editor->add_cap( 'delete_scholarship_terms' );
    $scholarship_editor->add_cap( 'assign_scholarship_terms' );


$scholarship_editor->add_cap( 'edit_city' );
$scholarship_editor->add_cap( 'read_city' );
$scholarship_editor->add_cap( 'delete_city' );
$scholarship_editor->add_cap( 'edit_cities' );
$scholarship_editor->add_cap( 'edit_others_cities' );
$scholarship_editor->add_cap( 'publish_cities' );
$scholarship_editor->add_cap( 'read_private_cities' );
$scholarship_editor->add_cap( 'delete_cities' );
$scholarship_editor->add_cap( 'delete_private_cities' );
$scholarship_editor->add_cap( 'delete_published_cities' );
$scholarship_editor->add_cap( 'delete_others_cities' );
$scholarship_editor->add_cap( 'edit_private_cities' );
$scholarship_editor->add_cap( 'edit_published_cities' );
$scholarship_editor->add_cap( 'manage_city_terms' );
$scholarship_editor->add_cap( 'edit_city_terms' );
$scholarship_editor->add_cap( 'delete_city_terms' );
$scholarship_editor->add_cap( 'assign_city_terms' );


    $scholarship_editor->remove_cap('edit_ads');
    $scholarship_editor->remove_cap('edit_others_ads');
    $scholarship_editor->remove_cap('publish_ads');
    $scholarship_editor->remove_cap('read_ads');
    $scholarship_editor->remove_cap('read_private_ads');
    $scholarship_editor->remove_cap('delete_ads');
    $scholarship_editor->remove_cap('delete_published_ads');
    $scholarship_editor->remove_cap('delete_others_ads');
    $scholarship_editor->remove_cap('edit_published_ads');
    $scholarship_editor->remove_cap('edit_private_ads');
    
    // Scholarships Feedback Access
    $scholarship_editor->add_cap( 'scholarship_access' ); 
}

add_action( 'after_setup_theme', 'add_scholarship_caps_to_scholarship_editor');


// function add_scholarship_author_role() {
//     // Remove existing role (if any) to avoid duplicating capabilities
//     remove_role("scholarship_author");

//     // Check if the role already exists
//     $role = get_role( 'scholarship_author' );
//     if ( ! $role ) {
//         // Clone the capabilities of the 'author' role
//         $the_scholarship_author_capabilities = get_role( 'author' )->capabilities;

//         // Add the 'Scholarship Author' role with the cloned capabilities
//         add_role( 'scholarship_author', 'Scholarship Author', $the_scholarship_author_capabilities );
//     }
// }
// add_action( 'after_setup_theme', 'add_scholarship_author_role' );


// function add_scholarship_caps_to_scholarship_author() {


//    $scholarship_editor = get_role('scholarship_author');
    
//     $scholarship_editor->remove_cap('edit_ads');
//     $scholarship_editor->remove_cap('publish_ads');
//     $scholarship_editor->remove_cap('read_ads');
//     $scholarship_editor->remove_cap('read_private_ads');
//     $scholarship_editor->remove_cap('delete_ads');
//     $scholarship_editor->remove_cap('delete_private_ads');
//     $scholarship_editor->remove_cap('delete_published_ads');

//     // Add capabilities for institutions
    
//     $scholarship_editor->add_cap( 'read_institution' );
//     $scholarship_editor->add_cap( 'delete_institution' );
//     $scholarship_editor->add_cap( 'edit_institutions' );
//     $scholarship_editor->add_cap( 'publish_institutions' );
//     $scholarship_editor->add_cap( 'read_private_institutions' );
//     $scholarship_editor->add_cap( 'delete_institutions' );
//     $scholarship_editor->add_cap( 'delete_private_institutions' );
//     $scholarship_editor->add_cap( 'delete_published_institutions' );
    
//     $scholarship_editor->add_cap( 'edit_private_institutions' );
//     $scholarship_editor->add_cap( 'edit_published_institutions' );
//     $scholarship_editor->add_cap( 'manage_institution_terms' );
//     $scholarship_editor->add_cap( 'edit_institution_terms' );
//     $scholarship_editor->add_cap( 'delete_institution_terms' );
//     $scholarship_editor->add_cap( 'assign_institution_terms' );



  
//     $scholarship_editor->add_cap( 'read_scholarship' );
//     $scholarship_editor->add_cap( 'delete_scholarship' );
//     $scholarship_editor->add_cap( 'edit_scholarships' );
 
//     $scholarship_editor->add_cap( 'publish_scholarships' );
//     $scholarship_editor->add_cap( 'read_private_scholarships' );
//     $scholarship_editor->add_cap( 'delete_scholarships' );
//     $scholarship_editor->add_cap( 'delete_private_scholarships' );
//     $scholarship_editor->add_cap( 'delete_published_scholarships' );
    
//     $scholarship_editor->add_cap( 'edit_private_scholarships' );
//     $scholarship_editor->add_cap( 'edit_published_scholarships' );
//     $scholarship_editor->add_cap( 'manage_scholarship_terms' );
//     $scholarship_editor->add_cap( 'edit_scholarship_terms' );
//     $scholarship_editor->add_cap( 'delete_scholarship_terms' );
//     $scholarship_editor->add_cap( 'assign_scholarship_terms' );


// $scholarship_editor->add_cap( 'edit_city' );
// $scholarship_editor->add_cap( 'read_city' );
// $scholarship_editor->add_cap( 'delete_city' );
// $scholarship_editor->add_cap( 'edit_cities' );

// $scholarship_editor->add_cap( 'publish_cities' );
// $scholarship_editor->add_cap( 'read_private_cities' );
// $scholarship_editor->add_cap( 'delete_cities' );
// $scholarship_editor->add_cap( 'delete_private_cities' );
// $scholarship_editor->add_cap( 'delete_published_cities' );
// $scholarship_editor->add_cap( 'edit_private_cities' );
// $scholarship_editor->add_cap( 'edit_published_cities' );
// $scholarship_editor->add_cap( 'manage_city_terms' );
// $scholarship_editor->add_cap( 'edit_city_terms' );
// $scholarship_editor->add_cap( 'delete_city_terms' );
// $scholarship_editor->add_cap( 'assign_city_terms' );

//     $scholarship_editor->remove_cap('edit_ads');
//     $scholarship_editor->remove_cap('edit_others_ads');
//     $scholarship_editor->remove_cap('publish_ads');
//     $scholarship_editor->remove_cap('read_ads');
//     $scholarship_editor->remove_cap('read_private_ads');
//     $scholarship_editor->remove_cap('delete_ads');
//     $scholarship_editor->remove_cap('delete_published_ads');
//     $scholarship_editor->remove_cap('delete_others_ads');
//     $scholarship_editor->remove_cap('edit_published_ads');
//     $scholarship_editor->remove_cap('edit_private_ads');

// }

// add_action( 'after_setup_theme', 'add_scholarship_caps_to_scholarship_author');


function create_scholarship_author_role() {
    add_role(
        'scholarship_author',
        'Scholarship Author',
        array(
            'read' => true,
            'edit_scholarships' => true,
            'publish_scholarships' => true,
            'delete_scholarships' => true,
            'edit_published_scholarships' => true,
            'delete_published_scholarships' => true,
        )
    );
}
//add_action('init', 'create_scholarship_author_role');


function limit_scholarship_author_view( $query ) {
    global $pagenow;
    
    if ( 'edit.php' !== $pagenow || !current_user_can('scholarship_author') || !$query->is_admin ) {
        return $query;
    }

    $current_user = wp_get_current_user();
    $query->set( 'author', $current_user->ID );
    return $query;
}
add_filter( 'pre_get_posts', 'limit_scholarship_author_view' );



function remove_menu() {
    $current_user = wp_get_current_user();
    if (in_array('scholarship_editor', $current_user->roles) || in_array("scholarship_author", $current_user->roles)) {
        remove_menu_page('edit.php?post_type=ads');
        remove_menu_page('edit.php?post_type=adschool');
        remove_menu_page('edit.php?post_type=page');
         remove_menu_page('edit.php?post_type=post');
         remove_menu_page('edit.php?post_type=city');
        remove_menu_page('edit.php');
         remove_menu_page('upload.php');
         remove_menu_page('page=wpcf7');
          remove_menu_page('tools.php');
        
    }
}
add_action('admin_menu', 'remove_menu');




add_filter( 'rank_math/frontend/canonical', '__return_false' );



function change_title_placeholder_text( $title_placeholder, $post ) {
    if ( $post->post_type === 'scholarship_post' ) {
        $title_placeholder = 'Scholarship Recipient Name';
    }
    return $title_placeholder;
}
add_filter( 'enter_title_here', 'change_title_placeholder_text', 10, 2 );





function display_latest_scholarships() {
    ob_start();
   
    $args = array(
        'post_type' => 'scholarship_post',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="row">';
        
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="col-md-4">';
            echo '<div class="scholarship-item">';
            echo '<div class="featured-image">' . get_the_post_thumbnail() . '</div>';
            echo '<h2 style="font-family:Roboto, Arial, Helvetica, sans-serif;padding-left:0px;padding-top:10px;padding-bottom:5px;font-size:26px !important;" class="scholarship-title">' . get_the_title() . '</h2>';
            
            $brief_intro = get_field('brief_intro');
            $excerpt = substr($brief_intro, 0, 130);

            echo '<div class="scholarship-excerpt">' . $excerpt .  '....</div>';

            echo "<div class='meta-scholarship-blog' style='margin-top:-10px;margin-bottom:40px !important'>   <span style='float:left;'>"  . get_the_date() . "</span>  
            <a href='" . esc_url(get_permalink()) . "' style='color:#77a6cp !important;float:right;font-size:17px !important;'>  Read more >   </a>   </div>";
            
            echo '</div>'; // close scholarship-item
            echo '</div>'; // close col-md-4

        }
        
        echo '</div>'; // close row
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('latest_scholarships', 'display_latest_scholarships');



function enable_comments_on_all_posts() {
    $args = array(
        'post_status' => 'publish',
        'post_type' => ['post'],
        'fields' => 'ids' // Only get post IDs
    );

    $query = new WP_Query($args);

    // If posts were found
    if ($query->have_posts()) {
        // Loop through each post
        foreach ($query->posts as $post_id) {
            // Check if comment_status is not open
            $post = get_post($post_id);
            if($post->comment_status != 'open') {
                // Update post comment status
                wp_update_post(
                    array(
                        'ID' => $post_id,
                        'comment_status' => 'open',
                    )
                );
            }
        }
    }

    // Reset Post Data
    wp_reset_postdata();
}


add_action('enable_comments_on_all_posts', 'enable_comments_on_all_posts');

function enable_comments_on_custom_posts() {
    $args = array(
        'post_status' => 'publish',
        'post_type' => ['scholarships', 'institution'], // Added custom post types
        'fields' => 'ids' // Only get post IDs
    );

    $query = new WP_Query($args);

    // If posts were found
    if ($query->have_posts()) {
        // Loop through each post
        foreach ($query->posts as $post_id) {
            // Check if comment_status is not open
            $post = get_post($post_id);
            if($post->comment_status != 'open') {
                // Update post comment status
                wp_update_post(
                    array(
                        'ID' => $post_id,
                        'comment_status' => 'open',
                    )
                );
            }
        }
    }

    // Reset Post Data
    wp_reset_postdata();
}

add_action('enable_comments_on_custom_posts', 'enable_comments_on_custom_posts');



// Override comment form fields structure and remove url field from comment form at this path wp-content/plugins/fusion-builder/shortcodes/components/templates/fusion-tb-comments.php
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field(){
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ) ? ' aria-required="true"' : '';
	$html_req  = ( $req ) ? ' required="required"' : '';
	$name      = ( $req ) ? __( 'Name (required)', 'fusion-builder' ) : __( 'Name', 'fusion-builder' );
	$email     = ( $req ) ? __( 'Email (required)', 'fusion-builder' ) : __( 'Email', 'fusion-builder' );
	$html5     = ( 'html5' === current_theme_supports( 'html5', 'comment-form' ) ) ? 'html5' : 'xhtml';
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

    $fields = [];

    $fields['start_comment_container'] = '<div id="comment-input">';
	$fields['author']  = '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr( $name ) . '" size="30"' . $aria_req . $html_req . ' aria-label="' . esc_attr( $name ) . '"/>';
	$fields['email']   = '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr( $email ) . '" size="30" ' . $aria_req . $html_req . ' aria-label="' . esc_attr( $email ) . '"/>';
	$fields['url']     = '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'fusion-builder' ) . '" size="30" aria-label="' . esc_attr__( 'URL', 'fusion-builder' ) . '" />';
    $fields['end_comment_container'] = '</div>';
	$fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /><label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'fusion-builder' ) . '</label></p>';

    
	$fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /><label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'fusion-builder' ) . '</label></p>';

    if(isset($fields['url'])) {
        unset($fields['url']);
    }
    return $fields;

}


// Submit Feeback Form Logic
include ('submit-feedback.php'); 


// Adding Admin Page for Feedback Form Data Tables

function add_scholarship_admin_page()
{
    add_submenu_page(
        'edit.php?post_type=scholarships', // parent slug
        'Scholarships Feedback',             // page title
        'Feedback',             // menu title
        'scholarship_access',                   // capability
        'scholarships-form-feedback',             // menu slug
        'render_scholarship_settings_page'  // callback function
    );
}
add_action('admin_menu', 'add_scholarship_admin_page');

// function add_institutions_admin_page()
// {
//     add_submenu_page(
//         'edit.php?post_type=institution', // parent slug
//         'Instituitions Update Deadlines',             // page title
//         'Instituitions Update Deadlines',             // menu title
//         'scholarship_access',                   // capability
//         'instituitions-update-deadlines-meta',             // menu slug
//         'render_institutions_update_deadlines_meta_page'  // callback function
//     );
// }
// add_action('admin_menu', 'add_institutions_admin_page');

function render_scholarship_settings_page()
{
    // Add your custom admin page HTML here
    include('scholarships-feedback.php');
}

function render_institutions_update_deadlines_meta_page()
{
    // Add your custom admin page HTML here
    include('institutions-update-deadlines-meta.php');
}


function enqueue_scholarship_admin_scripts($hook_suffix)
{

    if ($hook_suffix == 'scholarships_page_scholarships-form-feedback') {
        wp_enqueue_script('feedback_bootstrap_javascript', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.js', array(), '5.3.0', true);

        wp_enqueue_style('feedback_bootstrap_css', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.css');
        wp_enqueue_style( 'feedback_datatables-css', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.css');
        wp_enqueue_script( 'feedback_datatables-js', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.js', array('jquery'), '1.10.25', true );
    
        wp_enqueue_script('feedback_table_js', get_stylesheet_directory_uri(). '/assets/feedback-table.js',  array('jquery', 'feedback_datatables-js'), '1.0.0', true);

        wp_enqueue_style( 'datatables-custom-style', get_stylesheet_directory_uri() . '/datatables.css', ['feedback_datatables-css'] );

    }

    // if ($hook_suffix == 'institution_page_instituitions-update-deadlines-meta') {
        

    //     wp_enqueue_script('gs_institutions_update',  get_stylesheet_directory_uri() . '/assets/institutions-deadlines.js', array('jquery'),
    //     '1.0.45',
    //     false );
    
        
    //     wp_localize_script( 'gs_institutions_update', 'my_ajax_object',
    //       array( 
    //         'ajax_url' => admin_url( 'admin-ajax.php' ),
    //       )
    //     );
    

    // }

    if ($hook_suffix == 'institution_page_acf-options-update-institutions-deadlines') {
        
        wp_enqueue_script('gs_institutions_update',  get_stylesheet_directory_uri() . '/assets/institutions-deadlines.js', array('jquery'),
        '1.0.45',
        false );
        
        wp_localize_script( 'gs_institutions_update', 'my_ajax_object',
          array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
          )
        );
    

    }


    if ($hook_suffix == 'edit-comments.php') {
        

        wp_enqueue_style('gs_comments',  get_stylesheet_directory_uri() . '/assets/gs-comments.css' );

    }


}
add_action('admin_enqueue_scripts', 'enqueue_scholarship_admin_scripts');




function add_custom_scripts() {
    ?>
    <script>
        window.addEventListener('load', function() {
    if (window.innerWidth > 767) {
        var megaMenus = document.querySelectorAll('.awb-menu__mega-wrap');
        megaMenus.forEach(function(megaMenu) {
            megaMenu.style.display = 'block';
        });
    }
});


jQuery(document).ready(function() {

    jQuery(".first-div").mouseenter(function() {
        var secondDiv = jQuery(this).next('.second-div');
        jQuery(this).fadeOut('slow', function() {
            secondDiv.fadeIn('slow');
        });
    });

    jQuery(".second-div").mouseleave(function() {
        var firstDiv = jQuery(this).prev('.first-div');
        jQuery(this).fadeOut('slow', function() {
            firstDiv.fadeIn('slow');
        });
    });
});



    </script>
    <?php
}
add_action('wp_footer', 'add_custom_scripts');

/**
 * New Comments enhancemetns 26/07/2023 
 * Remove the preposition (at) from the date
*/

/**
	 * The comment template.
	 *
	 * @access public
	 * @param Object     $comment The comment.
	 * @param array      $args    The comment arguments.
	 * @param int|string $depth   The comment depth.
	 */
	function fusion_comment( $comment, $args, $depth ) {
		$defaults = get_query_var( 'fusion_tb_comments_args' );
		?>
		<?php $add_below = ''; ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<div class="the-comment">
				<?php if ( 'hide' !== $defaults['avatar'] ) : ?>
				<div class="avatar"><?php echo get_avatar( $comment, 54 ); ?></div>
				<?php endif; ?>
				<div class="comment-box">
					<div class="comment-author meta">
						<strong><?php echo get_comment_author_link(); ?></strong>
						<?php
						printf(
							/* translators: %1$s: Comment date. %2$s: Comment time. */
							esc_attr__( '%1$s %2$s', 'fusion-builder' ),
							get_comment_date(), // phpcs:ignore WordPress.Security.EscapeOutput
							get_comment_time() // phpcs:ignore WordPress.Security.EscapeOutput
						);

						edit_comment_link( __( ' - Edit', 'fusion-builder' ), '  ', '' );

						comment_reply_link(
							array_merge(
								$args,
								[
									'reply_text' => __( ' - Reply', 'fusion-builder' ),
									'add_below'  => 'comment',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								]
							)
						);
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) : // phpcs:ignore WordPress.PHP.StrictComparisons ?>
							<em><?php esc_attr_e( 'Your comment is awaiting moderation.', 'fusion-builder' ); ?></em>
							<br />
						<?php endif; ?>
						<?php comment_text(); ?>
					</div>
				</div>
			</div>
		<?php
	}

// Remove comment date
function wpb_remove_comment_date($date, $d, $comment) { 
    return;
}
add_filter( 'get_comment_date', 'wpb_remove_comment_date', 10, 3);

// Remove comment time
function wpb_remove_comment_time($date, $d, $comment) { 
    return;
}
add_filter( 'get_comment_time', 'wpb_remove_comment_time', 10, 3);

/**
 * ACF SVG filter to allow raw SVG code.
 * https://www.advancedcustomfields.com/resources/html-escaping/
 * Source: https://support.advancedcustomfields.com/forums/topic/svg-code-getting-stripped-out-of-field/
 * 
 */
add_filter( 'wp_kses_allowed_html', 'acf_add_allowed_svg_tag', 10, 2 );

function acf_add_allowed_svg_tag( $tags, $context ) {
    if ( $context === 'acf' ) {
        $tags['svg']  = array(
            'xmlns'				=> true,
			'width'			=> true,
			'height'		=> true,
			'preserveAspectRatio'	=> true,
            'fill'				=> true,
            'viewbox'				=> true,
            'role'				=> true,
            'aria-hidden'			=> true,
            'focusable'				=> true,
        );
        $tags['path'] = array(
            'd'    => true,
            'fill' => true,
        );
    }

    return $tags;
}

// Allow Shortcode in textarea in ACF fields for Contact Form 7
add_filter('acf/format_value/type=textarea', 'do_shortcode');


function enable_comments_on_custom_post_types() {
    global $wpdb;
    $post_types = array( 'scholarships', 'institution' );

    foreach ( $post_types as $post_type ) {
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE $wpdb->posts SET comment_status = 'open' WHERE post_type = %s",
                $post_type
            )
        );
    }
}
// add_action( 'init', 'enable_comments_on_custom_post_types' );



/**
 * Get Number of Cities for Published Institutions
 * 
 */

 function get_institutions_cities() {

    $fileName = "published_cities_institutions.json";

    $args = array(
        'post_type' => 'institution',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $institutions_ids = get_posts($args);

    $cities = array();
    foreach($institutions_ids as $id) {
        $get_cities = get_field('cities', $id);
        if(!in_array($get_cities, $cities)) {
            $cities[] = $get_cities;
        }

    }

    $post_ids = wp_list_pluck( $cities, 'ID' );

    $posts = json_encode($post_ids, true);
    // Write the JSON string to a new file named "data.json"
    file_put_contents($fileName, $posts);

}
add_action('get_institutions_cities', 'get_institutions_cities');



/**
 * Get the Countries for Published Institutions
 */

function get_the_countries() {

    $file =  'published_cities_institutions.json';

    $json = file_get_contents($file);

    $data = json_decode($json, true);
    
    $countries = [];

    foreach($data as $id) {
        $get_countries = get_field('country', $id);
        
        if(!in_array($get_countries, $countries)) {
            $countries[] = $get_countries;
        }

    }

    
    // Store the countries in json file
    $json_data = json_encode($countries);
    file_put_contents('published_gs_countries.json', $json_data);

    // return $countries;
}

add_action('get_the_countries', 'get_the_countries');


function get_gs_countries() {
        
    // Get the JSON data from the file
    $json_data = file_get_contents('published_gs_countries.json');

    // Decode the JSON data into an array
    $countries = json_decode($json_data, true);

    return $countries;

}

/**
 * Get Number of Cities for Published Institutions
 * 
 */

 function get_institutions_by_country_name($country_name) {

    // $fileName = "published_cities_institutions.json";

    $args = array(
        'post_type' => 'institution',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
    );
    $institutions_ids = get_posts($args);

    $cities = array();
    foreach($institutions_ids as $id) {
        $get_cities = get_field('cities', $id);
            $cities[] = $get_cities;

    }

    return $cities;
}


//This function outputs all the institutions given a Country name
//If found, it returns the institutions in that Country
//If not found, it returns an empty loop
//It is used for url like all-universities-Country, where it takes Country and checks for institutions in that Country
//If the given Country is a city, state, country, or continent, the it outputs the instituitons
//If not, it returns empty.
//Example: input: Korea, output: all the institutions in country korea
//Example: input: test, output: empty since there's no Country named test
function get_institutions_by_country($country){
    
    //Direct City Match
    $city_args = array(
        'post_type' => 'city',
        'title' => $country,
    );
    
    $the_query = new WP_Query($city_args);

    //Make an empty new query. If $the_query has posts (that is city with location is found), then assign $loop with institutions. 

    $loop = new WP_Query();

    if ($the_query->have_posts()) {
        while ( $the_query->have_posts() ){
            $the_query->the_post();
            $the_post_id = get_the_id();
            
            $institute_args = array(
                'post_type' => 'institution',
                'post_status' => 'publish',
                'meta_key' => "cities",
                'posts_per_page' => -1,             
                "meta_value" => $the_post_id,
                'no_found_rows' => true, 
                'update_post_meta_cache' => false, 
                'update_post_term_cache' => false,   
                'cache_results'          => false,
                'fields' => 'ids',                             
                
            );                  
        };
                
        $loop = new WP_Query($institute_args); 

        //Return $loop if it has a direct match
        return $loop;
        
    };
    
   //This code doesn't run if city match is found


    $loop = get_cities_location($country, "country");
    
    //return if country has posts 
    if ($loop->have_posts()){
        return $loop;
    };     

    
    return $loop;
};


function get_scholarships_by_country($country) {
    $loop = get_institutions_by_country($country);
    $institute_ids = $loop->get_posts();
    $scholarships = [];
    foreach ($institute_ids as $institute_id) {
        $query = get_scholarships($institute_id);
        if ($query->have_posts()) {
            $scholarships[$institute_id] = $query->get_posts();
        }
    }
    return [
        'country' => $country,
        'institutions' => $institute_ids,
        'scholarships' => $scholarships,
    ];
}


/**
 * Retrieves the author who last edited the post id.
 *
 * @since 2.8.0
 *
 * @return string|void The author's display name, empty string if unknown.
 */
function get_the_last_modified_user_name($id) {
	$last_id = get_post_meta( $id, '_edit_last', true );

	if ( $last_id ) {
		$last_user = get_userdata( $last_id );

		/**
		 * Filters the display name of the author who last edited the current post.
		 *
		 * @since 2.8.0
		 *
		 * @param string $display_name The author's display name, empty string if unknown.
		 */
		return apply_filters( 'last_author_modified', $last_user ? $last_user->display_name : '' );
	}
}







function cta_shortcode($atts) {
    
    // Get the ACF fields
    $cta_details  = acf_get_fields('group_64ecee859ce7e');
    $title_array = array_column($cta_details, null, 'name')['title'];
    $default_title = $title_array["default_value"];

    $description_array = array_column($cta_details, null, 'name')['description'];
    $default_description = $description_array["default_value"];

    $image_array = array_column($cta_details, null, 'name')['image_link'];
    $default_image = $image_array["default_value"];

    $link_array = array_column($cta_details, null, 'name')['link_url'];
    $default_link = $link_array["default_value"];


    https://env-globalscholarshipsa-sibi.kinsta.cloud/best-fashion-schools-germany/
    
    $args = shortcode_atts(array(
        'title' => $default_title,  // Use the ACF default title
        'desc' => $default_description, // Provide a default description
        'img_url' => $default_image, // Provide a default image URL
        'link_url' =>  $default_link, // Provide a default link URL for Apply now
    ), $atts);

    // Construct the output
    $output = '<div class="container mt-5 cta-container">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div class="row">
          
            <div class="col-md-4 col-sm-12 text-center ">
                <img src="' . esc_url($args['img_url']) . '" alt="Description" class="img-fluid cta-image">
                
            </div>
            
          
            <div class="col-md-8 col-sm-12">
                <h2 style="font-size:30px;">' . esc_html($args['title']) . '</h2>
                <p>' . esc_html($args['desc']) . '</p>
                <a class="apply-now" href="' . esc_url($args['link_url']) . '" style="color:#0055F9 !important;">   Apply now   <i style="margin-top:3px;width:20px;margin-left:5px;color:#0055F9 !important;" class="fa fa-long-arrow-right"> </i> </a>
            </div>
        </div>
    </div>';

    return $output;
}

// Register the shortcode
add_shortcode('cta_shortcode', 'cta_shortcode');


function courses_grid_shortcode() {
    ob_start(); // Start output buffering
   
    $args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 3,
      
      
        'order' => 'DESC',
    );

    $new_loop = new WP_Query($args);
    ?>

    <div class="container courses-grid"  style="">
        <div class="row" style="padding-left:20px !important;padding-right:20px;">
        <?php 
        if ($new_loop->have_posts()) : 
            while ($new_loop->have_posts()) : $new_loop->the_post();

                $ad_id = get_the_ID();

                // You can access custom fields or meta data using get_post_meta()
                $image_url = get_the_post_thumbnail_url();
                $course_title = get_the_title();
                $institute = get_post(get_post_meta(get_the_ID(), 'adsInstitution', true));

                $domestic_tuition_fees_INT = get_post_meta($institute->ID, 'domestic_tuition_fees' , true);
$international_tuition_fees_INT = get_post_meta($institute->ID, 'international_tuition_fees' , true);

$domestic_tuition_fees = get_post_meta($ad_id, 'domestic_tuition_fees' , true);
$international_tuition_fees = get_post_meta($ad_id, 'international_tuition_fees' , true);

$country = get_post_meta($institute->ID, 'adsIntCountry', true);

$currency = get_currency($country);

$language_of_instructions_AdsInt = get_post_meta($institute->ID, 'language_of_instructions', true);
$language_of_instructions_ads = get_post_meta($ad_id, 'language_of_instructions' , true);

 $des = get_post_meta($ad_id, 'description', true);

 $disclaimer = get_post_meta($institute->ID, 'show_disclaimer', true);


$link_post_meta = get_post_meta($ad_id, 'link', true);
if (!empty($link_post_meta)){
  
    $link = $link_post_meta;
} else {
  
    $link = get_post_meta($institute->ID, 'adsIntLink', true);
}

                    $language_of_instruction = "";
                    if($language_of_instructions_ads){
                      $language_of_instruction = $language_of_instructions_ads;
                    } else if($language_of_instructions_AdsInt){
                      $language_of_instruction = $language_of_instructions_AdsInt; }
                      else {
                      $language_of_instruction = "English";
                    }
                   
                    

                
                $log_url = get_the_post_thumbnail_url($institute->ID);
                $image_url = "https://env-globalscholarshipsa-sibi.kinsta.cloud/wp-content/uploads/2023/08/c7eb49b396dc06f16c576792f2086aa9.jpeg";


                $logo_url = get_the_post_thumbnail_url($institute->ID);
                // Replace these with your actual meta data or custom field keys
                
                //$logo_url = get_post_meta(get_the_ID(), 'logo_key', true); 
                $flag_url = get_post_meta(get_the_ID(), 'flag_key', true);

               ?>


                <div class="col-md-4 course-item" style="width:31%;margin-right:2%;">
                    <div  class="course-image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="Course Image">
                    </div>
                    <div class="course-grid-dev first-div">
                    <div class="course-text" style="min-height: 90px;margin-top:0px;">
                        
                        <div class="col-md-3 course-logo">
                            <img  style="width:60px;height: 60px;" src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                        </div>
                        
                        <div class="col-md-7 course-title" style="padding-right:10px;padding-left:3px;font-size:16px;
                        line-height:20px !important;
                        font-weight: 700 !important;">
                            <?php echo esc_html($course_title); ?>
                        </div>

                        <div class="col-md-2 course-flag">
                            <img src="https://env-globalscholarshipsa-sibi.kinsta.cloud/wp-content/uploads/2023/08/twemoji_flag-germany.png">
                        </div>
                    </div>

                  <div class="course-text" style="margin-top:0px !important;">
                   
                   <p style="height:60px;font-weight:600;padding-left:15px;padding-right:15px;font-size:18px;line-height: 22px;"> <?php echo $institute->post_title; ?></p>


                  </div>

                  <div class="course-text" style="margin-top:0px;">
                   
                   <p style="text-align:center;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">Annual Tuition Fee* </p>


                  </div>


                   <div class="course-text" style="padding-top:0px;margin-top:0px;border-radius:8px;width:86% !important;margin:auto;background:#F2F8FF;padding-left:0px;padding-right:0px;padding-top:7px;padding-bottom:7px;">

                    <div style="border-right:2px solid #cdcdcd;width:100% !important;">  
                    
                    <p style="text-align: center;font-size:15px;line-height: 23px;"> 
                    <span style="line-height:16px;font-weight: 700 !important;font-size:13px;text-align:center;">  Domestic  </span>  <br>
                    <?php if($domestic_tuition_fees){
                        echo number_format($domestic_tuition_fees)  ." ". $currency;
                      }  elseif($domestic_tuition_fees_INT) {
                        
                        echo number_format($domestic_tuition_fees_INT)  ." ". $currency;
                      }else {
                        
                        echo "N/A";
                      }
                     ?>

                </p> 

                    </div>
                   
                   
                   
                    <div style="width:100% !important;">  
                    
                    <p style="text-align: center;font-size:15px;line-height: 23px;" > 
                    <span style="line-height:16px;font-weight: 700 !important;font-size:13px;text-align:center;">  International  </span> <br> 
                    <?php
                      
                      if($international_tuition_fees){
                        echo number_format($international_tuition_fees) ." ".  $currency ;
                      }  elseif ($international_tuition_fees_INT)  {
                       
                        echo number_format($international_tuition_fees_INT)  ." ". $currency;
                      }else {

                           echo "N/A";
                      
                     }

                       ?> 
                    </p> 

                    </div>

                  </div>

                     <div class="course-text" style="margin-bottom:20px !important;margin-top:20px;float:right;">
                   
                   <p style="float:right;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">
                       
                       <span style="width:32px;">
                        <img style="width:24px;height: 24px;margin-right:4px;" src="<?php echo site_url(); ?>/wp-content/uploads/2023/07/language.png">
                         </span> 

                    <span style="color:gray; width: calc(100% - 32px) !important; line-height: 24px;"><?php echo $language_of_instruction; ?></span>

                   </p>


                  </div>

                   </div>


                   <div class="course-grid-dev second-div" style="display: none;">
                    <div class="course-text" style="min-height: 90px;margin-top:0px;">
                        
                        <div class="col-md-3 course-logo">
                            <img  style="width:60px;height: 60px;" src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                        </div>
                        
                        <div class="col-md-9 course-title" style="padding-right:10px;padding-left:3px;font-size:16px;
                        line-height:20px !important;
                        font-weight: 700 !important;">
                            <?php echo esc_html($course_title); ?>
                        </div>

                        
                    </div>

                  <div class="course-text institution-title" style="margin-top:0px !important;">
                   
                   <p style="height:60px;font-weight:600;padding-left:15px;padding-right:15px;font-size:18px;line-height: 22px;"> <?php echo $institute->post_title; ?></p>


                  </div>

                  <div class="course-text" style="margin-top:-10px !important;">
                   
                   <p style="text-align:left;padding-left:15px;padding-right:15px;font-size:13px;line-height: 22px;">   
                      
                      <?php  if (strlen($des) > 110) {
    $des = substr($des, 0, 110);
    $des = $des . '...  <span class="read-more" style="font-size:12px;font-weight:600;margin-left:5px;border-bottom:1px solid #77a6c9 ;color:#77a6c9;"> Read More </span>';
}

echo $des;
                             ?>
                     </p>


                  </div>

                    <div class="course-text" style="margin-top:-5px !important;">
                   
                   <p style="line-height: 18px;">   
                      
                      <?php   if($disclaimer === "1")  {  ?>
                         
                         <strong style="line-height:16px;padding-left:0px;font-size:12px;padding-right:10px;font-weight:700 !important;" > *<?php echo $institute->post_title; ?>  does not offer fully-funded scholarships.  </strong>

                     <?php } ?>
                     
                     </p>


                  </div>




                   

<div class="course-text" style="margin-bottom:20px !important;margin-top:5px;float:left;">
                   
                   <p style="float:right;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">
                       
                       <a style="font-weight:500;font-size:16px;text-decoration:none;color:black !important;" href="<?php  echo $link; ?>"> Learn more <i  style="font-size:16px !important;color:black;margin-left:5px;" 
                        class="fa fa-long-arrow-right">  </i></a>
                   
                    

                   </p>


                  </div>

                   </div>
                   

                    


                </div>
        <?php 
            endwhile;
        endif;
        ?>
        </div>
    </div>

    <?php
    return ob_get_clean(); // Return buffered output
}
add_shortcode('courses_grid_shortcode', 'courses_grid_shortcode');


function courses_grid_shortcode() {
    ob_start(); // Start output buffering
   
    $args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 3,
      
      
        'order' => 'DESC',
    );

    $new_loop = new WP_Query($args);
    ?>

    <div class="container courses-grid"  style="">
        <div class="row" style="padding-left:20px !important;padding-right:20px;">
        <?php 
        if ($new_loop->have_posts()) : 
            while ($new_loop->have_posts()) : $new_loop->the_post();

                $ad_id = get_the_ID();

                // You can access custom fields or meta data using get_post_meta()
                $image_url = get_the_post_thumbnail_url();
                $course_title = get_the_title();
                $institute = get_post(get_post_meta(get_the_ID(), 'adsInstitution', true));

                $domestic_tuition_fees_INT = get_post_meta($institute->ID, 'domestic_tuition_fees' , true);
$international_tuition_fees_INT = get_post_meta($institute->ID, 'international_tuition_fees' , true);

$domestic_tuition_fees = get_post_meta($ad_id, 'domestic_tuition_fees' , true);
$international_tuition_fees = get_post_meta($ad_id, 'international_tuition_fees' , true);

$country = get_post_meta($institute->ID, 'adsIntCountry', true);

$currency = get_currency($country);

$language_of_instructions_AdsInt = get_post_meta($institute->ID, 'language_of_instructions', true);
$language_of_instructions_ads = get_post_meta($ad_id, 'language_of_instructions' , true);

 $des = get_post_meta($ad_id, 'description', true);

 $disclaimer = get_post_meta($institute->ID, 'show_disclaimer', true);


$link_post_meta = get_post_meta($ad_id, 'link', true);
if (!empty($link_post_meta)){
  
    $link = $link_post_meta;
} else {
  
    $link = get_post_meta($institute->ID, 'adsIntLink', true);
}

                    $language_of_instruction = "";
                    if($language_of_instructions_ads){
                      $language_of_instruction = $language_of_instructions_ads;
                    } else if($language_of_instructions_AdsInt){
                      $language_of_instruction = $language_of_instructions_AdsInt; }
                      else {
                      $language_of_instruction = "English";
                    }
                   
                    

                
                $log_url = get_the_post_thumbnail_url($institute->ID);
                $image_url = "https://env-globalscholarshipsa-sibi.kinsta.cloud/wp-content/uploads/2023/08/c7eb49b396dc06f16c576792f2086aa9.jpeg";


                $logo_url = get_the_post_thumbnail_url($institute->ID);
                // Replace these with your actual meta data or custom field keys
                
                //$logo_url = get_post_meta(get_the_ID(), 'logo_key', true); 
                $flag_url = get_post_meta(get_the_ID(), 'flag_key', true);

               ?>


                <div class="col-md-4 course-item" style="width:31%;margin-right:2%;">
                    <div  class="course-image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="Course Image">
                    </div>
                    <div class="course-grid-dev first-div">
                    <div class="course-text" style="min-height: 90px;margin-top:0px;">
                        
                        <div class="col-md-3 course-logo">
                            <img  style="width:60px;height: 60px;" src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                        </div>
                        
                        <div class="col-md-7 course-title" style="padding-right:10px;padding-left:3px;font-size:16px;
                        line-height:20px !important;
                        font-weight: 700 !important;">
                            <?php echo esc_html($course_title); ?>
                        </div>

                        <div class="col-md-2 course-flag">
                            <img src="https://env-globalscholarshipsa-sibi.kinsta.cloud/wp-content/uploads/2023/08/twemoji_flag-germany.png">
                        </div>
                    </div>

                  <div class="course-text" style="margin-top:0px !important;">
                   
                   <p style="height:60px;font-weight:600;padding-left:15px;padding-right:15px;font-size:18px;line-height: 22px;"> <?php echo $institute->post_title; ?></p>


                  </div>

                  <div class="course-text" style="margin-top:0px;">
                   
                   <p style="text-align:center;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">Annual Tuition Fee* </p>


                  </div>


                   <div class="course-text" style="padding-top:0px;margin-top:0px;border-radius:8px;width:86% !important;margin:auto;background:#F2F8FF;padding-left:0px;padding-right:0px;padding-top:7px;padding-bottom:7px;">

                    <div style="border-right:2px solid #cdcdcd;width:100% !important;">  
                    
                    <p style="text-align: center;font-size:15px;line-height: 23px;"> 
                    <span style="line-height:16px;font-weight: 700 !important;font-size:13px;text-align:center;">  Domestic  </span>  <br>
                    <?php if($domestic_tuition_fees){
                        echo number_format($domestic_tuition_fees)  ." ". $currency;
                      }  elseif($domestic_tuition_fees_INT) {
                        
                        echo number_format($domestic_tuition_fees_INT)  ." ". $currency;
                      }else {
                        
                        echo "N/A";
                      }
                     ?>

                </p> 

                    </div>
                   
                   
                   
                    <div style="width:100% !important;">  
                    
                    <p style="text-align: center;font-size:15px;line-height: 23px;" > 
                    <span style="line-height:16px;font-weight: 700 !important;font-size:13px;text-align:center;">  International  </span> <br> 
                    <?php
                      
                      if($international_tuition_fees){
                        echo number_format($international_tuition_fees) ." ".  $currency ;
                      }  elseif ($international_tuition_fees_INT)  {
                       
                        echo number_format($international_tuition_fees_INT)  ." ". $currency;
                      }else {

                           echo "N/A";
                      
                     }

                       ?> 
                    </p> 

                    </div>

                  </div>

                     <div class="course-text" style="margin-bottom:20px !important;margin-top:20px;float:right;">
                   
                   <p style="float:right;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">
                       
                       <span style="width:32px;">
                        <img style="width:24px;height: 24px;margin-right:4px;" src="<?php echo site_url(); ?>/wp-content/uploads/2023/07/language.png">
                         </span> 

                    <span style="color:gray; width: calc(100% - 32px) !important; line-height: 24px;"><?php echo $language_of_instruction; ?></span>

                   </p>


                  </div>

                   </div>


                   <div class="course-grid-dev second-div" style="display: none;">
                    <div class="course-text" style="min-height: 90px;margin-top:0px;">
                        
                        <div class="col-md-3 course-logo">
                            <img  style="width:60px;height: 60px;" src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                        </div>
                        
                        <div class="col-md-9 course-title" style="padding-right:10px;padding-left:3px;font-size:16px;
                        line-height:20px !important;
                        font-weight: 700 !important;">
                            <?php echo esc_html($course_title); ?>
                        </div>

                        
                    </div>

                  <div class="course-text institution-title" style="margin-top:0px !important;">
                   
                   <p style="height:60px;font-weight:600;padding-left:15px;padding-right:15px;font-size:18px;line-height: 22px;"> <?php echo $institute->post_title; ?></p>


                  </div>

                  <div class="course-text" style="margin-top:-10px !important;">
                   
                   <p style="text-align:left;padding-left:15px;padding-right:15px;font-size:13px;line-height: 22px;">   
                      
                      <?php  if (strlen($des) > 110) {
    $des = substr($des, 0, 110);
    $des = $des . '...  <span class="read-more" style="font-size:12px;font-weight:600;margin-left:5px;border-bottom:1px solid #77a6c9 ;color:#77a6c9;"> Read More </span>';
}

echo $des;
                             ?>
                     </p>


                  </div>

                    <div class="course-text" style="margin-top:-5px !important;">
                   
                   <p style="line-height: 18px;">   
                      
                      <?php   if($disclaimer === "1")  {  ?>
                         
                         <strong style="line-height:16px;padding-left:0px;font-size:12px;padding-right:10px;font-weight:700 !important;" > *<?php echo $institute->post_title; ?>  does not offer fully-funded scholarships.  </strong>

                     <?php } ?>
                     
                     </p>


                  </div>




                   

<div class="course-text" style="margin-bottom:20px !important;margin-top:5px;float:left;">
                   
                   <p style="float:right;padding-left:15px;padding-right:15px;font-size:15px;line-height: 22px;">
                       
                       <a style="font-weight:500;font-size:16px;text-decoration:none;color:black !important;" href="<?php  echo $link; ?>"> Learn more <i  style="font-size:16px !important;color:black;margin-left:5px;" 
                        class="fa fa-long-arrow-right">  </i></a>
                   
                    

                   </p>


                  </div>

                   </div>
                   

                    


                </div>
        <?php 
            endwhile;
        endif;
        ?>
        </div>
    </div>

    <?php
    return ob_get_clean(); // Return buffered output
}
add_shortcode('courses_grid_shortcode', 'courses_grid_shortcode');


/**
 * Update Institutions Post Meta for Country and Continent using ACF cities and CPT city
 * 
 */
function update_country_meta() {
   // Get the current offset
    $offset = 0;
    $batchSize = 20;
    $postType = 'institution';

    $institution_posts_count = wp_count_posts($postType);
    $institution_posts_count_published = $institution_posts_count->publish;

    while ($offset <  intval($institution_posts_count_published)) {

        $the_args = array(
        'post_type' => $postType,
        'posts_per_page' => $batchSize,
        'offset' => $offset,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        );

        $the_query = new WP_Query($the_args);
        $thePosts = $the_query->get_posts();

        // If there are no more scholarships to process, break out of the loop
        if ($the_query->have_posts() == false) {
            break;
        }

        foreach($thePosts as $id) {

            $getCities = get_field('cities', $id);
            if(is_object($getCities)) {
                $getCitiesIds = $getCities->ID;
            }
            $theCountryNamePost = get_field('country', $getCitiesIds);
            $theContinentNamePost = get_field('continent', $getCitiesIds);
            update_field('location_country', $theCountryNamePost, $id);
            update_field('location_continent', $theContinentNamePost, $id);

            
        }

        $offset += $batchSize;

    }
    
  }
  add_action('update_country_meta', 'update_country_meta');
