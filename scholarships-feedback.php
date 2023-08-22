<?php



function display_scholarship_feedback_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_scholarships_feedback';

    // Check if a feedback ID has been submitted for deletion
    if (isset($_GET['delete_feedback'])) {
        $feedback_id = intval($_GET['delete_feedback']);
        $wpdb->delete($table_name, array('id' => $feedback_id));
    }

    // Check if delete multiple feedbacks action is triggered
    if (isset($_POST['delete_multiple_feedbacks'])) {
        $feedback_ids = $_POST['feedback_ids'];
        foreach ($feedback_ids as $feedback_id) {
            $wpdb->delete($table_name, array('id' => $feedback_id));
        }
    }

    $feedback_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC", ARRAY_A);
    ?>
    <div class="table-responsive">
        <form method="post">
            <table id="gs-feedback-table" class="gs-feedback-table table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-checkbox"></th>
                        <th>ID</th>
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
                        $improvement_type_info = '';

                        if( $feedback['improvement'] == 'incorrect_info' && !empty($feedback['incorrect_info_improvement'])) : 
                          $improvement_type_info .= "<td>".$feedback['incorrect_info_improvement']."</td>";
                        elseif($feedback['improvement'] == 'outdated_info' && !empty($feedback['outdated_info_improvement'])) :
                          $improvement_type_info .= "<td>".$feedback['outdated_info_improvement']."</td>";
                        elseif( $feedback['improvement'] == 'not_for_international' && !empty($feedback['not_for_international_improvement'])) :
                          $improvement_type_info .= "<td>".$feedback['not_for_international_improvement']."</td>";
                        elseif( $feedback['improvement'] == 'not_easy_to_read' && !empty($feedback['not_easy_to_read_improvement'])) : 
                          $improvement_type_info .= "<td>".$feedback['not_easy_to_read_improvement']."</td>";
                        elseif($feedback['improvement'] == 'details_missing' && !empty($feedback['details_missing_improvement'])) :
                          $improvement_type_info .= "<td>".$feedback['details_missing_improvement']."</td>";
                        elseif( $feedback['improvement'] == 'not_clear_procedures' && !empty($feedback['not_clear_procedures_improvement'])) :
                          $improvement_type_info .= "<td>".$feedback['not_clear_procedures_improvement']."</td>";
                        elseif( $feedback['improvement'] == 'suggestion' && !empty($feedback['suggestion_improvement'])) :
                          $improvement_type_info .= "<td>".$feedback['suggestion_improvement']."</td>";
                        else :
                          $improvement_type_info .= "<td></td>";
                        endif;
          

                        if ($feedback['improvement'] == 'incorrect_info') {
                            $feedback['improvement'] = 'The Information in This Scholarship is incorrect!';
                        } elseif ($feedback['improvement'] == 'not_for_international') {
                            $feedback['improvement'] = 'This Scholarship is not for international Students.';
                        } 
                        elseif ($feedback['improvement'] == 'outdated_info') {
                            $feedback['improvement'] = 'The Information in this Scholarships is outdated, please fix';
                        }
                        elseif ($feedback['improvement'] == 'not_easy_to_read') {
                            $feedback['improvement'] = 'Not easy to read';
                        }
                        elseif ($feedback['improvement'] == 'details_missing') {
                            $feedback['improvement'] = 'Some details are missing';
                        }
                        elseif ($feedback['improvement'] == 'not_clear_procedures') {
                            $feedback['improvement'] = 'Procdeures are not clear';
                        }
                        elseif ($feedback['improvement'] == 'suggestion') {
                            $feedback['improvement'] = 'Suggestion';
                        }
                        
                        ?>
                        <tr>
                            <td><input type="checkbox" name="feedback_ids[]" value="<?php echo $feedback['id']; ?>"></td>
                            <td><?php echo $feedback['id']; ?></td>
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
            <div>
                <div>
                    <button type="submit" name="delete_multiple_feedbacks" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete these feedbacks?')">Delete Selected</button>
                </div>
            </div>
        </form>
    </div>
    <?php
}

?>
<div class="wrap">

    <h1>Scholarships Feedback</h1>

    <?php display_scholarship_feedback_table(); ?>
    
</div>
