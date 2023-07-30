<section class="gs-partner-our-partners-section content-section-container">
    <div class="gs-partner-our-partners-content-container">
        <h2 class="gs-partner-our-partners-heading">
            <?php echo $our_partners_heading; ?>
        </h2>
        <p class="gs-partner-our-partners-text">
            <?php echo $our_partner_description; ?>
        </p>
    </div>
    <?php if(!empty($our_partners_images)) : ?>
    <div class="gs-partner-our-partners-logos-container">
        <?php foreach($our_partners_images as $index => $image ) : ?>
            <div class="gs-partner-our-partners-logo">
                <?php echo wp_get_attachment_image($image['image'], 'full'); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>