<?php
include ('functions/scholarships-functions.php'); 
// Added Synchronization Options Page (SAA DB institutions to GS ACF export page )
include ('scripts/acf-options.php'); 
include ('scripts/institutions-script.php'); 
include ('scripts/saa-cities-cpt.php'); 
include ('ajax-search.php'); 
include ('ajax-scholarship-search.php'); 

include ('google-callback.php'); 


// filter
function institutions_where( $where ) {
    $where = str_replace("meta_key = 'admission_deadlines_$", "meta_key LIKE 'admission_deadlines_%", $where);
    return $where;
}
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

// function serach_script_enqueue() {
//     if (!is_page_template('page-homepage.php')) {
//         return;
//     }
//     wp_enqueue_script('search_js', get_stylesheet_directory_uri() . '/assets/search.js', array('jquery'), '1.0.0', true);
// }
// add_action('wp_enqueue_scripts', 'serach_script_enqueue');

function theme_enqueue_styles() {
    wp_enqueue_style( 'dashicons' );

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [] );
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('scholarships')) {
        wp_enqueue_script('single-scholarship',  get_stylesheet_directory_uri() . '/assets/single-scholarship.js', array('jquery'), '1.0.0', true);
        wp_localize_script( 'single-scholarship', 'frontendajax', array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));
    }
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [] );
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('ext-scholarships')) {
        wp_enqueue_script('single-ext-scholarship',  get_stylesheet_directory_uri() . '/assets/single-ext-scholarship.js', array('jquery'), '1.0.0', true);
        wp_localize_script( 'single-ext-scholarship', 'frontendajax', array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));
    }
    // Enqueue single-institution.js file in assets folder
    if(is_singular('institution')) {
        wp_enqueue_script('single-institution',  get_stylesheet_directory_uri() . '/assets/single-institution.js', array('jquery'), '1.0.0', true);
        // wp_localize_script( 'single-scholarship', 'frontendajax', array( 
        //     'ajaxurl' => admin_url( 'admin-ajax.php' )
        // ));

        
    }
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('institution') || is_singular('scholarships')) {
        wp_enqueue_script('gs-comments',  get_stylesheet_directory_uri() . '/assets/gs-comments.js', array('jquery'), '1.0.0', true);
    }

    wp_enqueue_script('gs_scholarships_update',  get_stylesheet_directory_uri() . '/assets/update-scholarships.js', array('jquery'),
    '1.0.45',
    false );


    wp_enqueue_script('gs_toc_toggle',  get_stylesheet_directory_uri() . '/assets/toc.js', array('jquery'),
    '1.0.45',
    false );


    wp_enqueue_script('google-platform', 'https://accounts.google.com/gsi/client', array(), null, true);
   wp_enqueue_script('gs_modal-login',  get_stylesheet_directory_uri() . '/assets/login-modal.js', array('jquery','google-platform'),
    '1.0.45',
    true );
    
    wp_localize_script('gs_modal-login', 'myAjax', 
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'client_id' => "332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com",
            'redirect_uri' => site_url('/google-callback'),
        )
    );

    wp_localize_script( 'gs_scholarships_update', 'my_ajax_object',
      array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
      )
    );

     wp_localize_script('mytheme-script', 'myThemeParams', array(
        'themeBaseUrl' => get_template_directory_uri()
    ));

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );
function make_script_async( $tag, $handle, $src )
{
    if ( 'google-platform' != $handle ) {
        return $tag;
    }

    return str_replace( '<script', '<script async', $tag );
}

add_filter( 'script_loader_tag', 'make_script_async', 10, 3 );
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




