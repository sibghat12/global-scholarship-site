<?php

// Class Institutions Script

Class InstitutionsScripts {

	public $slug = 'institutions-scripts';

    public function __construct() {

		add_action( 'wp_ajax_export_institutions_data', array( $this, 'export_institutions_data' ) );
		add_action( 'wp_ajax_nopriv_export_institutions_data', array( $this, 'export_institutions_data' ) );

		add_action( 'wp_ajax_import_institutions', array( $this, 'import_institutions' ) );
		add_action( 'wp_ajax_nopriv_import_institutions', array( $this, 'import_institutions' ) );
		
		add_action( 'wp_ajax_get_institutions_json', array( $this, 'get_institutions_json' ) );
		add_action( 'wp_ajax_nopriv_get_institutions_json', array( $this, 'get_institutions_json' ) );
		
        add_action( 'wp_ajax_get_institutions_number', array( $this, 'get_institutions_number' ) );
		add_action( 'wp_ajax_nopriv_get_institutions_number', array( $this, 'get_institutions_number' ) );

		add_action( 'wp_ajax_delete_institutions', array( $this, 'delete_institutions' ) );
		add_action( 'wp_ajax_nopriv_delete_institutions', array( $this, 'delete_institutions' ) );

		// add_action( 'wp_ajax_set_sync_process_off', array( $this, 'set_sync_process_off' ) );
		// add_action( 'wp_ajax_nopriv_set_sync_process_off', array( $this, 'set_sync_process_off' ) );

		// add_action( 'acf/save_post', array( $this, 'update_credentials_file' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

    
    // Get all instituions and their meta data

    public function export_institutions_data()
    {  
        $false = 0;
        $institutions_status = 'publish';
        // Get all institutions custom post type ids

        $institute_args = array(
            'post_type' => 'institution',
            'post_status' => $institutions_status, // Change this according to your needs
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results'          => false,
            'fields' => 'ids',
        );

        $loop = new WP_Query($institute_args);

        $institutions_ids = $loop->get_posts();

        // Gather all advanced custom fields
        $institutions_saa = array();

        foreach($institutions_ids as $institution_id) {

            $city = get_field('cities', $institution_id, true);
            $founded = get_field('founded_year', $institution_id, true);
            $university_website = get_field('university_website', $institution_id);
            $institution_type = get_field('type', $institution_id);

            // Enrollment
            $enrollment = get_field('enrollment', $institution_id);
            $total = $enrollment['total'];
            $international = $enrollment['international'];

            //Admissions Pages
            $admissions_pages = get_field('admissions_pages', $institution_id);
            // Tuition Fees Pages
            $tuition_fee_pages = get_field('tuition_fee_pages', $institution_id);
            
            // Tuition Fees (Bachelor)
            $tuition_fee = get_field('tuition_fee', $institution_id);
            // Tuition Fees (Master)
            $tuition_fee_master = get_field('masters_tuition_fee', $institution_id);
            
            // Language Pages
            $language_pages = get_field('language_pages', $institution_id);

            // English Lagnuage Requirements
            $english_language_requirements = get_field('english_language_requirements', $institution_id);

            // Rankings
            $rankings = get_field('rankings', $institution_id);

            // Bachelor Courses
            $bachelors_courses = get_field('bachelors_courses', $institution_id);
            $bachelors_courses_link = $bachelors_courses['link'];
            $bachelors_courses_courses = $bachelors_courses['courses'];

            // Master Courses
            $masters_courses = get_field('masters_courses', $institution_id);
            $masters_courses_link = $masters_courses['link'];
            $masters_courses_courses = $masters_courses['courses'];



            $institutions_saa[] = array(
                'institution_title' => get_the_title($institution_id),
                'founded' => $founded,
                'website' => $university_website,
                'institution_type' =>  $institution_type,
                'enrollment' => [
                    'total' => $total,
                    'international' => $international
                ],
                'admissions_pages' => $admissions_pages,
                'tuition_fee_pages' => $tuition_fee_pages,
                'tuition_fee' => $tuition_fee,
                'tuition_fee_master' => $tuition_fee_master,
                'language_pages' => $language_pages,
                'english_language_requirements' => $english_language_requirements,
                'rankings' => $rankings,
                'bachelors_courses' => [
                    'bachelors_courses_link' =>  $bachelors_courses_link,
                    'bachelors_courses_courses' =>  $bachelors_courses_courses
                ],
                'masters_courses' => [
                    'masters_courses_link' =>  $masters_courses_link,
                    'masters_courses_courses' =>  $masters_courses_courses
                ]
            );

            if($city) {
                $institutions_saa[] = array(
                'cities' => $city->ID,
                );
            }


        }
        $json = wp_json_encode($institutions_saa);

        // global $wp_filesystem;

		// if ( empty( $wp_filesystem ) ) {
		// 	require_once ABSPATH . '/wp-admin/includes/file.php';
		// 	WP_Filesystem();
		// }
        // $file = fopen(get_stylesheet_directory() . '/scripts/saa-institutions-export.json', "w") or die("Unable to open file!");
		// $file       = get_stylesheet_directory() . '/scripts/saa-institutions-export.json';
		// $sync_group = get_field( 'sync_authorization_data', 'options' );
		// $data       = $sync_group['credentials_file'];
		// $wp_filesystem->put_contents( $file, $json );

        $file = fopen(get_stylesheet_directory() . '/scripts/saa-institutions-export.json', 'w');
        fwrite($file, $json);
        fclose($file);

        if ( $false > 0 ) {
            $results = array(
                'message' => 'Error Happened',
                'status'  => 0,
            );
        } else {
            $results = array(
                'message' => 'Successfully Exported into JSON Export File',
                'status'  => 1,
            );
        }

        echo wp_json_encode( $results );
        wp_die();


    }

    public function get_institutions_number() {
		$institutions_count = wp_count_posts( 'institution' );

		// Send to ajax
		if ( $institutions_count ) {
			echo esc_html( $institutions_count->draft );
		}

        wp_die();

	}

    public function get_institutions_json(){
        $string = file_get_contents(get_stylesheet_directory() . '/scripts/saa-institutions.json');

        echo $string;
        wp_die();
    }
    
    // Script to insert institutions with their advanced custom fields
    public function import_institutions()
    {
        // Decode JSON object

        $false = 0;
		if ( ! empty( $_POST['resultsJSONString'] ) ) { // phpcs:ignore

            $results_json_to_string = $_POST['resultsJSONString']; // phpcs:ignore

            $results_array = json_decode( stripslashes( $results_json_to_string ) );

            foreach($results_array as $array_item) {


                $array_posts_arg = array(
                    'post_title'  => $array_item->institution_title,
                    'post_type'   => 'institution',
                );
                // https://wordpress.stackexchange.com/questions/58593/check-if-post-title-exists-insert-post-if-doesnt-add-incremental-to-meta-if

                $the_post_id = '';
                if ( post_exists( $array_posts_arg['post_title'], '', '', 'institution' ) ) {
                    $the_post_id = post_exists( $array_posts_arg['post_title'], '', '', 'institution' );
                } else {
                    $array_posts_arg['post_status'] = 'draft';
                    $the_post_id = wp_insert_post( $array_posts_arg );
                }

                
                // $the_post_id = wp_insert_post($array_posts_arg);

                update_field('cities', $array_item->cities, $the_post_id);
                update_field('founded_year', $array_item->founded, $the_post_id);
                update_field('university_website', $array_item->website, $the_post_id);
                update_field('type', $array_item->institution_type, $the_post_id);

                //GRoup Field
                $group_enrollment = array(
                    'total' => $array_item->enrollment->total,
                    'international' => $array_item->enrollment->international,
                );
                update_field('enrollment', $group_enrollment, $the_post_id);

                //field_62651bc4a34a5 = admissions_pages (Repeater)
                $admissions_pages = array();
                if($array_item->admissions_pages) {
                    foreach($array_item->admissions_pages as $admission_page) {
                        $admissions_pages[] = array(
                            'degree_name' => $admission_page->degree_name,
                            'type' => $admission_page->type,
                            'admissions_link' => $admission_page->admissions_link,
                        );
                    }
                }
                update_field('admissions_pages', $admissions_pages, $the_post_id);

                //field_626c492cd2dc4 = tuition_fee_pages (Repeater)
                $tuition_fee_pages = array();
                if($array_item->tuition_fee_pages) {
                    foreach($array_item->tuition_fee_pages as $tuition_fee_page) {
                        $tuition_fee_pages[] = array(
                            'degree_name' => $tuition_fee_page->degree_name,
                            'type' => $tuition_fee_page->type,
                            'tuition_fee_link' => $tuition_fee_page->tuition_fee_link,
                        );
                    }
                }
                update_field('tuition_fee_pages', $tuition_fee_pages, $the_post_id);

                // Bachelors Tuition fees (Group)
                if($array_item->tuition_fee) {
                    $group_bachelor_tuition_fee = array(
                        'domestic_lower' => $array_item->tuition_fee->domestic_lower,
                        'domestic_upper_copy' => $array_item->tuition_fee->domestic_upper_copy,
                        'international_lower' => $array_item->tuition_fee->international_lower,
                        'upper_tuition_fee' => $array_item->tuition_fee->upper_tuition_fee,
                    );
                    update_field('tuition_fee', $group_bachelor_tuition_fee, $the_post_id);
                }

                // Masters Tuition fees (Group)
                if($array_item->tuition_fee_master) {
                    $group_masters_tuition_fee = array(
                        'domestic_lower' => $array_item->tuition_fee_master->domestic_lower,
                        'domestic_upper_copy' => $array_item->tuition_fee_master->domestic_upper_copy,
                        'international_lower' => $array_item->tuition_fee_master->international_lower,
                        'upper_tuition_fee' => $array_item->tuition_fee_master->upper_tuition_fee,
                    );
                    update_field('masters_tuition_fee', $group_masters_tuition_fee, $the_post_id);
                }

                // Language Pages (Repeater)
                $language_pages = array();
                if($array_item->language_pages) {
                    foreach($array_item->language_pages as $language_page) {
                        $language_pages[] = array(
                            'degree_name' => $language_page->degree_name,
                            'language' => $language_page->language,
                            'language_link' => $language_page->language_link,
                        );
                    }
                }

                update_field('language_pages', $language_pages, $the_post_id);

                // English Language Requirements (Repeater)
                $english_language_requirements = array();
                if($array_item->english_language_requirements) {
                    foreach($array_item->english_language_requirements as $english_language_requirement) {
                        $english_language_requirements[] = array(
                            'test_name' => $english_language_requirement->test_name,
                            'score' => $english_language_requirement->score,
                            'degree' => $english_language_requirement->degree,
                        );
                    }
                }

                update_field('english_language_requirements', $english_language_requirements, $the_post_id);
                
                
                // Rankings (Group)
                $group_rankings = array(
                    'qs' => $array_item->rankings->qs,
                    'the_ranking' => $array_item->rankings->the_ranking,
                    'usnews' => $array_item->rankings->usnews,
                    'edurank' => $array_item->rankings->edurank,
                    '4icu' => $array_item->rankings->{'4icu'}
                );

                update_field('rankings', $group_rankings, $the_post_id);

                $bachelors_courses_array = array();
                if($array_item->bachelors_courses->bachelors_courses_courses) {
                    foreach($array_item->bachelors_courses->bachelors_courses_courses as $course) {
                        array_push($bachelors_courses_array, $course->course_name);
                    }
                }

                $masters_courses_array = array();
                if($array_item->masters_courses->masters_courses_courses) {
                    foreach($array_item->masters_courses->masters_courses_courses as $course) {
                        array_push($masters_courses_array, $course->course_name);
                    }
                }

                $courses_names = array();
                if($bachelors_courses_array) {
                    foreach($bachelors_courses_array as $key => $val ) {
                        $courses_names[]['course_name'] = $val;
                    }
                }


                $masters_courses_names = array();
                if($masters_courses_array) {
                    foreach($masters_courses_array as $key => $val ) {
                        $masters_courses_names[]['course_name'] = $val;
                    }
                }

                // Update Bachelor's Courses (Group with nested repeater and url field)
                //GRoup Field
                $group_bachelors_courses = array(
                    'link' => $array_item->bachelors_courses->bachelors_courses_link,
                    'courses' => $courses_names
                );

                update_field('bachelors_courses', $group_bachelors_courses, $the_post_id);

                // Update Master's Courses (Group with nested repeater and url field)
                //GRoup Field
                $group_masters_courses = array(
                    'link' => $array_item->masters_courses->masters_courses_link,
                    'courses' => $masters_courses_names
                );

                update_field('masters_courses', $group_masters_courses, $the_post_id);


            }
            if ( $false > 0 ) {
                $results = array(
                    'message' => 'Error Happened',
                    'status'  => 0,
                );
            } else {
                $results = array(
                    'message' => 'Successfully Inserted',
                    'status'  => 1,
                );
            }

            echo wp_json_encode( $results );
        } else {
            $results = array(
                'message' => 'Congrats, Completed Succesfully!',
                'status'  => 3,
            );
            echo wp_json_encode( $results );
        }
        wp_die();

    }
        
    // Delete WordPress Posts
    public function delete_institutions()
    {
        // This will increment per each failure on delete.
		$false      = 0;
        $number_to_delete = 40;

        $status = 'draft';

        $institutions = get_posts(
            array(
                'numberposts' => $number_to_delete,
                'post_type'   => 'institution', // $post_type
                'post_status' => $status

            )
        );

        foreach ($institutions as $institution) {
            // Delete all institutions.
            $delete = wp_delete_post($institution->ID, true);
            if ( ! $delete ) {
				$false++;
			}
        }

        // After successful removal of Institutions, send a success message.
		if ( $false > 0 ) {
			$results = array(
				'message' => 'Error Occured',
				'status'  => 0,
			);
		} else {
			$results = array(
				'message' => 'Successfully Removed Institutions SAA',
				'status'  => 1,
			);
		}
			echo wp_json_encode( $results );
			wp_die();

        
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
		wp_enqueue_script(
			$this->slug,
			get_stylesheet_directory_uri() . '/assets/institutions-script.js',
			array( 'jquery' ),
			$version,
			true
		);
    }


}
new InstitutionsScripts();


