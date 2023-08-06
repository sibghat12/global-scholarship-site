<?php

function display_scholarship_feedback_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';

    // Check if a feedback ID has been submitted for deletion
    if (isset($_GET['delete_feedback'])) {
        $feedback_id = intval($_GET['delete_feedback']);
        $wpdb->delete($table_name, array( 'id' => $feedback_id ));
    }
    $feedback_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC", ARRAY_A);

    ?>
    <div class="table-responsive">
      <table id="gs-feedback-table" class="gs-feedback-table table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Helpful</th>
            <th>Improvement</th>
            <th>User Comment</th>
            <th>Scholarship URL</th>
            <th>Scholarship Title</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($feedback_data as $feedback) {
            
              if($feedback['improvement'] == 'other' && $feedback['other_improvement'] != '') {
                $feedback['other_improvement'] = $feedback['other_improvement'];
              }elseif($feedback['improvement'] == 'incorrect_info' && $feedback['incorrect_info_improvement'] != '') {
                $feedback['incorrect_info_improvement'] = $feedback['incorrect_info_improvement'];
              }elseif($feedback['improvement'] == 'outdated_info' && $feedback['outdated_info_improvement'] != '') {
                $feedback['outdated_info_improvement'] = $feedback['outdated_info_improvement'];
              } elseif($feedback['improvement'] == 'not_for_international_students' && $feedback['not_for_international_improvement'] != '') {
                $feedback['not_for_international_improvement'] = $feedback['not_for_international_improvement'];
              }

              $improvement_type_info = '';

              if( $feedback['improvement'] == 'other' && !empty($feedback['other_improvement'])) :
                $improvement_type_info .= "<td>".$feedback['other_improvement']."</td>";
              elseif( $feedback['improvement'] == 'incorrect_info' && !empty($feedback['incorrect_info_improvement'])) : 
                $improvement_type_info .= "<td>".$feedback['incorrect_info_improvement']."</td>";
              elseif($feedback['improvement'] == 'outdated_info' && !empty($feedback['outdated_info_improvement'])) :
                $improvement_type_info .= "<td>".$feedback['outdated_info_improvement']."</td>";
              elseif( $feedback['improvement'] == 'not_for_international_students' && !empty($feedback['not_for_international_improvement'])) :
                $improvement_type_info .= "<td>".$feedback['not_for_international_improvement']."</td>";
              else :
                $improvement_type_info .= "<td></td>";
              endif;

              if($feedback['improvement'] == 'incorrect_info') {
                $feedback['improvement'] = 'The Information in This Scholarship are incorrect!';
            } elseif($feedback['improvement'] == 'not_for_international_students') {
                $feedback['improvement'] = 'This Scholarship is not for international Students.';
            } elseif($feedback['improvement'] == 'outdated_info') {
                $feedback['improvement'] = 'The Information in this Scholarships are outdated, please fix';
            } elseif($feedback['improvement'] == 'other') {
                $feedback['improvement'] = 'None of the above here is my comment';
            }

              ?>
            <tr>
              <td><?php echo $feedback['id']; ?></td>
              <td><?php echo $feedback['helpful']; ?></td>
              <td><?php echo $feedback['improvement']; ?></td>
              <?php echo $improvement_type_info; ?>
              <td><?php echo $feedback['scholarship_url']; ?></td>
              <td><?php echo $feedback['scholarship_title']; ?></td>
              <td><?php echo $feedback['date']; ?></td>
              <td>
              <a href="<?php echo add_query_arg('delete_feedback', $feedback['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</a>
                </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php
}

?>
<div class="wrap">

    <h1>Scholarships Feedback</h1>

    <?php display_scholarship_feedback_table(); ?>
    
</div>