function scholarship_search_enqueue_scripts() {
    if (is_page('scholarship-search')) {

        wp_enqueue_style( 'scholarship-search-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css' );
        
        wp_enqueue_style( 'scholarship-search-bootstrap-select-css', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css' );
        
        // Enqueue jQuery if it's not already included
        if (!wp_script_is('jquery', 'enqueued')) {
            wp_enqueue_script( 'jquery' );
        }

        // Set the last parameter to true to load it in the footer
        wp_enqueue_script( 'scholarship-search-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', array('jquery'), null, true );

        wp_enqueue_script( 'scholarship-search-bootstrap-select-js', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js', array('jquery', 'scholarship-search-bootstrap-js'), null, true );

        wp_enqueue_script( 'scholarship-search-bootstrap-select-i18n-js', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js', array('jquery', 'scholarship-search-bootstrap-select-js'), null, true );

    }
}
add_action( 'wp_footer', 'scholarship_search_enqueue_scripts' );




function my_deregister_scripts(){
   wp_dequeue_script('wp-embed');
   wp_dequeue_script('comment-reply');
}

add_action( 'wp_footer', 'my_deregister_scripts' );


// add_action( 'wp_enqueue_scripts', 'custom_disable_theme_js' );

// function custom_disable_theme_js() {

//     Fusion_Dynamic_JS::deregister_script('avada-comments');
//     Fusion_Dynamic_JS::deregister_script('avada-general-footer');
//     Fusion_Dynamic_JS::deregister_script('avada-mobile-image-hover');
//     Fusion_Dynamic_JS::deregister_script('avada-quantity');
//     Fusion_Dynamic_JS::deregister_script('avada-scrollspy');
//     Fusion_Dynamic_JS::deregister_script('avada-select');
//     Fusion_Dynamic_JS::deregister_script('avada-sidebars');
//     Fusion_Dynamic_JS::deregister_script('avada-tabs-widget');

//     Fusion_Dynamic_JS::deregister_script('bootstrap-collapse');
//     Fusion_Dynamic_JS::deregister_script('bootstrap-modal');
//     Fusion_Dynamic_JS::deregister_script('bootstrap-popover');
//     Fusion_Dynamic_JS::deregister_script('bootstrap-scrollspy');
//     //Fusion_Dynamic_JS::deregister_script('bootstrap-tab'); //Helps with tabs
//     Fusion_Dynamic_JS::deregister_script('bootstrap-tooltip');
//     //Fusion_Dynamic_JS::deregister_script('bootstrap-transition'); //Helps with transition in the tabs
    
//     //Fusion_Dynamic_JS::deregister_script('cssua'); /Helps with flexslider


    
//     Fusion_Dynamic_JS::deregister_script('fusion-alert');
//     //Fusion_Dynamic_JS::deregister_script('fusion-blog'); // !
//     //Fusion_Dynamic_JS::deregister_script('fusion-button'); // !
//     Fusion_Dynamic_JS::deregister_script('fusion-carousel');
//     Fusion_Dynamic_JS::deregister_script('fusion-chartjs');
//     Fusion_Dynamic_JS::deregister_script('fusion-column-bg-image');
//     Fusion_Dynamic_JS::deregister_script('fusion-count-down');
//     Fusion_Dynamic_JS::deregister_script('fusion-equal-heights');

//     //Fusion_Dynamic_JS::deregister_script('fusion-flexslider');
//     Fusion_Dynamic_JS::deregister_script('fusion-image-before-after');
//     //Fusion_Dynamic_JS::deregister_script('fusion-lightbox'); //Helps with the alignment of posts and loading
//     Fusion_Dynamic_JS::deregister_script('fusion-parallax'); // !
//     Fusion_Dynamic_JS::deregister_script('fusion-popover');


//     Fusion_Dynamic_JS::deregister_script('fusion-recent-posts');
//     Fusion_Dynamic_JS::deregister_script('fusion-sharing-box');
//     Fusion_Dynamic_JS::deregister_script('fusion-syntax-highlighter');


//     //Fusion_Dynamic_JS::deregister_script('fusion-title');
//     Fusion_Dynamic_JS::deregister_script('fusion-tooltip');
//     //Fusion_Dynamic_JS::deregister_script('fusion-video-bg'); These both help with the loading for index page
//     //Fusion_Dynamic_JS::deregister_script('fusion-video-general');
//     //Fusion_Dynamic_JS::deregister_script('fusion-waypoints'); Needed for tabs
    


    
//     //Fusion_Dynamic_JS::deregister_script('images-loaded'); // ! Helps with infinite scroll
//     //Fusion_Dynamic_JS::deregister_script('isotope'); // !! Helps with infinite scroll


    
//     Fusion_Dynamic_JS::deregister_script('jquery-appear');
//     Fusion_Dynamic_JS::deregister_script('jquery-caroufredsel');
//     Fusion_Dynamic_JS::deregister_script('jquery-count-down');
//     Fusion_Dynamic_JS::deregister_script('jquery-count-to');
//     Fusion_Dynamic_JS::deregister_script('jquery-easy-pie-chart');
//     Fusion_Dynamic_JS::deregister_script('jquery-event-move');


//     Fusion_Dynamic_JS::deregister_script('jquery-fade'); // !!
//     //Fusion_Dynamic_JS::deregister_script('jquery-fitvids'); Helps with homepage video
//     Fusion_Dynamic_JS::deregister_script('jquery-fusion-maps');



//     Fusion_Dynamic_JS::deregister_script('jquery-hover-flow');
//     Fusion_Dynamic_JS::deregister_script('jquery-hover-intent');

//     //Fusion_Dynamic_JS::deregister_script('jquery-infinite-scroll'); // !
//     //Fusion_Dynamic_JS::deregister_script('jquery-lightbox'); Helps with infinite scroll and image loading

//     //Fusion_Dynamic_JS::deregister_script('jquery-mousewheel'); // ! Helps with infinite scroll and image loading
//     Fusion_Dynamic_JS::deregister_script('jquery-placeholder');
//     Fusion_Dynamic_JS::deregister_script('jquery-request-animation-frame');


//     Fusion_Dynamic_JS::deregister_script('jquery-sticky-kit');
//     Fusion_Dynamic_JS::deregister_script('jquery-to-top');
//     Fusion_Dynamic_JS::deregister_script('jquery-touch-swipe'); // !
//     Fusion_Dynamic_JS::deregister_script('jquery-waypoints'); // !


//                                                 Fusion_Dynamic_JS::deregister_script('lazysizes');
//     //Fusion_Dynamic_JS::deregister_script('packery'); // !! Helps with loading images
//     Fusion_Dynamic_JS::deregister_script('vimeo-player');  



//     //Fusion_Dynamic_JS::deregister_script('jquery-easing');   Helps with image loading homepage
//     //Fusion_Dynamic_JS::deregister_script('modernizr'); Helps with image loading homepage
//     Fusion_Dynamic_JS::deregister_script('fusion-testimonials');
//     Fusion_Dynamic_JS::deregister_script('jquery-cycle'); // !    
// //     Fusion_Dynamic_JS::deregister_script('jquery-flexslider'); // !

// }


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
        'name'              => __( 'External Scholarships' ),
        'singular_name'     => __( 'External Scholarships' ),
        'add_new'           => __( 'Add New External Scholarships' ),
        'add_new_item'      => __( 'Add New External Scholarships' ),
        'edit_item'         => __( 'Edit External Scholarships' ),
        'new_item'          => __( 'Add New External Scholarships' ),
        'view_item'         => __( 'View External Scholarships' ),
        'search_items'      => __( 'Search External Scholarships' ),
        'not_found'         => __( 'No External Scholarships found' ),
        'not_found_in_trash' => __( 'No External Scholarships found in trash' ),

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
        'rewrite'               => array( 'slug' => 'external' ),
        'has_archive'           => false,
        'menu_position'         => 30,
        'show_ui '              => true,  
        'menu_icon'             => 'dashicons-admin-multisite',
       
    );
    register_post_type( 'ext-scholarships', $args );  

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
    'name'               => __( 'Landing Pages', 'my_theme' ),
    'singular_name'      => __( 'Landing Page', 'my_theme' ),
    'add_new'            => __( 'Add New Landing Page', 'my_theme' ),
    'add_new_item'       => __( 'Add New Landing Page', 'my_theme' ),
    'edit_item'          => __( 'Edit Landing Page', 'my_theme' ),
    'new_item'           => __( 'Add New Landing Page', 'my_theme' ),
    'view_item'          => __( 'View Landing Page', 'my_theme' ),
    'search_items'       => __( 'Search Landing Page', 'my_theme' ),
    'not_found'          => __( 'No Landing Pages found', 'my_theme' ),
    'not_found_in_trash' => __( 'No Landing Pages found in trash', 'my_theme' )
);

$supports = array(
    'title',
    'author',
    'thumbnail',
     'editor' // This enables the text editor
);

$args = array(
    'labels'             => $labels,
    'supports'           => $supports,
    'public'             => true,
    'capability_type'    => 'post',
    'rewrite'            => array( 'slug' => 'landing-page' ),
    'has_archive'        => false,
    'menu_position'      => 30,
    'menu_icon'          => 'dashicons-admin-multisite',
   
);

register_post_type( 'landing-page', $args );


   



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
        'comments'
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


function get_active_institutions_related_posts(){
    global $wpdb;
    
    $text = $wpdb->prepare("SELECT post_id FROM wp_postmeta WHERE meta_key = 'active_related' AND meta_value = 1;");
    
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


function exclude_institutions_related_courses($location){
   
    global $wpdb;
    
    $query = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'excludeCountries_related_posts' AND meta_value LIKE '%%" . $location . "%%'";
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




add_action('wp_ajax_load_courses', 'handle_ajax_load_courses');
add_action('wp_ajax_nopriv_load_courses', 'handle_ajax_load_courses');

function handle_ajax_load_courses() {
  

$country_value = isset($_POST['country']) ? strtolower($_POST['country']) : '';
$degree_value = isset($_POST['degree']) ? strtolower($_POST['degree']) : '';
$subject_value = isset($_POST['subject']) ? strtolower($_POST['subject']) : '';
   

  
    $subject_value = str_replace('-', ' ', $subject_value);
    $subject_value = ucwords($subject_value);

    

    $page = $_POST['page'] ?? 1;
    $order = $_POST['order'] ?? 'DESC';
    $adsPerPage = 30;
    $offset = ($page - 1) * $adsPerPage;

    $country_value = str_replace('-', ' ', $country_value);
    
  
   

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
    $institute_ids_country = get_institution_ids($country_value);

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




    // Construct the query arguments
    $ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 30,
        'offset' => $offset, 
        // 'meta_key' => 'tuition_USD',
        // 'orderby' => "meta_value_num",
        // 'order' => $order,
        'meta_key' => 'priority',
        'orderby' => "meta_value_num",
        'order' => "DESC",
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN')
        )
    );


    $all_ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 30,
        'offset' => $offset, 
        
        // 'meta_key' => 'tuition_USD',
        // 'orderby' => "meta_value_num",
        // 'order' => $order,

        'meta_key' => 'priority',
        'orderby' => "meta_value_num",
        'order' => "DESC",

        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN')
        )
    );



    if ($subject_value) {
        $ad_args['meta_query'][] = array('key' => 'ads_subject', 'value' => $subject_value, 'compare' => 'LIKE');
    }

    if ($degree_value) {
        $ad_args['meta_query'][] = array('key' => 'degrees', 'value' => $degree_value, 'compare' => 'LIKE');
    }

    if ($country_value) {
        $ad_args['meta_query'][] = array('key' => 'adsInstitution', 'value' => $institute_ids_country, 'compare' => "IN");
    }

 $text = " ";
 $loop = new WP_Query($ad_args);
 $total_count = $loop->found_posts;

 $first = "" . ucwords($degree_value) . " ". $subject_value . " Courses ";
 $second = "in " . ucwords($country_value) . " ";
 $third = "for Students " . $location_string;
 if(isset($country_value) && $country_value){
        $text = $first . $second . $third;
    } else {
        $text = $first . $third;
    }
   
     

   if ($loop->have_posts()) {
    echo "<h2 class='opencourse-ajax-title'>" . $text . " </h2>"; 
    echo "<p  class='opencourse-ajax-count'>" . $total_count . " </p>";
    while ($loop->have_posts()) {
        $loop->the_post();
        $ad_id = get_the_ID();
        show_ads_card_new($ad_id); // Adjust this to your function for displaying a card
    }
    } 
    else {
    echo "<p style='padding-bottom:20px;' class='white-background'><b>There were no courses matching your search of " . $text . ". Instead, we will show all the courses available for students " . $location_string . ". </b></p>";

    $new_loop = new WP_Query($all_ad_args);
    $total_count = $new_loop->found_posts;
    
    if ($new_loop->have_posts()) {
        echo "<h2 class='opencourse-ajax-title'>" . $text . " </h2>"; 
        echo "<p  class='opencourse-ajax-count'>" . $total_count . " </p>";
        while ($new_loop->have_posts()) {
            $new_loop->the_post();
            $ad_id = get_the_ID(); // Correct way to get the post ID
            show_ads_card_new($ad_id);
        }
    }
 }


    wp_die();

}

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
    $default_text = 'Default Text';
    $default_link = 'https://example.com';
    $default_id = 'default-id';

    $text = isset($atts['text']) ? $atts['text'] : $default_text;
    $link = isset($atts['link']) ? $atts['link'] : $default_link;
    $id = isset($atts['id']) ? $atts['id'] : $default_id;

    $html = '<aside class="course-aside">
        <a class="course-buttons-link" href="' . esc_url($link) . '" id="' . esc_attr($id) . '">
            <button class="course-buttons">' . esc_html($text) . '</button>
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

   if(isset($_POST['query'])) {
   $query = $_POST['query'];
  }

  
   //$offset = $offset - 1;
  
   $degrees = isset($_POST['degrees']) ? stripslashes($_POST['degrees']) : '';
   $degrees_array = explode(',', $degrees); 

   $subjects = $_POST['subjects'];
   $subject_array = explode(',', $subjects); 

   // $scholarship = $_POST['scholarship'];
   // $scholarship_array = explode(',', $scholarship);

   $locations = $_POST['locations'];
   $locations_array = explode(',', $locations); 


   $nationality = $_POST['nationality'];
   $nationality_array = explode(',', $nationality); 

   $scholarship_type = $_POST['scholarship_type'];
   $type_array = explode(',', $scholarship_type); 

   $applications = $_POST['applications'];
   $application_array = explode(',', $applications);

   // $institution_array = $_POST['institutions'];
   // $institution_array = explode(',', $institution_array); 

   
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
  

  
    // if(isset($institution_array[0]) && $institution_array[0]){
    //    $institution_query  = array('key' => 'scholarship_institution', 'value' => $institution_array, 'compare' => "IN");
    //  } else {
       
    //  } 

      if(isset($locations_array[0]) && $locations_array[0]){
        $location_query  = array('key' => 'scholarship_institution', 'value' => $institute_ids, 'compare' => "IN");
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

    // if ($institution_query) { 
    // $meta_query[] = $institution_query; 
    // }

     if ($application_query) { 
    $meta_query[] = $application_query; 
    }
    
   
//  if($scholarship_array[0]){
//  $ad_args = array(
//     'post_type' => 'scholarships',
//     'post_status' => 'publish',
//     'posts_per_page' => $ppp,
//     'offset' => $offset,
//     'fields' => 'ids', // Only return post IDs
//     'meta_key' => 'scholarship_weights',  // name of custom field
//     'orderby' => 'meta_value_num',  // we want to order by numeric value
//     'order' => 'DESC',  // highest to lowest
//     'title' => $scholarship_array[0]
// );
//    }
//    else {

  
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
   // }

    if (!empty($query)) {
    $ad_args['s'] = $query;
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
                       
                        //$scholarship_id = $post->ID;
                        $scholarship_id = get_the_ID();

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


add_action( 'init', function() {

add_rewrite_rule(
        '^opencourses/.*?$',
        'index.php?pagename=opencourses',
        'top'
    );
});

// // Add Rewrite Rule for Best Universities Template.
// add_action( 'init',  function() {
//     add_rewrite_rule(
//         '^deadlines-by-country-([^/]*)?',
//         'index.php?pagename=deadlines-by-country&country=$matches[1]',
//         'top'
//     );
// } );
    

// add_action('init', function () {
//     add_rewrite_rule(
//         '^scholarship-search(?:/([^/]+))?(?:/page/(\d+))?/?$',
//         'index.php?pagename=scholarship-search&page=$matches[1]&page_number=$matches[2]',
//         'top'
//     );
// });

add_action('init', function () {
    add_rewrite_rule(
        '^scholarship-search(?:/page/(\d+))?/?$',
        'index.php?pagename=scholarship-search&page_number=$matches[1]',
        'top'
    );
});


add_action('init', function () {
    add_rewrite_rule(
        '^opencourses(?:/page/(\d+))?/?$',
        'index.php?pagename=opencourses&page_number=$matches[1]',
        'top'
    );
});


// Add a filter to modify the main query
add_filter('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // Check if we're on the scholarship-search page and have the custom_page parameter
    if (is_page('scholarship-search') && ($custom_page = get_query_var('custom_page'))) {
        $query->set('paged', max(1, $custom_page)); // Use custom_page as the page number
    }
});

// Add the custom parameter to the list of query variables
add_filter('query_vars', function ($vars) {
    $vars[] = 'custom_page';
    return $vars;
});




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


function providers(){}





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
$scholarship_author = get_role( 'scholarship_author' );
    


    $scholarship_editor->remove_cap('edit_ads');
    $scholarship_editor->remove_cap('publish_ads');
    $scholarship_editor->remove_cap('read_ads');
    $scholarship_editor->remove_cap('read_private_ads');
    $scholarship_editor->remove_cap('delete_ads');
   
    $scholarship_editor->remove_cap('delete_private_ads');
    $scholarship_editor->remove_cap('delete_published_ads');

    if ( $scholarship_editor || $scholarship_author ) {

        // Scholarship Editor
        $scholarship_editor->remove_cap('edit_posts');
        $scholarship_editor->remove_cap('publish_posts');
        $scholarship_editor->remove_cap('edit_published_posts');
        $scholarship_editor->remove_cap('edit_others_posts');
        $scholarship_editor->remove_cap('delete_posts');
        $scholarship_editor->remove_cap('delete_others_posts');

        // Scholarship Author
        $scholarship_author->remove_cap('edit_posts');
        $scholarship_author->remove_cap('publish_posts');
        $scholarship_author->remove_cap('edit_published_posts');
        $scholarship_author->remove_cap('edit_others_posts');
        $scholarship_author->remove_cap('delete_posts');
        $scholarship_author->remove_cap('delete_others_posts');
    }

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
            echo '<div class="col-md-4" style="padding-left:2% !important;padding-right:4% !important;">';
            echo '<div class="scholarship-item">';
            echo '<div class="featured-image">' . get_the_post_thumbnail() . '</div>';
            echo '<h2 style="font-family:Roboto, Arial, Helvetica, sans-serif;padding-left:0px;padding-top:10px;padding-bottom:5px;font-size:26px !important;" class="scholarship-title">' . get_the_title() . '</h2>';
            
            $brief_intro = get_field('brief_intro');
            $excerpt = substr($brief_intro, 0, 130);

            // echo '<div class="scholarship-excerpt">' . $excerpt .  '....</div>';

            echo "<div class='meta-scholarship-blog' style='margin-top:5px;margin-bottom:40px !important'>   <span style='float:left;'>"  . get_the_date() . "</span>  
            <a href='" . esc_url(get_permalink()) . "' style='color:#77a6cp !important;float:right;padding-right:0px;margin-right:15px;
            border-bottom:1px solid #008fc5 ;font-size:17px !important;padding-bottom:5px;'>  Read more >    </a>   </div>";
            
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
        'post_type' => ['scholarships', 'institution', 'scholarship_post'], // Added custom post types
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

// Enable comments for all existing "scholarship_post" posts
function enable_comments_for_existing_posts() {
    $args = array(
        'post_type'      => 'scholarship_post',
        'posts_per_page' => -1,
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            // Enable comments for each post
            $post_id = get_the_ID();
            $post_data = array(
                'ID'             => $post_id,
                'comment_status' => 'open',
            );
            wp_update_post( $post_data );
        }

        wp_reset_postdata();
    }
}

