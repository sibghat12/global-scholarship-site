<?php

/**
 * search input institutions with ajax
 */
class GS_Search_Ajax {

    public $slug = 'gs_search_ajax';
    
    public function __construct() {
        // Generate Json File Replace with init hook to run again

        // For Home Page Search
        add_action('generate_data', array($this, 'generate_data'));
        // add_action('generate_locations', array($this, 'generate_locations'));

        // enqueue scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    
    // Generate Json File for all published institutions in institution post type using wp ajax and cron job
    public function generate_data() {

        
        $scholarship_details  = acf_get_fields('group_62ca6e3cc910c');
        
        // Get subjects and their choices
        $subjects = array_column($scholarship_details, null, 'name')['eligible_programs'];
        $subjects = $subjects['choices'];

        // Get countries and their choices
        $countries = array_column($scholarship_details, null, 'name')['published_countries'];
        $countries = $countries['choices'];

        $data = array();
                
        if($countries) :
            foreach($countries as $country) :

                $country_slug = strtolower(str_replace(' ', '-', $country));

                $data['gs_country'][] = array(
                    'title' => $country,
                    'permalink' => get_site_url() .'/scholarship-search/'. $country_slug,
                );
            endforeach;
        endif; 
        
        if($subjects) :
            foreach($subjects as $subject) :

                $subject_slug = strtolower(str_replace(' ', '-', $subject));

                $data['gs_subject'][] = array(
                    'title' => $subject,
                    'permalink' => get_site_url() .'/scholarship-search/'. $subject_slug,
                );
            endforeach;
        endif; 
        
        // Institutions
        $institutions_args = array(
            'post_type' => 'institution',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true, 
            'update_post_meta_cache' => false, 
            'update_post_term_cache' => false,   
            'cache_results'          => false,
            'fields' => 'ids'
        );
        $the_loop_institutions = new WP_Query($institutions_args);
        $institutions_posts_ids = $the_loop_institutions->posts;
        
        // Scholarships
        $scholarships_args = array(
            'post_type' => 'scholarships',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true, 
            'update_post_meta_cache' => false, 
            'update_post_term_cache' => false,   
            'cache_results'          => false,
            'fields' => 'ids'
        );
        $the_loop_scholarships = new WP_Query($scholarships_args);
        $scholarships_posts_ids = $the_loop_scholarships->posts;
        
        if($institutions_posts_ids) :
            foreach($institutions_posts_ids as $id) :
                $university_url_slug = get_post_field('post_name', $id);

                $data['gs_institutions'][] = array(
                    'id' => $id,
                    'title' => get_the_title($id),
                    'permalink' => get_site_url() .'/institutions/'. $university_url_slug,
                );
            endforeach;
        endif; 
        
        if($scholarships_posts_ids) :
            foreach($scholarships_posts_ids as $id) :
                $scholarship_url_slug = get_post_field('post_name', $id);

                $data['gs_scholarships'][] = array(
                    'id' => $id,
                    'title' => get_the_title($id),
                    'permalink' => get_site_url() .'/scholarships/'. $scholarship_url_slug,
                );
            endforeach;
        endif; 

        $json_file = json_encode($data);

        
        $file = fopen( get_stylesheet_directory() . '/scripts/search-data.json', 'w');
        fwrite($file, $json_file);
        fclose($file);
        
        // wp_die();
    }



    

    
    public function enqueue_scripts() {
        // Assigning the current version for enqueuing scripts.
		if ( WP_DEBUG ) {
			$min     = '';
			$version = time();
		} else {
			$min     = '.min';
			$version = '1.0.0';
		}

        if (!is_page_template('page-homepage.php')) {
            return;
        }
		wp_enqueue_script(
			$this->slug,
			get_stylesheet_directory_uri() . '/assets/ajax-search.js',
			array( 'jquery' ),
			$version,
			true
		);

        
        wp_localize_script( $this->slug, 'my_ajax_object',
        array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'script_url' => get_stylesheet_directory_uri() . '/scripts/',
        ) );
        
    }



}

new GS_Search_Ajax();