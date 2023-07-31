<?php if(!empty($why_us_boxes)) : ?>
    <div class="why-us-boxes-container">
        <?php foreach($why_us_boxes as $index => $why_box) : 
            $element_no =  $index + 1;
            $box_data = $why_box['why_us_answer_box'];
            $sub_string_class = strtolower($box_data['why_us_answer_heading']);
            ?>
        <div class="why-us-box why-us-box-<?php echo $sub_string_class;?>" data-box="<?php echo $element_no; ?>">
            <div class="why-us-box-shape-svg-<?php echo $element_no; ?>">
                <?php echo $box_data['why_us_svg']; ?>
            </div>
            <h3 class="gs-why-us-box-title">
                <?php echo $box_data['why_us_answer_heading']; ?>
            </h3>
            <p class="gs-why-us-box-text">
                <?php echo $box_data['why_us_answer_text']; ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
   