// Run the function once
// enable_comments_for_existing_posts();

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
        // 'scholarship_access',                   // capability (allow scholaship-edior role)
        'edit_posts',                   // capability (DO NOT allow scholaship-edior role)
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

// Adding Admin Page for Feedback Form Data Tables

function add_institutions_deadlines_updated_page()
{
    add_submenu_page(
        'edit.php?post_type=institution', // parent slug
        'Updated Institutions List',             // page title
        'Updated Institutions List',             // menu title
        'edit_posts',                   // capability
        'institutions-deadlines-updated',             // menu slug
        'render_institutions_deadlines_updated_page'  // callback function
    );
}
add_action('admin_menu', 'add_institutions_deadlines_updated_page');


function render_institutions_deadlines_updated_page()
{
    $current_user = wp_get_current_user();
    if (in_array('scholarship_editor', $current_user->roles) || in_array("scholarship_author", $current_user->roles)) {
        return;
    }
    // Add your custom admin page HTML here
    include('institutions-deadlines-updated.php');
}

function render_institutions_update_deadlines_meta_page()
{
    // Add your custom admin page HTML here
    include('institutions-update-deadlines-meta.php');
}


function enqueue_scholarship_admin_scripts($hook_suffix)
{
    $screen = get_current_screen(); // Get the current screen object

    

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


    if ($hook_suffix == 'institution_page_institutions-deadlines-updated') {
        

        wp_enqueue_script('deadlines_bootstrap_javascript', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.js', array(), '5.3.0', true);

        wp_enqueue_style('deadlines_bootstrap_css', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap.min.css');
        wp_enqueue_style( 'deadlines_datatables-css', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.css');
        wp_enqueue_script( 'deadlines_datatables-js', get_stylesheet_directory_uri(). '/assets/datatables/dataTables.min.js', array('jquery'), '1.10.25', true );


        wp_enqueue_script('gs_deadlines_updated_script',  get_stylesheet_directory_uri() . '/assets/institutions-updated-deadlines.js', array('jquery', 'deadlines_datatables-js'),
        '1.0.45',
        false );
        
        wp_localize_script( 'gs_deadlines_updated_script', 'my_ajax_object',
          array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
          )
        );
    }


    if ($hook_suffix == 'edit-comments.php') {
        

        wp_enqueue_style('gs_comments',  get_stylesheet_directory_uri() . '/assets/gs-comments.css' );

    }

    if ($hook_suffix == 'edit-comments.php') {
        

        wp_enqueue_style('gs_comments',  get_stylesheet_directory_uri() . '/assets/gs-comments.css' );

    }

    if ( is_object($screen) && $screen->id === 'ext-scholarships' ) { // Replace 'your_custom_post_type' with your specific custom post type
        // This is the edit screen of your custom post type
        // Run your code here

        wp_enqueue_script('gs_ext_scholarship_acf',  get_stylesheet_directory_uri() . '/assets/ext-scholarship-update-include-exclude.js', array('jquery'),
        '1.0.0',
        false );
        
        wp_localize_script( 'gs_ext_scholarship_acf', 'my_ajax_object',
          array( 
            'countries_list' =>  get_stylesheet_directory_uri() .'/all_regions.json',
          )
        );
    }


}
add_action('admin_enqueue_scripts', 'enqueue_scholarship_admin_scripts');

function convert_countries_list_json() {
    include dirname(__FILE__)  . "/functions/countries_list.php"; 


    // Combine all arrays into one associative array
    $all_regions = array(
        'Africa' => $africa,
        'LatinAmerica' => $latinAmerica,
        'Caribbean' => $caribbean,
        'SouthEastAsia' => $southeastAsia,
        'Pacific' => $pacific,
        'WesternHemisphere' => $westernHemisphere,
        'Asia' => $asia,
        'EuropeanUnion' => $EuropeanUnion,
        'EuropeanEconomicArea' => $EuropeanEconomicArea,
        'Europe' => $Europe,
        'NorthAmerica' => $northAmerica_list,
        'Oceania' => $oceania_list,
        'MiddleEast' => $middleEast_list,
        'Commonwealth' => $commonwealth_list,
        'SouthAsia' => $southAsia_list,
        'EastAsia' => $eastAsia_list,
    );

    // Convert the associative array into JSON
    $all_regions_json = json_encode($all_regions, JSON_UNESCAPED_UNICODE);

    // Specify the path to the new JSON file
    $file_path = dirname(__FILE__) . '/all_regions.json';

    // Write the JSON data to the file, creating it if it doesn't exist, or overwriting it if it does
    file_put_contents($file_path, $all_regions_json);
}
add_action('convert_countries_list_json', 'convert_countries_list_json');



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
        jQuery(this).fadeOut('500', function() {
            secondDiv.fadeIn('500');
        });
    });

    jQuery(".second-div").mouseleave(function() {
        var firstDiv = jQuery(this).prev('.first-div');
        jQuery(this).fadeOut('500', function() {
            firstDiv.fadeIn('500');
        });
    });
});



