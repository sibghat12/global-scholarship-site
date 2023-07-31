<section class="gs-partner-pricing-section content-section-container">
    <div class="gs-partner-pricing-title-container">
        <h1 class="gs-partner-pricing-title-text">Our Pricing <span class="gs-partner-pricing-title-background">Models</span></h1>
    </div>
    <div class="gs-partner-pricing-box-container">
        <div class="gs-partner-pricing-model-one-container">
            <div class="gs-partner-pricing-model-one-title gs-partner-pricing-title">
                <h2>Model 1</h2>
            </div>
            <div class="gs-partner-pricing-model-one-description gs-partner-pricing-description">
                <h2><?php echo $pricing_model_1_title; ?></h2>
            </div>
            <?php if(!empty($pricing_model_1_features)) : ?>
            <div class="gs-partner-pricing-model-one-list gs-partner-pricing-list">
                <ul class="fa-ul">
                    <?php foreach($pricing_model_1_features as $index => $feature ) : ?>
                    <li><span class="fa-li">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.1" d="M12.1866 0.849609C5.53597 0.849609 0.144531 6.18687 0.144531 12.7707C0.144531 19.3545 5.53597 24.6918 12.1866 24.6918C18.8373 24.6918 24.2287 19.3545 24.2287 12.7707C24.221 6.19004 18.8341 0.857273 12.1866 0.849609Z" fill="#008FC6"></path>
                        <path d="M19.1441 8.99569L12.2751 18.2236C12.1112 18.4388 11.867 18.5798 11.5971 18.6149C11.3273 18.65 11.0545 18.5763 10.84 18.4104L5.93489 14.5281C5.50204 14.1852 5.43195 13.5598 5.77834 13.1313C6.12473 12.7028 6.75643 12.6334 7.18928 12.9763L11.2796 16.2159L17.5284 7.82047C17.7333 7.51607 18.0906 7.34778 18.4585 7.3824C18.8263 7.41703 19.1452 7.64897 19.2885 7.98614C19.4318 8.32331 19.3763 8.71116 19.1441 8.99569Z" fill="#008FC6"></path>
                    </svg></span><?php echo $feature['feature']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div class="gs-partner-pricing-model-two-container">
            <div class="gs-partner-pricing-model-two-title gs-partner-pricing-title">
                <h2>Model 2</h2>
            </div>
            <div class="gs-partner-pricing-model-two-description gs-partner-pricing-description">
                <h2>Annual Course<br> Listing</h2>
            </div>
            <?php if(!empty($pricing_model_2_features)) : ?>
            <div class="gs-partner-pricing-model-two-list gs-partner-pricing-list">
                <ul class="fa-ul">
                    <?php foreach($pricing_model_2_features as $index => $feature ) : ?>
                        <li><span class="fa-li">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.1" d="M12.1866 0.849609C5.53597 0.849609 0.144531 6.18687 0.144531 12.7707C0.144531 19.3545 5.53597 24.6918 12.1866 24.6918C18.8373 24.6918 24.2287 19.3545 24.2287 12.7707C24.221 6.19004 18.8341 0.857273 12.1866 0.849609Z" fill="#008FC6"></path>
                            <path d="M19.1441 8.99569L12.2751 18.2236C12.1112 18.4388 11.867 18.5798 11.5971 18.6149C11.3273 18.65 11.0545 18.5763 10.84 18.4104L5.93489 14.5281C5.50204 14.1852 5.43195 13.5598 5.77834 13.1313C6.12473 12.7028 6.75643 12.6334 7.18928 12.9763L11.2796 16.2159L17.5284 7.82047C17.7333 7.51607 18.0906 7.34778 18.4585 7.3824C18.8263 7.41703 19.1452 7.64897 19.2885 7.98614C19.4318 8.32331 19.3763 8.71116 19.1441 8.99569Z" fill="#008FC6"></path>
                        </svg></span><?php echo $feature['feature']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>