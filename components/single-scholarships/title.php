<?php

$institution_id = get_post_meta($post->ID, 'scholarship_institution', true);
if (!empty($institution_id)) {
    $institution_title = get_the_title($institution_id);
    $title_h1 =  get_the_title($post->ID) . ' at ' . $institution_title;
}

?>

<div class="avada-page-titlebar-wrapper customm" role="banner">
    <div class="fusion-page-title-bar fusion-page-title-bar-none fusion-page-title-bar-center">
        <div class="fusion-page-title-row">
            <div class="fusion-page-title-wrapper">
                <div class="fusion-page-title-captions">
                    <h1 class="gs-title-text"><?php echo $title_h1; ?></h1>
                    <div class="fusion-page-title-secondary">
                        <div class="fusion-breadcrumbs"><span class="fusion-breadcrumb-item"><a href="https://stg-globalscholarshipsa-sibi.kinsta.cloud" class="fusion-breadcrumb-link"><span>Home</span></a></span><span class="fusion-breadcrumb-sep">/</span><span class="fusion-breadcrumb-item"><span class="breadcrumb-leaf">Fellowship and Relocation Grant</span></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>