jQuery(document).ready(function() {
    jQuery(".read-more").click(function(event) {
        event.preventDefault();
        
        // Hide the "short" paragraph containing the clicked "read-more" span
        jQuery(this).parent('#short').hide().siblings('#full').show();
       
        // Show the "full"
       // jQuery('#full').show();
    });
});


jQuery(document).ready(function() {
    jQuery(".read-less").click(function(event) {
        event.preventDefault();
        
        // Hide the "short" paragraph containing the clicked "read-more" span
        jQuery(this).parent('#full').hide().siblings('#short').show();
       
        // Show the "full"
       // jQuery('#full').show();
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
            'xmlns'             => true,
            'width'         => true,
            'height'        => true,
            'preserveAspectRatio'   => true,
            'fill'              => true,
            'viewbox'               => true,
            'role'              => true,
            'aria-hidden'           => true,
            'focusable'             => true,
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


// function cta_shortcode($atts) {
    
//     // Get the ACF fields
//     $cta_details  = acf_get_fields('group_64ecee859ce7e');
//     $title_array = array_column($cta_details, null, 'name')['title'];
//     $default_title = $title_array["default_value"];

//     $description_array = array_column($cta_details, null, 'name')['description'];
//     $default_description = $description_array["default_value"];

//     $image_array = array_column($cta_details, null, 'name')['image_link'];
//     $default_image = $image_array["default_value"];

//     $link_array = array_column($cta_details, null, 'name')['link_url'];
//     $default_link = $link_array["default_value"];
//     $args = shortcode_atts(array(
//         'title' => $default_title,  // Use the ACF default title
//         'desc' => $default_description, // Provide a default description
//         'img_url' => $default_image, // Provide a default image URL
//         'link_url' =>  $default_link, // Provide a default link URL for Apply now
//     ), $atts);

//     // Construct the output
//     $output = '<div class="container mt-5 cta-container">
//     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
//         <div class="row">
          
//             <div class="col-md-4 col-sm-12 text-center ">
//                 <img src="' . esc_url($args['img_url']) . '" alt="Description" class="img-fluid cta-image">
                
//             </div>
            
          
//             <div class="col-md-8 col-sm-12">
//                 <h2 style="font-size:30px;">' . esc_html($args['title']) . '</h2>
//                 <p>' . esc_html($args['desc']) . '</p>
//                 <a class="apply-now" href="' . esc_url($args['link_url']) . '" style="width:200px;color:#0055F9 !important;">   Apply now   <i style="margin-top:3px;width:20px;margin-left:5px;color:#0055F9 !important;" class="fa fa-long-arrow-right"> </i> </a>
//             </div>
//         </div>
//     </div>';

//     return $output;
// }

// // Register the shortcode
// add_shortcode('cta_shortcode', 'cta_shortcode');



function cta_post_shortcode($atts) {
    
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

    $args = shortcode_atts(array(
        'title' => $default_title,  // Use the ACF default title
        'desc' => $default_description, // Provide a default description
        'img_url' => $default_image, // Provide a default image URL
        'link_url' =>  $default_link,
        'id' => 'cta-apply-now', // Provide a default link URL for Apply now
    ), $atts);

    // Construct the output
    $output = '<div class="post-cta-section">
               <div class="container mt-5 cta-container">
               <div class="row">

               <div class="col-md-9 col-sm-12">
                <p class="cta_description">' . esc_html($args['title']) . '</p>
                <p id="cta-text">' . esc_html($args['desc']) . '</p>
               </div>

            <div class="col-md-3 col-sm-12 text-center ">
            <a class="apply-now" id="'. esc_attr($args['id']) . '" href="' . esc_url($args['link_url']) . '">Apply now</a>

           </div>


        </div>
       </div> 
        </div>';
      
    return $output;
}

// Register the shortcode
add_shortcode('cta_post_shortcode', 'cta_post_shortcode');

define('COUNTRY_CODES', serialize(array(
    "Afghanistan" => "af",
    "Albania" => "al",
    "Algeria" => "dz",
    "Andorra" => "ad",
    "Angola" => "ao",
    "Antigua and Barbuda" => "ag",
    "Argentina" => "ar",
    "Armenia" => "am",
    "Australia" => "au",
    "Austria" => "at",
    "Azerbaijan" =>   "az",
    "Bahamas" => "bs",
    "Bahrain" => "bh",
    "Bangladesh" => "bd",
    "Barbados" => "bb",
    "Belarus" => "by",
    "Belgium" => "be",
    "Belize" => "bz",
    "Benin" => "bj",
    "Bhutan" => "bt",
    "Bolivia" => "bo",
    "Bosnia and Herzegovina" => "ba",
    "Botswana" => "bw",
    "Brazil" => "br",
    "Brunei" => "bn",
    "Bulgaria" => "bg",
    "Burkina Faso" => "bf",
    "Burundi" => "bi",
    "Cambodia" => "kh",
    "Cameroon" => "cm",
    "Canada" => "ca",
    "Cape Verde" => "cv",
    "Central African Republic" => "cf",
    "Chad" => "td",
    "Chile" => "cl",
    "China" => "cn",
    "Colombia" => "co",
    "Comoros" => "km",
    "Congo (Brazzaville)" => "cg",
    "Congo (Kinshasa)" => "cd",
    "Costa Rica" => "cr",
    "Croatia" => "hr",
    "Cuba" => "cu",
    "Cyprus" => "cy",
    "Czech Republic" => "cz",
    "Denmark" => "dk",
    "Djibouti" => "dj",
    "Dominica" => "dm",
    "Dominican Republic" => "do",
    "East Timor" => "tl",
    "Ecuador" => "ec",
    "Egypt" => "eg",
    "El Salvador" => "sv",
    "Equatorial Guinea" => "gq",
    "Eritrea" => "er",
    "Estonia" => "ee",
    "Ethiopia" => "et",
    "Fiji" => "fj",
    "Finland" => "fi",
    "France" => "fr",
    "Gabon" => "ga",
    "Gambia" => "gm",
    "Georgia" => "ge",
    "Germany" => "de",
    "Ghana" => "gh",
    "Greece" => "gr",
    "Grenada" => "gd",
    "Guatemala" => "gt",
    "Guinea" => "gn",
    "Guinea-Bissau" => "gw",
    "Guyana" => "gy",
    "Haiti" => "ht",
    "Honduras" => "hn",
    "Hungary" => "hu",
    "Iceland" => "is",
    "India" => "in",
    "Indonesia" => "id",
    "Iran" => "ir",
    "Iraq" => "iq",
    "Ireland" => "ie",
    "Israel" => "il",
    "Italy" => "it",
    "Ivory Coast" => "ci",
    "Jamaica" => "jm",
    "Japan" => "jp",
    "Jordan" => "jo",
    "Kazakhstan" => "kz",
    "Kenya" => "ke",
    "Kiribati" => "ki",
    "Kuwait" => "kw",
    "Kyrgyzstan" => "kg",
    "Laos" => "la",
    "Latvia" => "lv",
    "Lebanon" => "lb",
    "Lesotho" => "ls",
    "Liberia" => "lr",
    "Libya" => "ly",
    "Liechtenstein" => "li",
    "Lithuania" => "lt",
    "Luxembourg" => "lu",
    "Macedonia" => "mk",
    "Madagascar" => "mg",
    "Malawi" => "mw",
    "Malaysia" => "my",
    "Maldives" => "mv",
    "Mali" => "ml",
    "Malta" => "mt",
    "Marshall Islands" => "mh",
    "Mauritania" => "mr",
    "Mauritius" => "mu",
    "Mexico" => "mx",
    "Micronesia" => "fm",
    "Moldova" => "md",
    "Monaco" => "mc",
    "Mongolia" => "mn",
    "Montenegro" => "me",
    "Morocco" => "ma",
    "Mozambique" => "mz",
    "Myanmar" => "mm",
    "Namibia" => "na",
    "Nauru" => "nr",
    "Nepal" => "np",
    "Netherlands" => "nl",
    "New Zealand" => "nz",
    "Nicaragua" => "ni",
    "Niger" => "ne",
    "Nigeria" => "ng",
    "North Korea" => "kp",
    "Norway" => "no",
    "Oman" => "om",
    "Pakistan" => "pk",
    "Palau" => "pw",
    "Panama" => "pa",
    "Papua New Guinea" => "pg",
    "Paraguay" => "py",
    "Peru" => "pe",
    "Philippines" => "ph",
    "Poland" => "pl",
    "Portugal" => "pt",
    "Qatar" => "qa",
    "Romania" => "ro",
    "Russia" => "ru",
    "Rwanda" => "rw",
    "United States" => "us",
    "United Kingdom" => "gb",
    "Saint Kitts and Nevis" => "kn",
    "Spain" => "es",
)));


// Function to get the country code from a country name
function getCountryCode($countryName, $countryCodes) {
    // Use array_key_exists to check if the country name exists in the array
    if (array_key_exists($countryName, $countryCodes)) {
        return $countryCodes[$countryName];
    } else {
        // Return an appropriate value if the country name is not found
        return "Unknown";
    }
}


function get_location_from_api(){
    
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
       $country_code = $_SERVER['GEOIP_COUNTRY_CODE'];
    }
    $location = $country_code;
    return $location;
}



function get_country_from_api(){
    
    $pro_ip_api_key = '2fNMZlFIbNC1Ii8';
    // Get Current Device Data
    $ip_api = file_get_contents('https://pro.ip-api.com/json/'.$_SERVER['REMOTE_ADDR'] . '?key='.$pro_ip_api_key);

    // Data Decoded
    $data = json_decode($ip_api);
     
    // Turn Object into Associative Array
    $data_array = get_object_vars($data);

    // Get Country Code to use to get other related content (Courses)
    if($data_array) {
        $country = $data_array['country'];
    } else {
       $country = $_SERVER['GEOIP_COUNTRY_CODE'];
    }

    return $country;
}

add_shortcode('courses_grid_shortcode_new', 'courses_grid_shortcode_new');

function courses_grid_shortcode_new($atts) {
    ob_start();
 
     $atts = shortcode_atts(array(
         'title' => 'Feature Courses',
     ), $atts);
 
     $title = $atts['title'];
 
     if (empty($title)) {
         $title = 'Feature Courses';
     }
 
     $location =  get_location_from_api();
     $location = code_to_country($location);
 
     $active_institutions = get_active_institutions_related_posts();
     $excluded = exclude_institutions_related_courses($location);
 
     $args = array(
         'post_type' => 'ads',
         'post_status' => 'publish',
         'posts_per_page' => 3,
         'meta_key' => 'priority',
         'orderby' => "meta_value_num",
         'order' => "DESC",
         'meta_query' => array(
             'relation' => 'AND',
             array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
             array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
         ),
     );
 
 
     $new_loop = new WP_Query($args); ?>
 
         <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div class="clearfix"> </div>
        <div id="courses-flipcard" >
        
        <div class="row title-div mobile-row">
         <div class="col-md-12 feature-title">
             <h2>  <?php echo $title; ?> </h2> 
         </div>
        </div>
 
       <div class="row title-div desktop-row">
         
         <div class="col-md-6 feature-title">
             <h2>  <?php echo $title; ?> </h2> 
         </div>
 
         <div class="col-md-6 browse-courses-btn">
           <a id="browse-courses-link" href="<?php  echo site_url() . "/opencourses"; ?>"> <button class="fusion-button fusion-button-default fusion-button-default-size"> Browse All Courses </button> </a> 
         </div>
 
       </div>
 
         <?php 
         if ($new_loop->have_posts()) : 
             while ($new_loop->have_posts()) : $new_loop->the_post();
 
                 $ad_id = get_the_ID();
                 $image_url = get_the_post_thumbnail_url($ad_id);
                 $course_title = get_the_title();
                 $institute = get_post(get_post_meta(get_the_ID(), 'adsInstitution', true));
                 $domestic_tuition_fees_INT = get_post_meta($institute->ID, 'domestic_tuition_fees' , true);
                 $international_tuition_fees_INT = get_post_meta($institute->ID, 'international_tuition_fees' , true);
                 $domestic_tuition_fees = get_post_meta($ad_id, 'domestic_tuition_fees' , true);
                 $international_tuition_fees = get_post_meta($ad_id, 'international_tuition_fees' , true);
                 
                 $country = get_post_meta($institute->ID, 'adsIntCountry', true);
                 $countryCodes = unserialize(COUNTRY_CODES);
                 $countryCode = getCountryCode($country, $countryCodes);
                  
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
 
                if ($language_of_instructions_ads) {
                $language_of_instruction = $language_of_instructions_ads;
                } elseif ($language_of_instructions_AdsInt) {
                $language_of_instruction = $language_of_instructions_AdsInt;
                } else {
                $language_of_instruction = "English";
                }
 
                $log_url = get_the_post_thumbnail_url($institute->ID);
 
                 if (!$image_url) {
                 $image_url = site_url() . '/wp-content/uploads/2023/10/berlin_germany.width-550.format-webp-11-1.png';
                 }
              
              $logo_url = get_the_post_thumbnail_url($institute->ID);
              $flag_url = get_post_meta(get_the_ID(), 'flag_key', true); ?>
     
 
 
     <a id="related-courses-link" href="<?php echo $link; ?>">
     <div class='col-md-4 card-container related-courses-desktop'>
         <div class='front'>
             <div class="course-image">
                 <img src="<?php echo esc_url($image_url); ?>" alt="Course Image">
             </div>
             <div class="course-text heading-section" >
                 <div class="col-md-3 course-logo">
                     <img src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                 </div>
                 <div class="col-md-7 course-title" >
                     <?php echo esc_html($course_title); ?>
                 </div>
                 <div class="col-md-2 country-flag">
                     <img src="<?php echo site_url(); ?>/wp-content/themes/Avada-Child-Theme/assets/flags/<?php echo $countryCode; ?>.svg">
                 </div>
             </div>
             <div class="clearfix"> </div>
             <div class="course-text heading-section">
                 <p class="institute-title">
                     <?php echo $institute->post_title; ?>
                 </p>
             </div>
             <div>
                 <p id="annaual-text">Annual Tuition Fee</p>
             </div>
             <div class="course-text annual-section">
                 <div class="tuition-fee-div">
                     <p class="tuition-fee-text">
                         <span>Domestic</span><br>
                         <?php
                         if ($domestic_tuition_fees) {
                             echo number_format($domestic_tuition_fees) . " " . $currency;
                         } elseif ($domestic_tuition_fees_INT) {
                             echo number_format($domestic_tuition_fees_INT) . " " . $currency;
                         } else {
                             echo "N/A";
                         }
                         ?>
                     </p>
                 </div>
                 <div class="tuition-fee-div-second">
                      <p class="tuition-fee-text">
                         <span>International</span><br>
                         <?php
                         if ($international_tuition_fees) {
                             echo number_format($international_tuition_fees) . " " . $currency;
                         } elseif ($international_tuition_fees_INT) {
                             echo number_format($international_tuition_fees_INT) . " " . $currency;
                         } else {
                             echo "N/A";
                         }
                         ?>
                     </p>
                 </div>
             </div>
             <div class="course-text language-section" >
                 <p>
                     <span class="language-icon">
                         <img src="<?php echo site_url(); ?>/wp-content/uploads/2023/07/language.png">
                     </span>
                     <span class="language-text"><?php echo $language_of_instruction; ?></span>
                 </p>
             </div>
         </div>
         <div class='back'>
             <div class="course-image">
                 <img src="<?php echo esc_url($image_url); ?>" alt="Course Image">
             </div>
             <div class="course-text heading-section" >
                 <div class="col-md-3 course-logo">
                     <img  src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                 </div>
                 <div class="col-md-9 course-title">
                     <?php echo esc_html($course_title); ?>
                 </div>
             </div>
             <div class="course-text heading-section">
                 <p class="institute-title">
                     <?php echo $institute->post_title; ?>
                 </p>
             </div>
             <div class="course-text">
                 <p id="short">
                     <?php
                     if (strlen($des) > 110) {
                         $des = substr($des, 0, 100);
                         $des .= '...  ';
                     }
                     echo $des;
                     ?>
                 </p>
             </div>
             <div class="course-text disclaimer-div">
                 <p class="disclaimer-text">
                     <?php
                     if ($disclaimer === "1") {
                         echo "<strong class='disclaimer-strong'>*{$institute->post_title} does not offer fully-funded scholarships.</strong>";
                     }
                     ?>
                 </p>
             </div>
             <div class="course-text learn-more-div">
                 <p>
                     <a  href="<?php echo $link; ?>">
                         Learn more 
                         <i   
                         class="fa fa-arrow-right">  </i></a>
                 </p>
             </div>
            </div>
           </div> 
       
         <div class='col-md-4 card-container related-courses-mobile'>
         <div class='front'>
             <div class="course-image">
                 <img src="<?php echo esc_url($image_url); ?>" alt="Course Image">
             </div>
             <div class="course-text heading-section" >
                 <div class="col-md-3 course-logo">
                     <img src="<?php echo esc_url($logo_url); ?>" alt="Course Logo">
                 </div>
                 <div class="col-md-7 course-title" >
                     <?php echo esc_html($course_title); ?>
                 </div>
                 <div class="col-md-2 country-flag">
                     <img src="<?php echo site_url(); ?>/wp-content/themes/Avada-Child-Theme/assets/flags/<?php echo $countryCode; ?>.svg">
                 </div>
             </div>
             <div class="clearfix"> </div>
             <div class="course-text heading-section">
                 <p class="institute-title">
                     <?php echo $institute->post_title; ?>
                 </p>
             </div>
             <div>
                 <p id="annaual-text">Annual Tuition Fee</p>
             </div>
             <div class="course-text annual-section">
                 <div class="tuition-fee-div">
                     <p class="tuition-fee-text">
                         <span>Domestic</span><br>
                         <?php
                         if ($domestic_tuition_fees) {
                             echo number_format($domestic_tuition_fees) . " " . $currency;
                         } elseif ($domestic_tuition_fees_INT) {
                             echo number_format($domestic_tuition_fees_INT) . " " . $currency;
                         } else {
                             echo "N/A";
                         }
                         ?>
                     </p>
                 </div>
                 <div class="tuition-fee-div-second">
                      <p class="tuition-fee-text">
                         <span>International</span><br>
                         <?php
                         if ($international_tuition_fees) {
                             echo number_format($international_tuition_fees) . " " . $currency;
                         } elseif ($international_tuition_fees_INT) {
                             echo number_format($international_tuition_fees_INT) . " " . $currency;
                         } else {
                             echo "N/A";
                         }
                         ?>
                     </p>
                 </div>
             </div>
             <div class="course-text language-section" >
                 
                  <p class="learn-more-mobile-para">
                     <a  href="<?php echo $link; ?>">
                         Learn more 
                         <i   
                         class="fa fa-arrow-right">  </i></a>
                 </p>

                 <p class="language-section-div">
                     <span class="language-icon">
                         <img src="<?php echo site_url(); ?>/wp-content/uploads/2023/07/language.png">
                     </span>
                     <span class="language-text"><?php echo $language_of_instruction; ?></span>
                 </p>

                

             </div>

             


         </div>
         
           </div> 

          </a>
          <?php 
         endwhile;
         endif;
         ?>
        
         <div class="row mobile-row">
          <div class="col-md-12 browse-courses-btn">
            <center><a id="browse-courses-link" href="<?php  echo site_url() . "/opencourses"; ?>"> <button class="fusion-button fusion-button-default fusion-button-default-size"> Browse All Courses </button> </a> </center>
         </div>
        </div>
        
         </div>
         <?php
     wp_reset_query();
     return ob_get_clean(); // Return buffered output
 }



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

  /**
 * Update Institutions Post Meta for Country and Continent using ACF cities and CPT city
 * 
 */
function new_update_meta_location() {
    // Get the current offset
    $offset = 0;
    $batchSize = 20;
    $postType = 'institution';

    $institution_posts_count = wp_count_posts($postType);
    $institution_posts_count_published = $institution_posts_count->publish;


        $the_args = array(
        'post_type' => 'institution',
        'posts_per_page' => -1,
        // 'offset' => $offset,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'cache_results' => false,
        'fields' => 'ids',
        );

        $the_query = new WP_Query($the_args);
        $thePosts = $the_query->get_posts();

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


    
}
add_action('new_update_meta_location', 'new_update_meta_location');

// Get Page ID by Page Slug (used in set_tags_to_articles_by_topic_posts)
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
} 

// Get Articles By Topic and Set posts tags based on those set Article Topics
function set_tags_to_articles_by_topic_posts() {
    global $wpdb;
    
    $tables_titles = array();

    $tables_urls = array();
    
    $articles_by_topic_page_id = get_id_by_slug('articles-by-topic');

    $ArticleTopics = get_field('article_topics', $articles_by_topic_page_id);

    $articlesByTopic = array();
    
    foreach($ArticleTopics as $ArticleTopic) {

        foreach($ArticleTopic as $ArticleTopicItem) {
            $articlesByTopic[$ArticleTopicItem['topic_title']] = $ArticleTopicItem['topic_urls'];
            
            array_push($tables_titles, $ArticleTopicItem['topic_title']);
            array_push($tables_urls, $ArticleTopicItem['topic_urls']);
        }
    }
    foreach ($articlesByTopic as $articleTopicTitle => $articleByTopicURL) {
        // Extract category slug from URL (if present)
        $url_path_parts = explode('/', $articleByTopicURL);

        $category_slug = '';
        if (count($url_path_parts) >= 2 && $url_path_parts[0] == 'category') {
            $category_slug = $url_path_parts[1];
            
            if(!empty($category_slug)) {
                $category_slugs[] = $category_slug;
            }
            $category_slugs = array_unique (array_merge ($category_slugs));
        }


        // Select ID, post_title, date from WordPress database wpdb
        $query = "SELECT ID, post_title, post_date, post_name FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND (";
        if ($category_slug) {
            $query .= "ID IN (SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND term_id IN (SELECT term_id FROM $wpdb->terms WHERE slug = '$category_slug'))) OR ";
        }
        $query .= "post_name LIKE '%" . $articleByTopicURL . "%') ORDER BY post_date DESC";
    
        $myposts = $wpdb->get_results($query);
        $thePosts[$articleTopicTitle] = $myposts;
    }

    if (!empty($thePosts)) {
        foreach ($thePosts as $postCollectionTitle => $postIdCollection) {

            foreach($postIdCollection as $post) {
                 // Check if the post already has tags
                 $post_tags = wp_get_post_tags($post->ID);
                 if (empty($post_tags)) {
                     wp_set_post_tags($post->ID, array($postCollectionTitle), false);
                 }
            }
        }
    }
}

add_action('set_tags_to_articles_by_topic_posts', 'set_tags_to_articles_by_topic_posts');

// Creating a shortcode to render HTML content
function gs_courses_boxs() {
    ob_start(); // Start output buffering
    ?>
    <div class="gs-courses-boxes-container">
        <?php 
        
        $homepage_subjects = ['marketing', 'data science', 'design', 'business', 'computer science'];

        foreach ($homepage_subjects as $subject) {
            $subject_url = str_replace(' ', '-', $subject); // Replace spaces with dashes for the URL
            
            $ad_args = array(
                'post_type'      => 'ads',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'     => 'ads_subject',
                        'value'   => $subject,
                        'compare' => 'LIKE' // Using 'LIKE' for partial matching
                    )
                )
            );

            $posts_subject = get_posts($ad_args);
            $count = count($posts_subject);

            // Render HTML for each subject
            echo '<a href="/opencourses/?subject=' . $subject_url . '" target="_blank" class="gs-course-box-item">';
            echo '<div class="gs-course-image">';
            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/' . $subject_url . '.png" alt="" srcset="">';
            echo '</div>';
            echo '<div class="gs-course-text-container">';
            echo '<div class="gs-course-title">';
            echo '<h2>' . ucfirst($subject) . '</h2>'; // Capitalize the subject name
            echo '</div>';
            echo '<div class="gs-course-info">';
            echo '<p>' . $count . ' Courses</p>'; // Display the count
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }

        ?>
    </div>
    
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('gs-courses', 'gs_courses_boxs'); // Registering the shortcode

// Memberpress Extend Nav items
function mepr_add_some_tabs($user) {
    ?>
        <span class="mepr-nav-item gs-suggested-scholarships <?php MeprAccountHelper::active_nav('suggested-scholarships'); ?>">
            <a href="/account/?action=suggested-scholarships">Suggested Scholarships</a>
        </span>
        <span class="mepr-nav-item gs-monthly-scholarships <?php MeprAccountHelper::active_nav('monthly-scholarships'); ?>">
            <a href="/account/?action=monthly-scholarships">Monthly Scholarships</a>
        </span>
    <?php
}
add_action('mepr_account_nav', 'mepr_add_some_tabs');

function mepr_add_tabs_content($action) {
    //Listens for the "test" action on the account page, before rendering the contact form shortcode.
    if($action == 'suggested-scholarships') {
        include 'gs-memberpress-templates/suggested-scholarships.php';
    }
    if($action == 'monthly-scholarships') {
        include 'gs-memberpress-templates/monthly-scholarships.php';
    }
}
add_action('mepr_account_nav_content', 'mepr_add_tabs_content');



function init_curl_session($url) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);
    return $curl;
}

