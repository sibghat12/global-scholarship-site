<?php


/**
 * Class SAA Cities CPT
 * @package SAA
 */
class SAA_Cities {

	/**
	 * @var string
	 */
	public $name = 'saa_cities';
	/**
	 * @var string
	 */
	public $slug = 'saa';

	/**
	 * Example constructor.
	 */
	public function __construct() {
		// AJAX Calls.

		add_action( 'wp_ajax_exportSAACitiesCSV', array( $this, 'export_saa_cities' ) );
		add_action( 'wp_ajax_nopriv_exportSAACitiesCSV', array( $this, 'export_saa_cities' ) );
		
        add_action( 'wp_ajax_get_cities_csv', array( $this, 'get_cities_csv' ) );
		add_action( 'wp_ajax_nopriv_get_cities_csv', array( $this, 'get_cities_csv' ) );

        add_action( 'wp_ajax_import_cities', array( $this, 'import_cities' ) );
		add_action( 'wp_ajax_nopriv_import_cities', array( $this, 'import_cities' ) );
		
        add_action( 'wp_ajax_get_cities_institutions', array( $this, 'get_cities_institutions' ) );
		add_action( 'wp_ajax_nopriv_get_cities_institutions', array( $this, 'get_cities_institutions' ) );

		add_action( 'wp_ajax_import_cities_institutions', array( $this, 'import_cities_institutions' ) );
		add_action( 'wp_ajax_nopriv_import_cities_institutions', array( $this, 'import_cities_institutions' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * @return mixed
	 */


    /**
     *
     */
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
			get_stylesheet_directory_uri() . '/assets/saa-cities-script.js',
			array( 'jquery' ),
			$version,
			true
		);

        wp_localize_script(
            $this->slug,
            $this->name,
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('ajax-nonce'),
            )
        );
    }


    // Export SAA cities in CSV file
    public function export_saa_cities() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
			die( 'Security Check Error!' );
		} else {
			$query_results = array();
			$args          = array(
				'post_type'      => 'city',
				'posts_per_page' => -1,
			);
			$query         = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$post_id        = get_the_ID();
                    $city_title     = get_the_title();
					
					// Cities ACF
					$continent = get_field( 'continent', $post_id );
					$country = get_field( 'country', $post_id );
					$state = get_field( 'state', $post_id );

					$query_results[] = array(
						'city_id'        => $post_id,
						'city_title'        => $city_title,
						'saa_continent'  => $continent,
						'saa_country'  => $country,
						'saa_state'  => $state,
					);
				}
				if ( $query_results ) {
					try {
                        $output_handle = @fopen( 'php://output', 'w' ); //phpcs:ignore
						// Parse results to csv format
						foreach ( $query_results as $row ) {

							$lead_array = (array) $row; // Cast the Object to an array
							// Add row to file
							fputcsv( $output_handle, $lead_array );
						}

						// Close output file stream
                        fclose( $output_handle ); //phpcs:ignore

						wp_die();
					} catch ( \Exception $e ) {
						echo ' There is an error!';
						wp_die();
					}
				}
			}
		}
	}

    public function get_cities_csv(){
        $string = file_get_contents(get_stylesheet_directory() . '/scripts/saa_cities.csv');

        echo $string;
        wp_die();
    }

	// Script to insert institutions with their advanced custom fields
	public function import_cities()
	{
		// Decode JSON object

		$false = 0;
		if (! empty($_POST['resultsJSONString'])) { // phpcs:ignore

			$results_json_to_string = $_POST['resultsJSONString']; // phpcs:ignore

			$results_array = json_decode(stripslashes($results_json_to_string));

			foreach($results_array as $array_item) {
				
				$array_posts_arg = array(
					'post_title'  => $array_item[1],
					'post_type'   => 'city',
				);

				$the_post_id = '';
				if ( post_exists( $array_posts_arg['post_title'], '', '', 'city' ) ) {
					$the_post_id = post_exists( $array_posts_arg['post_title'], '', '', 'city' );
				} else {
					$array_posts_arg['ID'] = $the_post_id;
					$array_posts_arg['post_status'] = 'publish';
					$the_post_id = wp_insert_post( $array_posts_arg );
				}

				update_field('continent', $array_item[2], $the_post_id);
				update_field('country', $array_item[3], $the_post_id);
				update_field('state', $array_item[4], $the_post_id);

				

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
	}

    public function get_cities_institutions(){
        $string = file_get_contents(get_stylesheet_directory() . '/scripts/cities_institutions.csv');

        echo $string;
        wp_die();
    }


    // Script to insert institutions with their advanced custom fields
    public function import_cities_institutions()
    {
        // Decode JSON object

        $false = 0;
        if (! empty($_POST['resultsJSONString'])) { // phpcs:ignore

            $results_json_to_string = $_POST['resultsJSONString']; // phpcs:ignore

            $results_array = json_decode(stripslashes($results_json_to_string));

			
            foreach($results_array as $array_item) {
				
				$institution_title = $array_item[0];
				$city_title = $array_item[1];
				$institution = get_page_by_title($institution_title , OBJECT, "institution")->ID;
				$city = get_page_by_title($city_title, OBJECT, "city")->ID;

				$field_key = "cities";
				if($institution){
					update_field($field_key, $city, $institution);
				}

            }
            if ( $false > 0 ) {
                $results = array(
                    'message' => 'Error Happened',
                    'status'  => 0,
                );
            } else {
                $results = array(
                    'message' => 'Successfully Updated the Institutions with their Cities',
                    'status'  => 1,
                );
            }

            echo wp_json_encode( $results );
        } else {
            $results = array(
                'message' => 'Congrats, Completed Succesfully Updating the Institutions with their Cities!',
                'status'  => 3,
            );
            echo wp_json_encode( $results );
        }
    }
 
}

new SAA_Cities();
