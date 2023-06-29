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
    

    $category_slugs = array();

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
            echo '<thead><tr><th>Topic</th><th>List of Articles</th></tr></thead>';
            echo '<tbody>';

            foreach ($tables_titles as $table_title) {
                $table_id = str_replace(' ', '-', strtolower($table_title));
                ?>
                <tr><td><?php echo $table_title; ?></td><td><a href="#<?php echo $table_id; ?>"><?php echo $table_title ?></a></td></tr>
            <?php
            }
            echo "<tr><td>Posts that Didn’t appear in any of the results</td><td><a href='#other-posts'>Posts that Didn’t appear in any of the results</a></td></tr>";
            
            echo '</tbody></table>';
        }
    

        foreach ($articlesByTopic as $articleTopicTitle => $articleByTopicURL) {
            // Extract category slug from URL (if present)
            $url_path_parts = explode('/', $articleByTopicURL);

            $category_slug = '';
            if (count($url_path_parts) >= 2 && $url_path_parts[0] == 'category') {
                $category_slug = $url_path_parts[1];
                
                if(!empty($category_slug)) {
                    $category_slugs[] = $category_slug;
                }
                $category_slugs = array_unique (array_merge ($category_slugs));
            }


            // Select ID, post_title, date from WordPress database wpdb
            $query = "SELECT ID, post_title, post_date, post_name FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND (";
            if ($category_slug) {
                $query .= "ID IN (SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND term_id IN (SELECT term_id FROM $wpdb->terms WHERE slug = '$category_slug'))) OR ";
            }
            $query .= "post_name LIKE '%" . $articleByTopicURL . "%') ORDER BY post_date DESC";
        
            $myposts = $wpdb->get_results($query);
            $thePosts[$articleTopicTitle] = $myposts;
        }

    // Get Posts Title and Date Published and URL in Table Format
    // Retrieve post IDs using $wpdb or WP_Query here

    if (!empty($thePosts)) {
    ?>
    <div class="accordion" id="gs-articles-by-topic">
    <?php


        foreach ($thePosts as $postCollectionTitle => $postIdCollection) {

            $table_class_title = str_replace(' ', '-', strtolower($postCollectionTitle));
            $table_id_title = str_replace(' ', '-', strtolower($postCollectionTitle));
            $table_accordion_identifier = str_replace(' ', '__',  strtolower($postCollectionTitle));

            // Check if the variable has a comma or a single quote
            if (strpos($table_accordion_identifier, ",") !== false || strpos($table_accordion_identifier, "'") !== false) {
                // Remove the comma and single quote
                $table_accordion_identifier = str_replace(array(",", "'"), "", $table_accordion_identifier);
            }

            
            $tables_ids[] = $table_id_title; 

            ?>
            <div id="<?php echo $table_id_title ?>" class="accordion-item">
                <div class="accordion-header" id="<?php echo $table_id_title; ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo  $table_accordion_identifier; ?>" aria-expanded="true" aria-controls="<?php echo  $table_accordion_identifier; ?>">
                    <?php echo $postCollectionTitle; ?>
                </button>
                </div>
                <div id="<?php echo  $table_accordion_identifier; ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo $table_id_title; ?>" data-bs-parent="#gs-articles-by-topic">
                <div class="accordion-body">
                    <!-- Table HERE -->
                    <?php 
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
                    echo "</div></div>";
                    
                    ?>
                </div>
            </div>
            <?php
            
        }

    }

        // Get all posts that are not in $tables_urls or don't belong to any of the specified categories
        $query = "SELECT ID, post_title, post_date, post_name FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND (";
        foreach ($tables_urls as $url) {
            $query .= "post_name NOT LIKE '%" . $url . "%' AND ";
        }
        if (!empty($category_slugs)) {
            if(count($category_slugs) >= 1) {
                $query .= "ID NOT IN (SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND term_id IN (SELECT term_id FROM $wpdb->terms WHERE slug IN ('" . implode("', '", $category_slugs) . "')))) AND ";
            }
        }
        $query .= "1) ORDER BY post_date DESC";

        $myOtherPosts = $wpdb->get_results($query);
        $otherPosts = array('other-posts' => $myOtherPosts);
    // Output a table that output all other posts that are not in $tables_urls

    if (!empty($otherPosts)) {

        ?>
        <div id="other-posts" class="accordion-item">
            <div class="accordion-header" id="other_articles">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#other_posts_target" aria-expanded="true" aria-controls="other_posts_target">
                Posts that Didn’t appear in any of the results
            </button>
            </div>
            <div id="other_posts_target" class="accordion-collapse collapse" aria-labelledby="other_articles" data-bs-parent="#gs-articles-by-topic">
            <div class="accordion-body">
                <!-- Table HERE -->

        <?php

        echo "<div id='gs-other-posts' class='gs-table-article-topic table-other-posts'>";
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
            </div>
            </div>
        </div>

  </div>
</div>
    <?php



?>
<?php do_action( 'avada_after_content' ); ?>
</div><!-- .entry-content -->

    </div><!-- .post-content -->


</article><!-- #post-## -->
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