function get_currency_conversion($fromCurrency, $toCurrency, $amount) {
    $apiUrl = "https://api.fxratesapi.com/convert?from=$fromCurrency&to=$toCurrency&amount=$amount&api_key=fxr_live_c26ae8c14971ba9e361e44017e494e33635f";
    $curl = init_curl_session($apiUrl);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        return 0;
    } else {
        $response_data = json_decode($response, true);
        return $response_data['result'] ?? 0;
    }
}

function convert_ads_currency_to_usd() {
    $args = ['post_type' => 'ads', 'posts_per_page' => -1]; // Adjust query as needed
    $ads = new WP_Query($args);

    while ($ads->have_posts()) {
        $ads->the_post();
        $ad_id = get_the_ID();

        $institute_id = get_post_meta($ad_id, 'adsInstitution', true);
        
        $country = get_post_meta($institute_id, 'adsIntCountry', true);
        $currency = get_currency($country);
        
        if($currency == "Euros") {
            $currency = "EUR";
        }
        
        if($currency== "Yen") {
             $currency = "JPY";
        }
       
        
        $international_tuition_fees_INT = get_post_meta($institute_id, 'international_tuition_fees' , true);
        $international_tuition_fees = get_field('international_tuition_fees');

        // Initialize converted_amount to 0
        $converted_amount = 0;

        // Check if international tuition fees are set and not empty
        if (!empty($international_tuition_fees)) {
            $converted_amount = get_currency_conversion($currency, 'USD', $international_tuition_fees);
        } else {
            if($international_tuition_fees_INT) {
                 $converted_amount = get_currency_conversion($currency, 'USD', $international_tuition_fees_INT);
            }
        }

        // Update post meta with either the converted amount or 0
        $rounded_amount = round($converted_amount);
        update_post_meta($ad_id, 'tuition_USD', $rounded_amount);
    }
}

