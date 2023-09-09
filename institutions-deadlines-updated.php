<?php



function display_institutions_deadlines_updated_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'gs_deadlines_data';

    // Check if a feedback ID has been submitted for deletion
    if (isset($_GET['delete_deadline_data'])) {
        $deadline_date_id = intval($_GET['delete_deadline_data']);
        $wpdb->delete($table_name, array('id' => $deadline_date_id));
    }

    // Check if delete multiple feedbacks action is triggered
    if (isset($_POST['delete_multiple_deadlines_data'])) {
        $deadlines_data_ids = $_POST['deadlines_data_ids'];
        foreach ($deadlines_data_ids as $deadline_date_id) {
            $wpdb->delete($table_name, array('id' => $deadline_date_id));
        }
    }

    $deadlines_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC", ARRAY_A);
    ?>
    <div class="table-responsive">
        <form method="post">
            <table id="gs-feedback-table" class="gs-feedback-table table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-checkbox"></th>
                        <th>ID</th>
                        <th>Degree</th>
                        <th>Country</th>
                        <th>Opening Date (Past)</th>
                        <th>Deadline Date (Past)</th>
                        <th>Opening Date (NEW)</th>
                        <th>Deadline Date (NEW)</th>
                        <th>Date of The Process</th>
                        <th>Date Processed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deadlines_data as $deadline_data) { ?>

                        <tr>
                            <td><input type="checkbox" name="deadlines_data_ids[]" value="<?php echo $deadline_data['id']; ?>"></td>
                            <td><?php echo $deadline_data['id']; ?></td>
                            <td><?php echo $deadline_data['deadlinesUpdatedDegree']; ?></td>
                            <td><?php echo $deadline_data['deadlinesUpdatedCountry']; ?></td>
                            <td><?php echo $deadline_data['openingDateUpdate']; ?></td>
                            <td><?php echo $deadline_data['deadlineDateUpdate']; ?></td>
                            <td><?php echo $deadline_data['openingDateUpdated']; ?></td>
                            <td><?php echo $deadline_data['deadlineDateUpdated']; ?></td>
                            <td><?php echo $deadline_data['updateDeadlinesDate']; ?></td>
                            <td><?php echo $deadline_data['date']; ?></td>
                            <td>
                                <a href="<?php echo add_query_arg('delete_deadline_data', $deadline_data['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Deadline Data?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <div>
                    <button type="submit" name="delete_multiple_deadlines_data" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete these Deadlines Data?')">Delete Selected Deadlines Data</button>
                </div>
            </div>
        </form>
    </div>
    <?php
}

?>
<div class="wrap">

    <h1>Institutions Deadlines Updated</h1>

    <?php display_institutions_deadlines_updated_table(); ?>
    
</div>
