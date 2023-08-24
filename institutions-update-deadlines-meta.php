<h1>Update institutions Deadlines Meta</h1>
<?php 

$gs_countries = get_gs_countries();
$gs_degrees = array(
    "Bachelor's",
    "Master's"
);

?>
<div class="gs-update-institutions-deadlines-meta">
    <div class="gs-update-institutions-conditions-fields">
        <div class="institution-opening-date-container">
            <label for="institution-opening-date">
                <span>Opening Date</span>
                <input type="date" name="institution-opening-date" id="institution-opening-date">
            </label>
        </div>
        <div class="institution-deadline-date-container">
            <label for="institution-deadline-date">
                <span>Deadline Date</span>
                <input type="date" name="institution-deadline-date" id="institution-deadline-date">
            </label>
        </div>
        <div class="institution-country-container">
            <label for="institution-country">Institution Country</label>
            <select name="institution-country" id="institution-country" class="institution-country institutions-country-select">
                <option value="">Select Country</option>
                <?php
                if(isset($gs_countries) && !empty($gs_countries)) :
                    foreach($gs_countries as $index => $country) :
                        $country_value = strtolower(str_replace(" ", "-", $country));
                        ?>
                        <option value="<?php echo $country_value; ?>"><?php echo $country; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="institution-degree-container">
            <label for="institution-degree">Institution Degree</label>
            <select name="institution-degree" id="institution-degree" class="institution-degree institutions-degree-select">
                <option value="">Select Degree</option>
                <?php
                if(isset($gs_degrees) && !empty($gs_degrees)) :
                    foreach($gs_degrees as $index => $degree) :
                        $degree_value = strtolower(str_replace(" ", "-", $degree));
                        ?>
                        <option value="<?php echo $degree_value; ?>"><?php echo $degree; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
    </div>
    <div class="gs-update-instructions-fields-update">
        <h2>Update Dates</h2>
        <div class="institution-opening-updated-date-container">
            <label for="institution-updated-opening-date">
                <span>Updated Opening Date</span>
                <input type="date" name="institution-updated-opening-date" id="institution-updated-opening-date">
            </label>
        </div>
        <div class="institution-updated-deadline-date-container">
            <label for="institution-updated-deadline-date">
                <span>Updated Deadline Date</span>
                <input type="date" name="institution-updated-deadline-date" id="institution-updated-deadline-date">
            </label>
        </div>
    </div>
    <?php submit_button( __( 'Update Deadlines', 'gs' ), 'secondary', 'gs_update_deadlines', true, 'data-deadlines="update_deadlines"' ); ?>
</div>