//convert_ads_currency_to_usd();
add_action('convert_ads_currency_to_usd', 'convert_ads_currency_to_usd');


add_action('wp_ajax_toggle_order', 'handle_toggle_order');
add_action('wp_ajax_nopriv_toggle_order', 'handle_toggle_order');

function handle_toggle_order() {

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


    if ($location == FALSE){
        $location_string = "around the World";
    } else {
        $location_string = "from " . $location; 
    }

    $active_institutions = get_active_institutions();

    $excluded = exclude_institutions ($location);

    

    $excluded_by_tier = exclude_institutions_by_tier($location);

    $excluded = array_merge($excluded, $excluded_by_tier);




    $order = $_POST['order'];
  
    // Prepare your query arguments based on the order
    $ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'meta_key' => 'tuition_USD',
        'orderby' => "meta_value_num",
        'order' => $order,
       
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
        ),
        
    );

    $loop = new WP_Query($ad_args);

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            $ad_id = get_the_ID();
            
            show_ads_card_new($ad_id); // Adjust this to your function for displaying a card
        }
    } else {
        echo 'No courses found.';
    }

    wp_die();
}






add_action('wp_ajax_load_ads', 'load_ads_ajax_handler');
add_action('wp_ajax_nopriv_load_ads', 'load_ads_ajax_handler');


