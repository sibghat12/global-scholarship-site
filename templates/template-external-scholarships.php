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
    <h1 style="padding-left:0px;margin-bottom:40px;">External Scholarships Deadlines</h1>

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
            $title = get_the_title();
            $title_link = get_the_permalink();
            $last_updated = get_the_modified_date('F j, Y');
            $last_author = get_the_modified_author();

            foreach ($deadlines as $deadline):
                $degree = $deadline['degree'] ?? 'Bachelors and Masters';
                $degree = empty($degree) || $degree === 'All Programs' ? 'Bachelors and Masters' : $degree;
                $label = $deadline['label'] ?? '';
                $opening_date = $deadline['open_date'] ?? 'N/A';
                $close_date = $deadline['deadline'] ?? 'N/A';
                $status = $today_date < strtotime($close_date) ? 'OPEN' : 'CLOSED';

// Decide the row color based on the status
$rowColor = $status == 'CLOSED' ? ' style="background-color: #d6f5fd;"' : '';

echo "<tr" . $rowColor . ">";
                echo "<td>$opening_date</td>";
                echo "<td>$close_date</td>";
                
                echo "<td><a href=\"$title_link\">$title</a></td>";
                echo "<td>$degree</td>";
                echo "<td>$label</td>";
                echo "<td>$status</td>";
                echo "<td>$last_updated</td>";
                echo "<td>$last_author</td>";
                echo "</tr>";
            endforeach;
        endforeach;

        echo '</tbody></table>';
    else:
        echo '<p>No external scholarships found.</p>';
    endif;

    wp_reset_postdata();
    ?>

</article>

<?php get_footer(); ?>