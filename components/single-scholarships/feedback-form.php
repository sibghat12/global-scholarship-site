 <div class="gs-feeback-form-container">
   <form id="gs-feeback-form" action="" method="POST" class="gs-feeback-form">
    <h2>Was this page helpful? </h2>
     <div style="display:none;">
      <label for="gs_email">Email</label>
      <input type="email" name="gs_email" id="gs_email">
    </div>
    <p class="gs-feedback-intro">We have around 4,000 scholarships on our database, and while our team strives in making sure that these scholarships are up to date, we also need your help!</p>
    <p class="gs-feedback-form-question">Did you find this page helpful? If not, can you let us know why and how we can improve our page!</p>
    <div class="gs-feedback-initial-answers">
      <label class="gs-feedback-radio-label">
        <input type="radio" name="helpful" value="Yes">
        <span class="gs-feedback-radio-btn">Yes</span>
      </label>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="helpful" value="No">
        <span class="gs-feedback-radio-btn">No</span>
      </label>
    </div>
    <div class="step-2" style="display:none;">
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="incorrect_info">
        <span class="gs-feedback-radio-btn">The scholarship information is incorrect</span>
      </label>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="outdated_info">
        <span class="gs-feedback-radio-btn">The scholarship details are outdated</span>
      </label>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="not_for_international_students">
        <span class="gs-feedback-radio-btn">The scholarship is not for international students</span>
      </label>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="other">
        <span class="gs-feedback-radio-btn">Other</span>
      </label>
      <textarea name="other_improvement" rows="5"placeholder="Please specify" style="display:none;"></textarea>
      <input type="hidden" name="current_scholarship_info" data-scholarship-url="<?php echo get_permalink( get_the_ID() ); ?>" data-scholarship-id="<?php echo get_the_ID(); ?>" data-scholarship-title="<?php echo get_the_title(); ?>" data-scholarship-edit-page-url="<?php echo get_edit_post_link(get_the_ID()); ?>">
    </div>
    <div class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <!-- <div class="gs-spinner" style="display:none;"></div> -->
    <div class="gs-feedback-form-buttons" style="display:none;">
      <input type="submit" name="submit" value="Send">
    </div>
  </form>
</div>