function load_ads_ajax_handler() {

    $degree_value = $_POST['degree']; 
    $subject_value = $_POST['subject'];

    $country_value = $_POST['country'];
    $country_value = str_replace('-', ' ', $country_value);


    $subject_value = str_replace('-', ' ', $subject_value);
    $subject_value = ucwords($subject_value);

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
    $institute_ids_country = get_institution_ids($country_value);

    if ($country == "europe"){
        $institute_ids_country = array_merge(get_institution_ids("germany"), get_institution_ids("united kingdom"));      
    }

    $location = code_to_country($location);


    if ($location == FALSE){
        $location_string = "around the World";
    } else {
        $location_string = "from " . $location; 
    }

    $active_institutions = get_active_institutions();

    $excluded = exclude_institutions ($location);

    

    $excluded_by_tier = exclude_institutions_by_tier($location);

    $excluded = array_merge($excluded, $excluded_by_tier);

   
      
    // $degree_value = $_POST['degree']; 
    // $subject_value = $_POST['subject'];
    // $country_value = $_POST['country'];
    $country_value = str_replace('-', ' ', $country_value);

    $page = $_POST['page'] ?? 1;
    $order = $_POST['order'] ?? 'DESC';
    $adsPerPage = 30;
    $offset = ($page - 1) * $adsPerPage;
    // Prepare your query arguments based on the order
    $ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 30,
        'offset' => $offset, 
        'meta_key' => 'tuition_USD',
        'orderby' => "meta_value_num",
        'order' => $order,
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN'),      
        ),
    );

     $all_ad_args = array(
        'post_type' => 'ads',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'offset' => $offset, 
        'meta_key' => 'priority',
        'orderby' => "meta_value_num",
        'order' => "DESC",
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'adsInstitution', 'value' => $active_institutions, 'compare' => 'IN'),
            array('key' => 'adsInstitution', 'value' => $excluded, 'compare' => 'NOT IN')
        )
    );


    if ($subject_value) {
        $ad_args['meta_query'][] = array('key' => 'ads_subject', 'value' => $subject_value, 'compare' => 'LIKE');
    }

    if ($degree_value) {
        $ad_args['meta_query'][] = array('key' => 'degrees', 'value' => $degree_value, 'compare' => 'LIKE');
    }

    if ($country_value) {
        $ad_args['meta_query'][] = array('key' => 'adsInstitution', 'value' => $institute_ids_country, 'compare' => "IN");
    }

    $loop = new WP_Query($ad_args);

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            $ad_id = get_the_ID();
            show_ads_card_new($ad_id); // Ensure this function outputs the correct HTML for an ad
        }
    } else {
         

    $new_loop = new WP_Query($all_ad_args);
    $total_count = $new_loop->found_posts;
    if ($new_loop->have_posts()) {
        
        while ($new_loop->have_posts()) {
            $new_loop->the_post();
            $ad_id = get_the_ID(); // Correct way to get the post ID
            show_ads_card_new($ad_id);
        }
    }
    }

    wp_die(); // Always include this in your AJAX handlers
}




