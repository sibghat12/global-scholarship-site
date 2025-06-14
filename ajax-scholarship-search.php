<?php

/**
 * search input scholarships or institutions with ajax
 */
class GS_Scholarship_Search_Ajax
{

    public $slug = 'gs_scholarship_search_ajax';

    public function __construct()
    {
        // Generate Json File Replace with init hook to run again

        // For Scholarship Search Page
        add_action('generate_scholarship_search_data', array($this, 'generate_scholarship_search_data'));

        // enqueue scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }


    // Generate Json File for all published institutions in institution Or scholarship post type using wp ajax and cron job
    public function generate_scholarship_search_data()
    {

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

        if ($institutions_posts_ids) :
            foreach ($institutions_posts_ids as $id) :
                $university_url_slug = get_post_field('post_name', $id);
                $institutions_scholarships_count = count(get_scholarships($id)->posts);

                // Add to array only if the count is 1 or more
                if ($institutions_scholarships_count >= 1) {
                    $data['gs_scholarship_institutions'][] = array(
                        'id' => $id,
                        'title' => get_the_title($id),
                        'permalink' => get_site_url() . '/institutions/' . $university_url_slug . '/',
                        'institution_scholarships' => $institutions_scholarships_count,
                    );
                }
            endforeach;
        endif;


        if ($scholarships_posts_ids) :
            foreach ($scholarships_posts_ids as $id) :
                $scholarship_url_slug = get_post_field('post_name', $id);
                $scholarship_host_institution = get_field('scholarship_institution', $id);
                $scholarship_type = get_field('amount_category', $id);

                $data['gs_scholarship_scholarships'][] = array(
                    'id' => $id,
                    'title' => get_the_title($id),
                    'permalink' => get_site_url() . '/scholarships/' . $scholarship_url_slug,
                    'institution_scholarship' => $scholarship_host_institution->post_title,
                    'scholarship_type' => $scholarship_type,
                );
            endforeach;
        endif;

        $json_file = json_encode($data);


        $file = fopen(get_stylesheet_directory() . '/scripts/search-scholarship-data.json', 'w');
        fwrite($file, $json_file);
        fclose($file);

        // wp_die();
    }






    public function enqueue_scripts()
    {
        // Assigning the current version for enqueuing scripts.
        if (WP_DEBUG) {
            $min     = '';
            $version = time();
        } else {
            $min     = '.min';
            $version = '1.0.0';
        }

        if (is_page_template('templates/template-filters.php') || is_404()) {
            wp_enqueue_script(
                $this->slug,
                get_stylesheet_directory_uri() . '/assets/ajax-scholarship-search.js',
                array('jquery'),
                $version,
                true
            );


            wp_localize_script(
                $this->slug,
                'my_ajax_object',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'script_url' => get_stylesheet_directory_uri() . '/scripts/',
                )
            );
        }
    }
}

new GS_Scholarship_Search_Ajax();
