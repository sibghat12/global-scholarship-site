<?php // Coverage Section ?>
<section id="ext-scholarship-coverage" class="gs-ext-scholarship-coverage">
    <h2><?php echo  $scholarship_title; ?> Coverage</h2>
    <?php
        if(count($coverage) == 1 ) : ?>
            <p>This <?php echo $scholarship_category; ?> scholarship for international students covers</p>
            
        <?php elseif(count($coverage) > 1 ) : ?>
            <p>This <?php echo get_adjective_scholarship_amount($scholarship_type); ?> scholarship for international students covers the following:</p>
            <ul class="fa-ul">
            <?php foreach($coverage as $coverage_item) : ?>
                <li><span class="fa-li"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span><div class="coverage-item"><?php echo $coverage_item['coverage'] ?></div></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>

</section>