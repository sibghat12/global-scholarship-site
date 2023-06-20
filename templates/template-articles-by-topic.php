<?php
/**
 * Template Name: Articles by Topic
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); 
?>

<article id="template-articles-by-topic" class="articles-by-topic-page">


	<div class="post-content">

		<header class="entry-header">
        

        </header><!-- .entry-header -->

        <div class="entry-content clearfix">
            <h1><?php the_title(); ?></h1>

<?php
    global $wpdb;

    $tables_titles = array();

    $tables_urls = array();

    $articlesByTopic = array();
    
    $thePosts = array();

    $ArticleTopics = get_field('article_topics');



    foreach($ArticleTopics as $ArticleTopic) {

        foreach($ArticleTopic as $ArticleTopicItem) {
            $articlesByTopic[$ArticleTopicItem['topic_title']] = $ArticleTopicItem['topic_urls'];

            array_push($tables_titles, $ArticleTopicItem['topic_title']);
            array_push($tables_urls, $ArticleTopicItem['topic_urls']);
        }
    }

        // Output a table that references the generated tables
        if (!empty($tables_titles)) {


            echo '<table class="gs-articles-topics-reference">';
            echo '<thead><tr><th>Title</th><th>URL</th></tr></thead>';
            echo '<tbody>';

            foreach ($tables_titles as $table_title) {
                $table_id = str_replace(' ', '-', strtolower($table_title));
                echo "<tr><td>$table_title</td><td><a href='#$table_id'>$table_title</a></td></tr>";
            }

            echo '</tbody></table>';
        }
    

    foreach($articlesByTopic as $articleTopicTitle => $articleByTopicURL) {

        // Select ID, post_title, date form WordPress database wpdb
        $query = "SELECT ID, post_title, post_date, post_name FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_name LIKE '%". $articleByTopicURL."%' ORDER BY post_date DESC";

        $myposts = $wpdb->get_results($query);
        $thePosts[$articleTopicTitle] = $myposts;

    }

    // Get Posts Title and Date Published and URL in Table Format
    // Retrieve post IDs using $wpdb or WP_Query here

    if (!empty($thePosts)) {



        foreach ($thePosts as $postCollectionTitle => $postIdCollection) {

            $table_class_title = str_replace(' ', '-', strtolower($postCollectionTitle));
            $table_id_title = str_replace(' ', '-', strtolower($postCollectionTitle));

            $tables_ids[] = $table_id_title; 


            echo "<div id='$table_id_title' class='gs-table-article-topic table-$table_class_title'>";
            echo '<table class="data-table">';
            echo '<thead><tr><th class="th-title">'. $postCollectionTitle .'</th><th>URL</th><th class="th-date">Date Published</th></tr></thead>';
            echo '<tbody>';
            
            foreach($postIdCollection as $postId) {
                $post = get_post($postId);
                $postTitle = $post->post_title;
                $postDate = $post->post_date;
                // Convert the post date to the desired format using date_i18n
                $formatted_date = date_i18n('F j, Y', strtotime($postDate));

                $postUrl = get_permalink($postId);

                echo '<tr><td>' . $postTitle . '</td><td><a href="'.$postUrl.'">' . $postUrl . '</a></td><td>' . $formatted_date . '</td></tr>';
            }

            echo '</tbody></table>';
            echo "</div>";
        }

    }

    // Get all post names are not in $tables_urls
        $query = "SELECT ID, post_title, post_date, post_name FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND NOT (";

        foreach ($tables_urls as $url) {
            $query .= "post_name LIKE '%" . $url . "%' OR ";
        }

        $query .= "0) ORDER BY post_date DESC";

        $myOtherPosts = $wpdb->get_results($query);

        $otherPosts = array('other-posts' => $myOtherPosts);


    // Output a table that output all other posts that are not in $tables_urls

    if (!empty($otherPosts)) {

        echo "<div id='other-posts' class='gs-table-article-topic table-other-posts'>";
        echo '<table class="data-table">';
        echo '<thead><tr><th class="th-title">Posts that Didn’t appear in any of the results</th><th>URL</th></tr></thead>';
        echo '<tbody>';
        
        foreach($otherPosts as $otherPost) {
            foreach($otherPost as $post) {
                $postTitle = $post->post_title;
                $postDate = $post->post_date;
                $postUrl = get_permalink($post->ID);

                echo '<tr><td>' . $postTitle . '</td><td><a href="'.$postUrl.'">' . $postUrl . '</a></td></tr>';
            }
        }

        echo '</tbody></table>';
        echo "</div>";
    }



        

    

?>

<?php do_action( 'avada_after_content' ); ?>
</div><!-- .entry-content -->

    </div><!-- .post-content -->


</article><!-- #post-## -->
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
