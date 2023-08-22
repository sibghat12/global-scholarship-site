 <div class="gs-feedback-form-container">
   <form id="gs-feedback-form" action="" method="POST" class="gs-feedback-form">
    <h2>Help Us Improve Our Page!</h2>
     <div style="display:none;">
      <label for="gs_email">Email</label>
      <input type="email" name="gs_email" id="gs_email">
    </div>
    <p class="gs-feedback-intro">We have around 4,000 scholarships on our database, and while our team strives in making sure that these scholarships are up to date, we also need your help!</p>
    <p class="gs-feedback-form-question">We appreciate your feedback! We'd love to hear your thoughts on the following areas:</p>
    <div class="gs-feedback-initial-answers">
      <label class="gs-feedback-radio-question">
        <input type="radio" name="helpful" value="scholarship-information">
        <span class="gs-feedback-radio-btn">Scholarship Information</span>
      </label>
      <label class="gs-feedback-radio-question">
        <input type="radio" name="helpful" value="page-content">
        <span class="gs-feedback-radio-btn">Page Content</span>
      </label>
      <label class="gs-feedback-radio-question">
        <input type="radio" name="helpful" value="suggestions">
        <span class="gs-feedback-radio-btn">Suggestions</span>
      </label>
    </div>
    <div class="step-2" data-feedback-type="scholarship-information">
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="incorrect_info">
        <span class="gs-feedback-radio-btn">The scholarship information is incorrect</span>
      </label>
      <textarea class="gs-user-comment" name="incorrect_info_improvement" rows="5" placeholder="What information is incorrect?" ></textarea>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="outdated_info">
        <span class="gs-feedback-radio-btn">The scholarship details are outdated</span>
      </label>
      <textarea class="gs-user-comment" name="outdated_info_improvement" rows="5" placeholder="What information is outdated?" ></textarea>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="not_for_international">
        <span class="gs-feedback-radio-btn">The scholarship is not for international students</span>
      </label>
      <textarea class="gs-user-comment" name="not_for_international_improvement" rows="5" placeholder="What is the reason why this scholarship is not for international students?" ></textarea>
      <input type="hidden" name="current_scholarship_info" data-scholarship-url="<?php echo get_permalink( get_the_ID() ); ?>" data-scholarship-id="<?php echo get_the_ID(); ?>" data-scholarship-title="<?php echo get_the_title(); ?>" data-scholarship-edit-page-url="<?php echo get_edit_post_link(get_the_ID()); ?>">
    </div>
    <div class="step-2" data-feedback-type="page-content">
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="not_easy_to_read">
        <span class="gs-feedback-radio-btn">The sentences and paragraphs are not easy to read</span>
      </label>
      <textarea class="gs-user-comment" name="not_easy_to_read_improvement" rows="5" placeholder="What specific sentences or paragraphs are difficult to read?" ></textarea>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="details_missing">
        <span class="gs-feedback-radio-btn">Some of the details are missing</span>
      </label>
      <textarea class="gs-user-comment" name="details_missing_improvement" rows="5"placeholder="What information is missing?" ></textarea>
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="not_clear_procedures">
        <span class="gs-feedback-radio-btn">The application procedures are not clear and concise</span>
      </label>
      <textarea class="gs-user-comment" name="not_clear_procedures_improvement" rows="5" placeholder="What specific parts of the application procedures are unclear?" ></textarea>
      <input type="hidden" name="current_scholarship_info" data-scholarship-url="<?php echo get_permalink( get_the_ID() ); ?>" data-scholarship-id="<?php echo get_the_ID(); ?>" data-scholarship-title="<?php echo get_the_title(); ?>" data-scholarship-edit-page-url="<?php echo get_edit_post_link(get_the_ID()); ?>">
    </div>
    <div class="step-2" data-feedback-type="suggestions">
      <label class="gs-feedback-radio-label">
        <input type="radio" name="improvement" value="suggestion">
        <span class="gs-feedback-radio-btn">Do you have any suggestions on what we can do to improve our scholarship pages?</span>
      </label>
      <textarea class="gs-user-comment" name="suggestion_improvement" rows="5" placeholder="Please write your suggestions." ></textarea>
      <input type="hidden" name="current_scholarship_info" data-scholarship-url="<?php echo get_permalink( get_the_ID() ); ?>" data-scholarship-id="<?php echo get_the_ID(); ?>" data-scholarship-title="<?php echo get_the_title(); ?>" data-scholarship-edit-page-url="<?php echo get_edit_post_link(get_the_ID()); ?>">
    </div>
    <div class="lds-roller" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    <div class="gs-feedback-form-buttons">
      <input type="submit" name="submit" value="Send">
    </div>
  </form>
</div>