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

    // $params = get_query_info();

    // $subject = $params["subject"];
    // //$location = $params["location"];
    // $degrees = $params["degrees"];
    // $country = $params["country"];


    // echo '<pre>';
    // print_r($params);
    // echo '</pre>';
    // $args = array(
    //     'post_type' => 'post',
    //     'posts_per_page' => -1,
    //     's' => 'best-countries-', // search for "best-countries-"
    //     'fields' => 'ids'
    // );
    
    // $posts = get_posts($args);
    
    // echo '<pre>';
    // print_r($posts);
    // echo '</pre>';
    
    // foreach ($posts as $post) {
    //     // Do something with each post, such as display its title or content.
    // }

    // $args = array(
    //     'post_type' => 'post',
    //     'posts_per_page' => -1,
    //     'meta_query' => array(
    //         array(
    //             'key' => 'title',
    //             'value' => 'best',
    //             'compare' => 'EXISTS'
    //         )
    //     ),
    //     'fields' => 'ids'
    // );
    
    // $query = new WP_Query($args);
    
    // echo '<pre>';
    // print_r($query->get_posts());
    // echo '</pre>';

    // global $wpdb;
    // $myposts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title LIKE '%s'", '%'. $wpdb->esc_like( 'Best ' ) .'%') );

    // $myposts = wp_list_pluck( $myposts, 'ID');

    // echo '<pre>';
    // print_r($myposts);
    // echo '</pre>';
    global $wpdb;

    $ArticleTopics = get_field('article_topics');

    // echo '<pre>';
    // print_r($ArticleTopics);
    // echo '</pre>';

    $articlesByTopic = array();

    foreach($ArticleTopics as $ArticleTopic) {
        // echo '<pre>';
        // print_r($ArticleTopic);
        // echo '</pre>';

        foreach($ArticleTopic as $ArticleTopicItem) {
            // echo '<pre>';
            // print_r($ArticleTopicItem['topic_urls']);
            // echo '</pre>';

            $articlesByTopic[] = $ArticleTopicItem['topic_urls'];
            
            
        }



    }
    
    // echo '<pre>';
    // print_r($articlesByTopic);
    // echo '</pre>';

    $thePosts = array();

    foreach($articlesByTopic as $articleByTopic) {
        $query = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_name LIKE '%". $articleByTopic."%' ORDER BY post_date DESC";
        $results = $wpdb->get_results($query);
        $myposts = wp_list_pluck( $results, 'ID');

        $thePosts[] = $myposts;

    }
    
    // echo '<pre>';
    // print_r($thePosts);
    // echo '</pre>';

    // Get Posts Title and Date Published and URL in Table Format
    // Retrieve post IDs using $wpdb or WP_Query here

if (!empty($thePosts)) {
    
    foreach ($thePosts as $postIdCollection) {
        echo '<table class="data-table">';
        echo '<thead><tr><th class="th-title">Title</th><th class="th-date">Date Published</th><th>URL</th></tr></thead>';
        echo '<tbody>';
        
        foreach($postIdCollection as $postId) {
            $post = get_post($postId);
            $postTitle = $post->post_title;
            $postDate = $post->post_date;
            $postUrl = get_permalink($postId);

            echo '<tr><td>' . $postTitle . '</td><td>' . $postDate . '</td><td>' . $postUrl . '</td></tr>';
        }
        
        // $post = get_post($postId);
        // $postTitle = $post->post_title;
        // $postDate = $post->post_date;
        // $postUrl = get_permalink($postId);

        // echo '<tr><td>' . $postTitle . '</td><td>' . $postDate . '</td><td>' . $postUrl . '</td></tr>';
        echo '</tbody></table>';
    }

}

    
    // $query = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_name LIKE '%". $ArticleTopicItem['topic_urls']."%'";
    // $results = $wpdb->get_results($query);
    // $myposts = wp_list_pluck( $results, 'ID');

    // $query = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND post_name LIKE '%best-engineering-%'";
    // $results = $wpdb->get_results($query);
    // $myposts = wp_list_pluck( $results, 'ID');
    
    // echo '<pre>';
    // print_r($myposts);
    // echo '</pre>';
    
    
    // if ($query->have_posts()) {
    //     $post_ids = $query->posts;
    //     // Do something with the post IDs, such as store them in an array or print them.
    // }
    
    // wp_reset_postdata();
    // $query = new WP_Query($args);
    
    // echo '<pre>';
    // print_r($query->get_posts());
    // echo '</pre>';
    
    // if ($query->have_posts()) {
    //     $post_ids = $query->posts;
    //     // Do something with the post IDs, such as store them in an array or print them.
    // }
    
    // wp_reset_postdata();
    

?>

<h1>HELLO</h1>
<?php do_action( 'avada_after_content' ); ?>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
