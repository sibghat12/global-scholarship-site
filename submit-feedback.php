<?php

add_action('wp_ajax_feedback_form', 'process_feedback_form');
add_action('wp_ajax_nopriv_feedback_form', 'process_feedback_form');

function process_feedback_form() {
      // Check honeypot field for spam
      if (!empty($_POST['gs_email'])) {
        wp_send_json_error(array(
        'message' => 'Spam detected'
        ), 400);
        wp_die();
    }
    global $wpdb;

    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';
    $feedback_data = array(
        'improvement' => isset($_POST['improvement']) ? sanitize_text_field($_POST['improvement']) : '',
        'scholarship_info' => isset($_POST['scholarship_info']) ? $_POST['scholarship_info'] : [],
        'date' => isset($_POST['date']) ? $_POST['date'] : ''
    );

    $feedback_data['incorrect_info_improvement'] = (isset($_POST['incorrect_info_improvement']) && sanitize_text_field($_POST['improvement']) == 'incorrect_info') ? sanitize_text_field($_POST['incorrect_info_improvement']) : '';
    $feedback_data['outdated_info_improvement'] = (isset($_POST['outdated_info_improvement']) && sanitize_text_field($_POST['improvement']) == 'outdated_info') ? sanitize_text_field($_POST['outdated_info_improvement']) : '';
    $feedback_data['not_for_international_improvement'] = (isset($_POST['not_for_international_improvement']) && sanitize_text_field($_POST['improvement']) == 'not_for_international' ) ? sanitize_text_field($_POST['not_for_international_improvement']) : '';
    $feedback_data['not_easy_to_read_improvement'] = (isset($_POST['not_easy_to_read_improvement']) && sanitize_text_field($_POST['improvement']) == 'not_easy_to_read') ? sanitize_text_field($_POST['not_easy_to_read_improvement']) : '';
    $feedback_data['details_missing_improvement'] = (isset($_POST['details_missing_improvement']) && sanitize_text_field($_POST['improvement']) == 'details_missing') ? sanitize_text_field($_POST['details_missing_improvement']) : '';
    $feedback_data['not_clear_procedures_improvement'] = (isset($_POST['not_clear_procedures_improvement']) && sanitize_text_field($_POST['improvement']) == 'not_clear_procedures' ) ? sanitize_text_field($_POST['not_clear_procedures_improvement']) : '';
    $feedback_data['suggestion_improvement'] = (isset($_POST['suggestion_improvement']) && sanitize_text_field($_POST['improvement']) == 'suggestion') ? sanitize_text_field($_POST['suggestion_improvement']) : '';

    $wpdb->insert(
        $table_name,
        array(
        'improvement' => $feedback_data['improvement'],
        'incorrect_info_improvement' => $feedback_data['incorrect_info_improvement'],
        'outdated_info_improvement' => $feedback_data['outdated_info_improvement'],
        'not_for_international_improvement' => $feedback_data['not_for_international_improvement'],
        'not_easy_to_read_improvement' => $feedback_data['not_easy_to_read_improvement'],
        'details_missing_improvement' => $feedback_data['details_missing_improvement'],
        'not_clear_procedures_improvement' => $feedback_data['not_clear_procedures_improvement'],
        'suggestion_improvement' => $feedback_data['suggestion_improvement'],
        'scholarship_url' => isset($feedback_data['scholarship_info']['url']) ? sanitize_text_field($feedback_data['scholarship_info']['url']) : '',
        'scholarship_edit_url' => isset($feedback_data['scholarship_info']['edit_url']) ? sanitize_text_field($feedback_data['scholarship_info']['edit_url']) : '',
        'scholarship_id' => isset($feedback_data['scholarship_info']['id']) ? absint($feedback_data['scholarship_info']['id']) : 0,
        'scholarship_title' => isset($feedback_data['scholarship_info']['title']) ? sanitize_text_field($feedback_data['scholarship_info']['title']) : '',
        'date' => $feedback_data['date']
        )
    );

    // Process the feedback data here

    wp_send_json_success(array(
        'data' => $feedback_data,
        'message' => 'Feedback submitted successfully.'
    ), 200);

    wp_die();
}

function create_table_for_gs_scholarships_feedback_form() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';

    $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    improvement varchar(50) NOT NULL,
    scholarship_url varchar(255) NOT NULL,
    scholarship_edit_url varchar(255) NOT NULL,
    scholarship_id mediumint(9) NOT NULL,
    scholarship_title varchar(255) NOT NULL,
    date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    PRIMARY KEY  (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

add_action('init', 'create_table_for_gs_scholarships_feedback_form');

function add_new_columns() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';

    // Define column names
    $column_name_1 = 'incorrect_info_improvement';
    $column_name_2 = 'outdated_info_improvement';
    $column_name_3 = 'not_for_international_improvement';
    $column_name_4 = 'not_easy_to_read_improvement';
    $column_name_5 = 'details_missing_improvement';
    $column_name_6 = 'not_clear_procedures_improvement';
    $column_name_7 = 'suggestion_improvement';

    // Check if column 1 exists
    $column_1_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_1'");
    if ($column_1_exists !== $column_name_1) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_1 TEXT NOT NULL");
    }

    // Check if column 2 exists
    $column_2_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_2'");
    if ($column_2_exists !== $column_name_2) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_2 TEXT NOT NULL");
    }

    // Check if column 3 exists
    $column_3_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_3'");
    if ($column_3_exists !== $column_name_3) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_3 TEXT NOT NULL");
    }

    // Check if column 4 exists
    $column_4_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_4'");
    if ($column_4_exists !== $column_name_4) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_4 TEXT NOT NULL");
    }

    // Check if column 5 exists
    $column_5_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_5'");
    if ($column_5_exists !== $column_name_5) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_5 TEXT NOT NULL");
    }

    // Check if column 6 exists
    $column_6_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_6'");
    if ($column_6_exists !== $column_name_6) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_6 TEXT NOT NULL");
    }

    // Check if column 7 exists
    $column_7_exists = $wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE '$column_name_7'");
    if ($column_7_exists !== $column_name_7) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name_7 TEXT NOT NULL");
    }
}

add_action('init', 'add_new_columns', 1);

function drop_columns_if_exist() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';

    // Check if the table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    if ($table_exists) {
        // Define columns to drop
        $columns_to_drop = array(
            'helpful',
            'other_improvement',
        );

        // Get the existing columns from the table
        $existing_columns = $wpdb->get_col("DESCRIBE $table_name", 0);

        // Loop through the columns to drop
        foreach ($columns_to_drop as $column) {
            if (!in_array($column, $existing_columns)) {
                return;
            }

            $wpdb->query("ALTER TABLE $table_name DROP COLUMN $column");
        }
    }
}

add_action('admin_init', 'drop_columns_if_exist');