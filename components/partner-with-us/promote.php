<section class="gs-partner-promote-section content-section-container">
    <div class="gs-partner-what-promote-container">
        <h2 class="gs-partner-what-promote-title">
            <?php echo $promote_section['promote_title']; ?>
        </h2>
        <div class="gs-partner-what-promote-text">
            <?php echo $promote_section['promote_description']; ?>
        </div>
    </div>
    <?php if(!empty($promote_box)) : ?>
        <div class="gs-partner-what-promote-boxes-conatiner">
        <?php foreach($promote_box as $index => $promote) : 
            $box_element_no =  $index + 1;
        ?>
            <div class="gs-partner-what-promote-box-program gs-promote-box" data-promote-box="<?php echo $box_element_no; ?>">
                <div class="gs-promote-box-content">
                    <div class="gs-promote-svg-<?php echo $box_element_no; ?>">
                        <?php echo $promote['promote_box_svg']; ?>
                    </div>
                    <h3 class="gs-promote-box-title"><?php echo $promote['promote_box_title']; ?></h3>
                    <p class="gs-promote-box-text"><?php echo $promote['promote_box_description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>