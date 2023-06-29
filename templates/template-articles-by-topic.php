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
            echo '<thead><tr><th>Title</th><th>URL</th></tr></thead>';
            echo '<tbody>';

            foreach ($tables_titles as $table_title) {
                $table_id = str_replace(' ', '-', strtolower($table_title));
                echo "<tr><td>$table_title</td><td><a href='#$table_id'>$table_title</a></td></tr>";
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
  <div class="accordion-item">
<?php


        foreach ($thePosts as $postCollectionTitle => $postIdCollection) {

            $table_class_title = str_replace(' ', '-', strtolower($postCollectionTitle));
            $table_id_title = str_replace(' ', '-', strtolower($postCollectionTitle));
            $table_accordion_identifier = str_replace(' ', '__',  strtolower($postCollectionTitle));
            $tables_ids[] = $table_id_title; 

            ?>
            <div class="accordion-item">
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
                    echo "</div>";
                    
                    ?>
                </div>
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
  </div>
</div>
    <?php



?>
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <div class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Accordion Item #1
      </button>
    </div>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Accordion Item #2
      </button>
    </div>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Accordion Item #3
      </button>
    </div>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>
<?php do_action( 'avada_after_content' ); ?>
</div><!-- .entry-content -->

    </div><!-- .post-content -->


</article><!-- #post-## -->
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
