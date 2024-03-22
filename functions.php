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
    if (!($page_template_slug == 'templates/template-deadlines.php' || $page_template_slug == 'templates/template-external-scholarships.php')) {
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

    wp_enqueue_script('test_script', get_stylesheet_directory_uri() . '/assets/dist/js/test.js', array('jquery'), '1.0.0', true);
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('scholarships')) {
        wp_enqueue_script('single-scholarship',  get_stylesheet_directory_uri() . '/assets/single-scholarship.js', array('jquery'), '1.0.0', true);
        wp_localize_script( 'single-scholarship', 'frontendajax', array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));
    }
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [], '7.1.0' );

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

    if(is_singular('scholarships' )) {
        wp_enqueue_style( 'scholarship-cpt-css', get_stylesheet_directory_uri() . '/assets/dist/css/test.css', [], '1.0.0' );
    }

    if(is_singular('scholarship_post' )) {
        wp_enqueue_script('gs-scholarship_post',  get_stylesheet_directory_uri() . '/assets/dist/js/single_scholarships_post.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style( 'gs-scholarship_post', get_stylesheet_directory_uri() . '/assets/dist/css/single_scholarships_post.css', [], '1.0.0' );
    }
    // Enqueue single-scholarship.js file in assets folder
    if(is_singular('institution') || is_singular('scholarships' ) || is_singular('scholarship-post' ) ) {
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

    wp_enqueue_script('gs_modal-signup',  get_stylesheet_directory_uri() . '/assets/signup-modal.js', array('jquery','google-platform'),
        time(),
        true );
        
        wp_localize_script('gs_modal-signup', 'myAjax', 
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'client_id' => "332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com",
                'redirect_uri' => site_url('/google-callback'),
                'security' => wp_create_nonce('my-ajax-nonce'),
                'siteUrl' => get_site_url(),
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

    if ( ! is_user_logged_in() ) {
        // Enqueue MailerLite script
        wp_enqueue_script('gs-mailerlite', get_stylesheet_directory_uri() . '/assets/mailerlite.js', array(), '1.0.0', true);

        // Enqueue local PushEngage script
        wp_enqueue_script('gs-pushengage', get_stylesheet_directory_uri() . '/assets/pushengage.js', array(), '1.0.0', true);
        
        // Enqueue the external PushEngage script
        wp_enqueue_script('gs-pushengage-external', 'https://clientcdn.pushengage.com/core/5786848d-070d-49f0-bfa5-13ae40254555.js', array(), null, true);
    }

    wp_enqueue_script('gs-snigel-adengine', get_stylesheet_directory_uri() . '/assets/snigel-adengine.js', array(), '1.0.0', true);

    // Pass the post type to the JavaScript file
    wp_localize_script('gs-snigel-adengine', 'snigelAdConfig', array('postType' => get_post_type()));

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );

function add_data_attribute($tag, $handle, $src) {
    // Only add the attribute to your specific script
    if ($handle === 'snigel-adengine') {
        $tag = str_replace('<script ', '<script data-cfasync="false" ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_data_attribute', 10, 3);


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
    if (is_page('scholarship-search') || is_404()) {
        wp_enqueue_style( 'scholarship-search-bootstrap-css', get_stylesheet_directory_uri() . '/assets/bootstrap/bootstrap-3.4.1.min.css', [], '3.4.1' );
        wp_enqueue_style( 'scholarship-search-bootstrap-select-css', get_stylesheet_directory_uri() . '/assets/bootstrap/bootstrap-select.min.css', [], '1.13.14' );
        
        
        // Enqueue jQuery if it's not already included
        if (!wp_script_is('jquery', 'enqueued')) {
            wp_enqueue_script( 'jquery' );
        }

        wp_enqueue_script( 'scholarship-search-bootstrap-js', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap-3.4.1.min.js', array('jquery'), '3.4.1', true );
        wp_enqueue_script( 'scholarship-search-bootstrap-select-js', get_stylesheet_directory_uri(). '/assets/bootstrap/bootstrap-select.min.js', array('jquery', 'scholarship-search-bootstrap-js'), '1.13.14', true );

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
    

//    $labels = array(
//     'name'               => __( 'Landing Pages', 'my_theme' ),
//     'singular_name'      => __( 'Landing Page', 'my_theme' ),
//     'add_new'            => __( 'Add New Landing Page', 'my_theme' ),
//     'add_new_item'       => __( 'Add New Landing Page', 'my_theme' ),
//     'edit_item'          => __( 'Edit Landing Page', 'my_theme' ),
//     'new_item'           => __( 'Add New Landing Page', 'my_theme' ),
//     'view_item'          => __( 'View Landing Page', 'my_theme' ),
//     'search_items'       => __( 'Search Landing Page', 'my_theme' ),
//     'not_found'          => __( 'No Landing Pages found', 'my_theme' ),
//     'not_found_in_trash' => __( 'No Landing Pages found in trash', 'my_theme' )
// );

// $supports = array(
//     'title',
//     'author',
//     'thumbnail',
//      'editor' // This enables the text editor
// );

// $args = array(
//     'labels'             => $labels,
//     'supports'           => $supports,
//     'public'             => true,
//     'capability_type'    => 'post',
//     'rewrite'            => array( 'slug' => 'landing-page' ),
//     'has_archive'        => false,
//     'menu_position'      => 30,
//     'menu_icon'          => 'dashicons-admin-multisite',
   
// );

// register_post_type( 'landing-page', $args );


   



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

    if ($country_value == "europe"){
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



    //  Start Here 
    
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

     if ($application_query) { 
    $meta_query[] = $application_query; 
    }

if (!empty($query)) { 
$institution_args = array(
    'post_type' => 'institution',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids', 
    's' => $query,
);
$institution_query = new WP_Query($institution_args);
$matching_institution_ids = $institution_query->posts;
}

if (!empty($query) AND  !empty($matching_institution_ids)) {  

if (!empty($matching_institution_ids)) {
    $meta_query[] = array(
        'key' => 'scholarship_institution',
        'value' => $matching_institution_ids,
        'compare' => 'IN',
    );
}


$ad_args_meta = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids', 
    'meta_query' => $meta_query,
);
$first_query = new WP_Query($ad_args_meta);
$first_query_ids = $first_query->posts;


$ad_args_search = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'fields' => 'ids', 
    's' => $query, 
);
$second_query = new WP_Query($ad_args_search);
$second_query_ids = $second_query->posts;


$combined_ids = array_unique(array_merge($first_query_ids, $second_query_ids));


$final_args = array(
    'post_type' => 'scholarships',
    'post_status' => 'publish',
    'posts_per_page' => $ppp,
    'offset' => $offset,
    'fields' => 'ids', // Only return post IDs
    'meta_key' => 'scholarship_weights',  // name of custom field
    'orderby' => 'meta_value_num',  // we want to order by numeric value
    'order' => 'DESC',  // highest to lowest

    'post__in' => $combined_ids,
   
);

$loop = new WP_Query($final_args);

} else {

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
   
   if ($meta_query){
        $ad_args['s'] = $query;
   }

   if ($meta_query){
        $ad_args['meta_query'] = $meta_query;
   }
      
     
    $loop = new WP_Query($ad_args);

}

    
    
    $text = "";
  

if($type_array[0]=="Full Funding"){
    $type_array[0] = "Fully Funded";
}if($type_array[0]=="Partial Funding"){
    $type_array[0] = "Partially Funded";
}



if ($type_array[0]) {
    if ($degrees_array[0]) {
        $text .= $loop->found_posts . " " . $type_array[0] . " " . $degrees_array[0];
    } else {
        $text .= $loop->found_posts . " " . $type_array[0];
    }
} else {
    if ($degrees_array[0]) {
        $text .= $loop->found_posts . " " . $degrees_array[0];
    } else {
        $text .= $loop->found_posts;
    }
}

// Add the $query conditionally after checking $type_array[0] and $degrees_array[0]
$text .= $query ? " \"" . $query . "\"" : "";
$text .= " Scholarships";



   if($locations_array[0]){
     $text .= " in " . $locations_array[0];
  } 
  if($subject_array[0]){
     $text .= " for " . $subject_array[0];
  } 


   if($nationality_array[0]){
     $text .= " for " . $nationality_array[0] . " Students";
  }else {
     $text .= " for International Students";
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
           
        }  else {

                     
                    $html = "<p style='font-size:18px;font-weight:500;'>There are  " . $text.".  Please broaden your filters and search again to find more scholarships." ;

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


function custom_category_query_adjustments($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_category()) {
        // Set the number of posts per page on category archives
        $query->set('posts_per_page', 12);
        // Add any other query adjustments here
    }
}
add_action('pre_get_posts', 'custom_category_query_adjustments');


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
            echo '<div class="more-scholarship-title-wrapper">';
            echo '<h2 class="scholarship-title more-scholarship-post-title"><a style="color:#333c4d !important;" href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
            echo '<div class="meta-scholarship-blog" style="width:33%;float:right;margin-top:8px;"><span style="float:left;">' . get_the_date() . '</span></div></div>';
             
            $excerpt = get_the_content();
            $excerpt = substr($excerpt, 0, 124);
            echo '<p class="more-scholarship-post-excerpt" >' . $excerpt . ' ....  
            <a href="' . esc_url(get_permalink()) . '" > Read more <i class="fa fa-arrow-right"></i> </a></p>';
            
            // Display scholarship categories associated with the current post
$taxonomy = 'scholarship_category';
$terms = get_the_terms(get_the_ID(), $taxonomy);
if ($terms && !is_wp_error($terms)) {
    echo '<div class="more-scholarship-post-categories">';
    echo '<ul class="category-list">';
    foreach ($terms as $term) {
        $term_link = get_term_link($term, $taxonomy);
        echo '<li><a href="' . esc_url($term_link) . '" class="scholarship_post_category_link" style="color:black !important;">' . esc_html($term->name) . '</a></li>';
    }
    echo '</ul>';
    echo '</div>';
}


            echo '</div>'; 
            echo '</div>'; 
           
        }
        
        echo '</div>'; // Close the div with class="row"
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
        <span class="mepr-nav-item gs-profile <?php MeprAccountHelper::active_nav('profile'); ?>">
            <a href="/account/?action=profile">Profile</a>
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
    if($action == 'profile') {
        include 'gs-memberpress-templates/profile.php';
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

    if ($country_value == "europe"){
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
                    <button type="button" id="googleLoginButton" class="gs-btn gs-btn-secondary"><?php echo get_svg_icon('google-icon'); ?>
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



//GS signup multistep modal
/*
https://developers.google.com/identity/oauth2/web/guides/how-user-authz-works
*/
function add_multistep_signup_modal_and_js() {
    ?>
<div id="gsSignupModal" style="display:none;" class="gs-modal">
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
                    <?php echo do_shortcode('[gs-multistep-register-form]'); ?>
                    <?php /* echo do_shortcode('[mepr-membership-registration-form id="86040"]'); */ ?>
                    <button type="button" id="googleSignupButton" class="gs-btn gs-btn-secondary"><?php echo get_svg_icon('google-icon'); ?>
<span>Continue with Google</span></button>


            </div>
            <div class="gs-modal-footer">
                <span class="gs-modal-signup gs-signup-gs-privacy-policy">By continuing, you agree and acknowledge Global Scholarship’s Privacy Policy.</span>
            </div>
        </div>
    </div>
</div>
<?php
}

add_action('wp_footer', 'add_multistep_signup_modal_and_js');


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

// function get_svg_icon($icon_name) {
//     // Path to the SVG file
//     $svg_file_path = get_stylesheet_directory() . '/assets/images/' . $icon_name . '.svg';
    
//     // Check if the SVG file exists
//     if (file_exists($svg_file_path)) {
//         // Return the contents of the SVG file
//         return file_get_contents($svg_file_path);
//     }

//     // Return an empty string if the file doesn't exist
//     return '';
// }

// Use a global variable to count the number of times an SVG is rendered
global $_SVG_RENDER_COUNT;
if (!isset($_SVG_RENDER_COUNT)) {
    $_SVG_RENDER_COUNT = 0;
}

function get_svg_icon($icon_name) {
    global $_SVG_RENDER_COUNT;
    
    // Increment the render count
    $_SVG_RENDER_COUNT++;

    // Path to the SVG file
    $svg_file_path = get_stylesheet_directory() . '/assets/images/' . $icon_name . '.svg';
    
    // Generate a unique but consistent ID for each render of the SVG
    $unique_id = 'pattern' . hash('crc32', $icon_name . $_SVG_RENDER_COUNT);

    // Check if the SVG file exists
    if (file_exists($svg_file_path)) {
        // Get the contents of the SVG file
        $svg_content = file_get_contents($svg_file_path);
        
        // Replace the pattern ID and fill attribute with the new unique ID
        $svg_content = str_replace('id="pattern0"', 'id="' . $unique_id . '"', $svg_content);
        $svg_content = str_replace('fill="url(#pattern0)"', 'fill="url(#' . $unique_id . ')"', $svg_content);

        // Return the modified SVG content
        return $svg_content;
    }

    // Return an empty string if the file doesn't exist
    return '';
}


function my_multistep_form_shortcode() {
    ob_start(); // Start output buffer to return the form as a string

    $countries = array('USA', 'Canada', 'UK');
    $subjects = array('Mathematics', 'Science', 'History');

    ?>
    
    <form id="gsMultiStepFormRegister" class="gs-form-register" method="post">
        <div class="steps-navigation" style="display:none;">
            <span class="step">01</span>
            <span class="step">02</span>
            <span class="step">03</span>
            <span class="step">04</span>
            <!-- Add or remove steps as necessary -->
        </div>
        <!-- Step 1 -->
        <div class="form-step">

            <label for="gs_user_email">Email</label>
            <input type="email" name="email" id="gs_user_email" placeholder="Email" required>
            <label for="gs_user_password">Email</label>
            <input type="password" name="password"  id="gs_user_password" placeholder="Password" required>
            <label for="gs_newsletter">
                <input type="checkbox" id="gs_newsletter" name="gs_newsletter"> <span>Accept receiving newsletter</span>
            </label>
        </div>

        <!-- Step 2 -->
        <div class="form-step" style="display:none">
            <input type="text" name="gs_first_name" placeholder="First Name" required>
            <input type="text" name="gs_last_name" placeholder="Last Name" required>
            <input type="date" name="gs_birth_date" required>
            <select name="gs_gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <div class="gs-home-country">Home Country:</div>

            <select name="gs_home_country" required>
                <option value=""></option>
                <?php foreach($countries as $country): ?>
                    <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="prev-btn">Previous</button>
        </div>

        <!-- Step 3 -->
        <div class="form-step" style="display:none">
            <div class="degree-options">
                <div class="gs-degree-choose">Choose Degree:</div>
                <input type="radio" id="bachelor" name="gs_degree" value="bachelor">
                <label for="bachelor" class="degree-label">Bachelor</label>

                <input type="radio" id="master" name="gs_degree" value="master">
                <label for="master" class="degree-label">Master</label>

                <input type="radio" id="phd" name="gs_degree" value="phd">
                <label for="phd" class="degree-label">Ph.D.</label>
            </div>
            <button type="button" class="prev-btn">Previous</button>
        </div>
        <!-- Step 4 -->
        <div class="form-step" style="display:none">
            <div class="gs-country-choose">Choose a Country:</div>

            <select name="gs_interested_country" required>
                <option value=""></option>
                <?php foreach($countries as $country): ?>
                    <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="prev-btn">Previous</button>
        </div>
        <!-- Step 5 -->
        <div class="form-step" style="display:none">
            <div class="gs-subject-choose">Choose a Subject:</div>

            <select name="gs_subject" required>
                <option value=""></option>
                <?php foreach($subjects as $subject): ?>
                    <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="prev-btn">Previous</button>
        </div>



        <input type="button" name="wp-signup-continue" id="wp-signup-continue-btn" class="button-primary gs-signup-button-continue" value="Continue">
    </form>
   
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('gs-multistep-register-form', 'my_multistep_form_shortcode');


function gs_register_new_user() {
    check_ajax_referer('my-ajax-nonce', 'security');

    $email = sanitize_email($_POST['gs_email']);
    $password = $_POST['gs_password']; // Ensure to validate and sanitize
    $newsletter = sanitize_text_field($_POST['gs_newsletter']);
    $first_name = sanitize_text_field($_POST['gs_first_name']);
    $last_name = sanitize_text_field($_POST['gs_last_name']);
    $birth_date = sanitize_text_field($_POST['gs_birth_date']);
    $gender = sanitize_text_field($_POST['gs_gender']);
    $home_country = sanitize_text_field($_POST['gs_home_country']);
    $degree = sanitize_text_field($_POST['gs_degree']);
    $country = sanitize_text_field($_POST['gs_interested_country']);
    $subject = sanitize_text_field($_POST['gs_subject']);

    if (!is_email($email) || empty($password)) {
        wp_send_json_error(['message' => 'Invalid email or password.']);
        return;
    }

    $user_id = wp_create_user($email, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error(['message' => $user_id->get_error_message()]);
        return;
    }

    // Update user meta with additional information
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'gs_newsletter', $newsletter);
    update_user_meta($user_id, 'birth_date', $birth_date);
    update_user_meta($user_id, 'gender', $gender);
    update_user_meta($user_id, 'home_country', $home_country);
    update_user_meta($user_id, 'degree', $degree);
    update_user_meta($user_id, 'interested_country', $country);
    update_user_meta($user_id, 'subject', $subject);

    wp_send_json_success(['message' => 'User registered successfully.', 'user_id' => $user_id]);
}
add_action('wp_ajax_gs_register_new_user', 'gs_register_new_user');
add_action('wp_ajax_nopriv_gs_register_new_user', 'gs_register_new_user');



// Hook to add additional user fields
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');

function custom_user_profile_fields($user) {

    
    $countries = array('USA', 'Canada', 'UK');
    $subjects = array('Mathematics', 'Science', 'History');

    ?>
    <h3>Additional Information</h3>

    <table class="form-table">
        <tr>
            <th><label for="gs_newsletter">Newsletter Subscription</label></th>
            <td>
                <input type="checkbox" name="gs_newsletter" id="gs_newsletter" value="yes" <?php checked('yes', get_user_meta($user->ID, 'gs_newsletter', true)); ?>/>
                <span class="description">Check to subscribe to the newsletter.</span>
            </td>
        </tr>
        <tr>
            <th><label for="birth_date">Birth Date</label></th>
            <td>
                <input type="date" name="birth_date" id="birth_date" value="<?php echo esc_attr(get_user_meta($user->ID, 'birth_date', true)); ?>" class="gs_input_text" />
            </td>
        </tr>
        <tr>
            <th><label for="gender">Gender</label></th>
            <td>
                <select name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="male" <?php selected('male', get_user_meta($user->ID, 'gender', true)); ?>>Male</option>
                    <option value="female" <?php selected('female', get_user_meta($user->ID, 'gender', true)); ?>>Female</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="home_country">Home Country</label></th>
            <td>
                <select name="home_country" id="home_country" class="gs_input_text">
                    <option value="">Select Country</option>
                    <?php foreach($countries as $country): ?>
                        <option value="<?php echo esc_attr($country); ?>" <?php selected($country, get_user_meta($user->ID, 'home_country', true)); ?>><?php echo esc_html($country); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
        <tr>
            <th><label for="degree">Degree</label></th>
            <td>
                <select name="degree" id="degree">
                    <option value="bachelor" <?php selected('bachelor', get_user_meta($user->ID, 'degree', true)); ?>>Bachelor</option>
                    <option value="master" <?php selected('master', get_user_meta($user->ID, 'degree', true)); ?>>Master</option>
                    <option value="phd" <?php selected('phd', get_user_meta($user->ID, 'degree', true)); ?>>Ph.D.</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="interested_country">Interested Country</label></th>
            <td>
                <select name="interested_country" id="interested_country" class="gs_input_text">
                    <option value="">Select Country</option>
                    <?php foreach($countries as $country): ?>
                        <option value="<?php echo esc_attr($country); ?>" <?php selected($country, get_user_meta($user->ID, 'interested_country', true)); ?>><?php echo esc_html($country); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="subject">Subject</label></th>
            <td>
                <select name="subject" id="subject" class="gs_input_text">
                    <option value="">Select Subject</option>
                    <?php foreach($subjects as $subject): ?>
                        <option value="<?php echo esc_attr($subject); ?>" <?php selected($subject, get_user_meta($user->ID, 'subject', true)); ?>><?php echo esc_html($subject); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}



// Hook to save the custom user fields
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

function save_custom_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Check if the fields are set and not empty, then update user meta
    if (isset($_POST['gs_birth_date']) && !empty($_POST['gs_birth_date'])) {
        update_user_meta($user_id, 'birth_date', sanitize_text_field($_POST['gs_birth_date']));
    }

    if (isset($_POST['gs_gender']) && !empty($_POST['gs_gender'])) {
        update_user_meta($user_id, 'gender', sanitize_text_field($_POST['gs_gender']));
    }

    if (isset($_POST['gs_home_country']) && !empty($_POST['gs_home_country'])) {
        update_user_meta($user_id, 'home_country', sanitize_text_field($_POST['gs_home_country']));
    }

    if (isset($_POST['gs_degree']) && !empty($_POST['gs_degree'])) {
        update_user_meta($user_id, 'degree', sanitize_text_field($_POST['gs_degree']));
    }

    if (isset($_POST['gs_interested_country']) && !empty($_POST['gs_interested_country'])) {
        update_user_meta($user_id, 'interested_country', sanitize_text_field($_POST['gs_interested_country']));
    }

    if (isset($_POST['gs_subject']) && !empty($_POST['gs_subject'])) {
        update_user_meta($user_id, 'subject', sanitize_text_field($_POST['gs_subject']));
    }

    // For checkboxes, checking if set is sufficient
    update_user_meta($user_id, 'gs_newsletter', isset($_POST['gs_newsletter']) && $_POST['gs_newsletter'] === 'yes' ? 'yes' : 'no');
}



// function save_custom_user_profile_fields($user_id) {
//     if (!current_user_can('edit_user', $user_id)) {
//         return false;
//     }

//     update_user_meta($user_id, 'birth_date', $_POST['gs_birth_date']);
//     update_user_meta($user_id, 'gender', $_POST['gs_gender']);
//     update_user_meta($user_id, 'home_country', $_POST['gs_home_country']);
//     update_user_meta($user_id, 'degree', $_POST['gs_degree']);
//     update_user_meta($user_id, 'interested_country', $_POST['gs_interested_country']);
//     update_user_meta($user_id, 'subject', $_POST['gs_subject']);
//     // Save the Newsletter Subscription state
//     if (!empty($_POST['gs_newsletter']) && $_POST['gs_newsletter'] === 'yes') {
//         update_user_meta($user_id, 'gs_newsletter', 'yes');
//     } else {
//         delete_user_meta($user_id, 'gs_newsletter');
//     }
// }


add_filter('rank_math/frontend/breadcrumb/items', function($crumbs, $class) {

    if (is_singular("scholarships")) {

        $post_id = get_the_ID();
        $institution = get_field("scholarship_institution", $post_id);

        $city = get_post($institution->cities);
        $city_name = get_the_title($city);
        $country_name = get_post_meta($city->ID, 'country', TRUE);

        $lowercase = strtolower($country_name);
        $hyphenated = str_replace(' ', '-', $lowercase);

        $institution_query = get_institution_by_id($institution->ID);
        
        while ($institution_query->have_posts()) {
            $institution_query->the_post();
            $institution_name = get_the_title();
        }
        wp_reset_postdata();
        $country_name = $country_name . " Scholarships";
        $institution_link = get_permalink($institution->ID);

        $last_item = $crumbs[1];
        $crumbs[1] = [
            'Scholarships',
            site_url() . '/scholarship-search',
        ];

        $crumbs[2] = [
            $country_name,
            site_url() . '/scholarship-search/' . $hyphenated,
        ];

        $crumbs[3] = [
            $institution_name . ' Scholarships',
            $institution_link,
        ];

        $crumbs[4] = $last_item;
    }

     if (is_singular("institution")) {
    
    wp_reset_postdata();
    
    $institution_post_id = get_the_ID();
    $institution_title = get_the_title();
    
    $institution = get_post($institution_post_id);
    
    $city = get_post($institution->cities);

    $city_name = get_the_title($city);
    $country_name = get_post_meta($city->ID, 'country', TRUE);

        $lowercase = strtolower($country_name);
        $hyphenated = str_replace(' ', '-', $lowercase);
        $country_name = $country_name . " Scholarships";
        
        wp_reset_postdata();
        $last_item1 = $crumbs[1];
        
        $crumbs[1] = [
             $country_name,
             site_url() . '/scholarship-search/' . $hyphenated,
        ]; 
        

        $crumbs[2] = [
             $institution_title . ' Scholarships for International Students',
             '',
             'hide_in_schema' => '',
        ]; 

     }

    return $crumbs;

}, 10, 2);







function custom_mime_types( $mime_types ) {
    $mime_types['avif'] = 'image/avif'; // Adding .avif
    return $mime_types;
}
add_filter( 'mime_types', 'custom_mime_types' );

function add_avif_upload_support( $checked, $file, $filename, $mimes ) {
    if ( ! $checked['type'] ) {
        $check_filetype = wp_check_filetype( $filename, $mimes );
        $ext = $check_filetype['ext'];
        $type = $check_filetype['type'];
        $proper_filename = $filename;

        if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
            $checked = compact( 'ext', 'type', 'proper_filename' );
        } else {
            $checked = array( 'ext' => false, 'type' => false, 'proper_filename' => false );
        }
    }

    return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'add_avif_upload_support', 10, 4 );

