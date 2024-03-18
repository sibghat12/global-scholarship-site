<?php
/**
 * Template Name: External Scholarships Deadlines
 *
 * @package Avada
 * @subpackage Templates
 */

if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

$today_date = strtotime(date("F j, Y"));

get_header();
?>

<article id="template-external-scholarships" class="external-scholarships">
    <h1 style="padding-left: 0px;margin-bottom: 40px;">External Scholarships Deadlines</h1>

    <?php
    $external_scholarships = get_posts([
        'post_type' => 'ext-scholarships', // Replace with your actual custom post type
        'posts_per_page' => -1,
        'post_status' => 'publish', // Adjust based on needed post statuses
    ]);

    if (!empty($external_scholarships)):
        echo '<table class="table table-bordered data-table" style="width:100%">';
        echo '<thead>
            <tr>
                <th>Opening Date</th>
                <th>Deadline</th>
                
                <th>University/Scholarship Name</th>
                <th>Degree</th>
                <th>Label</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Updated by</th>
            </tr>
        </thead>';
        echo '<tbody>';

        foreach ($external_scholarships as $post):
            setup_postdata($post);
            $deadlines = get_field('scholarship_deadlines'); // Ensure this matches your ACF field name
            // Variables assumed to be set elsewhere: $today_date, $title_link, $last_updated, $last_author
$today_date = strtotime(date('Y-m-d'));
$title_link = get_permalink();
$title = get_the_title();
$last_updated = get_the_modified_date('Y-m-d');
$last_author = get_the_modified_author();

if (!empty($deadlines)) {
    // Filter out past deadlines and sort the remaining ones by their open date
    $futureDeadlines = array_filter($deadlines, function ($deadline) use ($today_date) {
        return strtotime($deadline['deadline']) >= $today_date;
    });

    usort($futureDeadlines, function ($a, $b) {
        return strtotime($a['open_date']) <=> strtotime($b['open_date']);
    });

    // Select the most relevant deadline
    $relevantDeadline = null;
    foreach ($futureDeadlines as $deadline) {
        if (!empty($deadline['degree'])) {
            $relevantDeadline = $deadline;
            break; // Prefer deadlines with specified degrees
        }
        if (empty($relevantDeadline)) { // Assign if no deadline has been chosen yet
            $relevantDeadline = $deadline;
        }
    }

    // Display the most relevant deadline if one is found
    if ($relevantDeadline) {
        $degree = !empty($relevantDeadline['degree']) ? $relevantDeadline['degree'] : "Bachelor's and Master's";
        $label = $relevantDeadline['label'] ?? '';
        $opening_date = $relevantDeadline['open_date'] ?? 'N/A';
        $close_date = $relevantDeadline['deadline'] ?? 'N/A';
        $status = $today_date < strtotime($close_date) ? 'OPEN' : 'CLOSED';

        echo "<tr>";
        echo "<td>$opening_date</td>";
        echo "<td>$close_date</td>";
        echo "<td><a href=\"$title_link\">$title</a></td>";
        echo "<td>$degree</td>";
        echo "<td>$label</td>";
        echo "<td>$status</td>";
        echo "<td>$last_updated</td>";
        echo "<td>$last_author</td>";
        echo "</tr>";
       }
    }

        endforeach;

        echo '</tbody></table>';
    else:
        echo '<p>No external scholarships found.</p>';
    endif;

    wp_reset_postdata();
    ?>

</article>

<?php get_footer(); ?>
