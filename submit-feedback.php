<?php
function submit_feedback() {
    global $wpdb;
  
    $table_name = $wpdb->prefix . 'feedback';
  
    $helpful = $_POST['helpful'];
    $improvement = $_POST['improvement'];
    $other_improvement = $_POST['other_improvement'];
    $scholarship_url = $_POST['scholarship_info']['url'];
    $scholarship_id = $_POST['scholarship_info']['id'];
    $scholarship_title = $_POST['scholarship_info']['title'];
    $date = current_time('mysql');
  
    $wpdb->insert(
      $table_name,
      array(
        'helpful' => $helpful,
        'improvement' => $improvement,
        'other_improvement' => $other_improvement,
        'scholarship_url' => $scholarship_url,
        'scholarship_id' => $scholarship_id,
        'scholarship_title' => $scholarship_title,
        'date' => $date,
      )
    );
  
    echo 'Feedback submitted successfully.';
    die();
  }
add_action('wp_ajax_submit_feedback', 'submit_feedback');
add_action('wp_ajax_nopriv_submit_feedback', 'submit_feedback');

