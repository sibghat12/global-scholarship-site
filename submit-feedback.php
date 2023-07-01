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
        'helpful' => ($_POST['helpful'] == 'Yes') ? 'Yes' : 'No',
        'improvement' => isset($_POST['improvement']) ? sanitize_text_field($_POST['improvement']) : '',
        'other_improvement' => isset($_POST['other_improvement']) ? sanitize_text_field($_POST['other_improvement']) : '',
        'scholarship_info' => isset($_POST['scholarship_info']) ? $_POST['scholarship_info'] : [],
        'date' => isset($_POST['date']) ? $_POST['date'] : ''
    );

    $wpdb->insert(
        $table_name,
        array(
        'helpful' => $feedback_data['helpful'],
        'improvement' => $feedback_data['improvement'],
        'other_improvement' => $feedback_data['other_improvement'],
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
    helpful varchar(10) NOT NULL,
    improvement varchar(50) NOT NULL,
    other_improvement text NOT NULL,
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

