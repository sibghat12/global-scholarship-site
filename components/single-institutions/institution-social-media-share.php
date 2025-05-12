<div class="gs-institution-social-media-share">
    <div class="social-share-buttons">
        <b>Share this article via</b>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" alt="Share on Facebook" title="Share on Facebook" />
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/twitter.png" alt="Share on Twitter" title="Share on Twitter" />
        </a>

        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&source=<?php echo site_url(); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/linkedin.png" alt="Share on LinkedIn" title="Share on LinkedIn" />
        </a>
        <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>&description=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/pinterest.png" alt="Pin on Pinterest" title="Pin on Pinterest" />
        </a>
        <a href="mailto:?subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mail.png" alt="Share via Email" title="Share via Email" />
        </a>
    </div>
</div>