function display_post_categories_as_bubbles() {
    // Check if we are in a single post view
    if (is_single()) {
        // Get the current post ID
        $current_post_id = get_the_ID();

        // Get the standard categories for the current post
        $categories = get_the_terms($current_post_id, 'category');

        if ($categories && !is_wp_error($categories)) {
            // Start the output buffer
            ob_start();
            ?>
            <div class="post_categories">
                <?php foreach ($categories as $category) {
                    // Get the link for the category
                    $category_link = get_term_link($category);
                    ?>
                    <a href="<?php echo esc_url($category_link); ?>" class="post_category_link" style="color:black !important;">
                        <?php echo esc_html($category->name); ?>
                    </a>
                    <?php
                } ?>
            </div>
            <?php
            // Return the buffered content
            return ob_get_clean();
        }
    }
    return '';
}

add_shortcode('post_categories_bubbles', 'display_post_categories_as_bubbles');

/**
 * Update ACF field select on the fly when user types a select text it gets added in Select (NEW!) this is a custom behaviour -Not an ACF Default behaviour-
 * 
 */
function gs_update_select_choices( $post_id ) {

    // Check for autosave
    // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $select_field_key = 'field_65b373705f46b'; // Select Field Providers in External Scholarships CPT

    // Ensure the field is present in $_POST data
    if (!isset($_POST['acf'][$select_field_key])) return;

    // Get the submitted values
    $submitted_values = $_POST['acf'][$select_field_key];

    // Get the field object
    $field = get_field_object($select_field_key, false, false, false);

    if ($field && is_array($submitted_values)) {
        $new_choices_added = false;

        foreach ($submitted_values as $value) {
            // Check if this value is not already a choice in the field
            if (!in_array($value, $field['choices'])) {
                // Add new choice
                $field['choices'][$value] = $value;
                $new_choices_added = true;
            }
        }

        if ($new_choices_added) {
            // Save the updated field to database
            acf_update_field($field);
        }

        // Update the field value for the current post
        update_field($select_field_key, $submitted_values, $post_id);
    }
}
add_action('acf/save_post', 'gs_update_select_choices', 20);

/*
https://developers.google.com/identity/oauth2/web/guides/how-user-authz-works
*/
function add_login_modal_and_js() {
    ?>
<div id="gsLoginModal" style="display:none;" class="gs-modal">
    <div class="gs-modal-dialog">
        <div class="gs-modal-content">
            <div class="gs-modal-header">
                <!-- <span class="gs-close">&times;</span> -->
                <h2>Sign in to <span class="alt-title-color">Global Scholarships</span></h2>
            </div>
            <div class="gs-modal-body">
                    <?php 
                        /*
                        $client_id = '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com';
                        $redirect_uri = site_url('/google-callback'); // This should be https://www.example.com/google-callback
                        $login_url = 'https://accounts.google.com/o/oauth2/v2/auth?client_id=' . urlencode($client_id) . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&scope=openid%20email%20profile';
                        */
                    ?>
                    <?php echo do_shortcode('[mepr-login-form use_redirect="true"]'); ?>
                    <button type="button" id="googleLoginButton" class="gs-btn gs-btn-secondary"><svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="29" height="29" fill="url(#pattern0)"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_55_156" transform="scale(0.000488281)"/>
</pattern>
<image id="image0_55_156" width="2048" height="2048" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>
<span>Continue with Google</span></button>


            </div>
            <div class="gs-modal-footer">
                <span class="gs-modal-signup">Don't have an account?<a href="#"> <span class="alt-signup-text">Sign Up</span></a></span>
            </div>
        </div>
    </div>
</div>
<?php
}

add_action('wp_footer', 'add_login_modal_and_js');

// function my_google_login_button() {
//     $client_id = '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com';
//     $redirect_uri = site_url('/google-callback'); // This should be https://www.example.com/google-callback
//     $login_url = 'https://accounts.google.com/o/oauth2/v2/auth?client_id=' . urlencode($client_id) . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&scope=openid%20email%20profile';
//     echo '<a href="' . $login_url . '" class="google-login-button">Sign in with Google</a>';
// }
// add_action('login_form', 'my_google_login_button');

function delete_provider_posts() {
    $args = array(
        'post_type'      => 'provider',
        'posts_per_page' => -1,
        'post_status'    => 'any'
    );

    $provider_posts = new WP_Query($args);

    if ($provider_posts->have_posts()) {
        while ($provider_posts->have_posts()) {
            $provider_posts->the_post();
            wp_delete_post(get_the_ID(), true);
        }
    }

    wp_reset_postdata();
}

// Run to remove Posts and Post Type Provider
function remove_provider_post_type() {
    delete_provider_posts(); // Call function to delete all provider posts
    unregister_post_type( 'provider' );
}
// add_action( 'init', 'remove_provider_post_type', 100 );


// Cannot Reply to Comments issue caused by RankMath SEO Plugin source: https://wordpress.org/support/topic/cannot-reply-to-comments/
add_filter( 'rank_math/frontend/remove_reply_to_com', '__return_false');

function change_gs_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $user = false;

    if (is_numeric($id_or_email)) {
        $user = get_user_by('id', $id_or_email);
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $user = get_user_by('id', $id_or_email->user_id);
        }
    } else {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user && $avatar_url = get_user_meta($user->ID, 'avatar', true)) {
        $avatar = "<img alt='{$alt}' src='{$avatar_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    }

    return $avatar;
}

add_filter('get_avatar','change_gs_avatar', 10, 5);
