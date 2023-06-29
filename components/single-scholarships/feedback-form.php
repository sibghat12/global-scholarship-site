<!-- <div class="gs-feeback-form-container">
    <form id="gs-feeback-form" action="" method="POST" class="gs-feeback-form">
        <div class="gs-feedback-intro">We have around 4,000 scholarships on our database, and while our team strives in making sure that these scholarships are up to date, we also need your help!</div>
        <div class="gs-feedback-form-question">Did you find this page helpful? If not, can you let us know why and how we can improve our page!</div>
        <input type="button" name="yes" value="Yes">
        <input type="button" name="no" value="No">
    </form>
</div> -->

<!-- <div class="gs-feeback-form-container">
  <form id="gs-feeback-form" action="" method="POST" class="gs-feeback-form">
    <div class="step-1">
      <div class="gs-feedback-intro">We have around 4,000 scholarships on our database, and while our team strives in making sure that these scholarships are up to date, we also need your help!</div>
      <div class="gs-feedback-form-question">Did you find this page helpful? If not, can you let us know why and how we can improve our page!</div>
      <input type="button" name="yes" value="Yes">
      <input type="button" name="no" value="No">
    </div>
    <div class="step-2" style="display:none;">
      <div class="gs-feedback-form-question">How can we improve this page?</div>
      <label><input type="radio" name="improvement" value="more_information">More information needed</label>
      <label><input type="radio" name="improvement" value="better_design">Better design</label>
      <label><input type="radio" name="improvement" value="more_user_friendly">More user-friendly</label>
      <label><input type="radio" name="improvement" value="other">Other:</label>
      <input type="text" name="other_improvement" placeholder="Please specify" style="display:none;">
      <input type="button" name="back" value="Back">
      <input type="submit" name="submit" value="Submit">
    </div>
  </form>
</div>

<script>
  var yesBtn = document.querySelector('input[name="yes"]');
  var noBtn = document.querySelector('input[name="no"]');
  var backBtn = document.querySelector('input[name="back"]');
  var radioInputs = document.querySelectorAll('input[type="radio"]');
  var otherInput = document.querySelector('input[name="other_improvement"]');

  yesBtn.addEventListener('click', function() {
    document.querySelector('.step-1').style.display = "none";
    document.querySelector('.step-2').style.display = "block";
  });

  noBtn.addEventListener('click', function() {
    for (var i = 0; i < radioInputs.length; i++) {
      radioInputs[i].style.display = "block";
    }
    otherInput.style.display = "block";
    document.querySelector('.step-1').style.display = "none";
  });

  backBtn.addEventListener('click', function() {
    for (var i = 0; i < radioInputs.length; i++) {
      radioInputs[i].style.display = "none";
      radioInputs[i].checked = false;
    }
    otherInput.style.display = "none";
    otherInput.value = "";
    document.querySelector('.step-1').style.display = "block";
    document.querySelector('.step-2').style.display = "none";
  });

  for (var i = 0; i < radioInputs.length; i++) {
    radioInputs[i].addEventListener('click', function() {
      if (this.value === "other") {
        otherInput.style.display = "block";
      } else {
        otherInput.style.display = "none";
      }
    });
  }
</script> -->



<div class="gs-feeback-form-container">
  <form id="gs-feeback-form" action="" method="POST" class="gs-feeback-form">
    <div class="gs-feedback-intro">We have around 4,000 scholarships on our database, and while our team strives in making sure that these scholarships are up to date, we also need your help!</div>
    <div class="gs-feedback-form-question">Did you find this page helpful? If not, can you let us know why and how we can improve our page!</div>
    <input type="button" name="yes" value="Yes">
    <input type="button" name="no" value="No">
    <div class="step-2" style="display:none;">
      <div class="gs-feedback-form-question">How can we improve this page?</div>
      <label><input type="radio" name="improvement" value="incorrect_info">The scholarship information is incorrect</label>
      <label><input type="radio" name="improvement" value="outdated_info">The scholarship details are outdated</label>
      <label><input type="radio" name="improvement" value="not_for_international_students">The scholarship is not for international students</label>
      <label><input type="radio" name="improvement" value="other">Others:</label>
      <textarea name="other_improvement" rows="5"placeholder="Please specify" style="display:none;"></textarea>
    </div>
    <div class="gs-feedback-form-buttons" style="display:none;">
      <input type="submit" name="submit" value="Send">
    </div>
  </form>
</div>


<script>
  var yesBtn = document.querySelector('input[name="yes"]');
  var noBtn = document.querySelector('input[name="no"]');
  var radioInputs = document.querySelectorAll('input[type="radio"]');
  var otherTextarea = document.querySelector('textarea[name="other_improvement"]');
  var buttonsDiv = document.querySelector('.gs-feedback-form-buttons');
  var form = document.querySelector('#gs-feeback-form');

  yesBtn.addEventListener('click', function() {
    buttonsDiv.style.display = "block";
    document.querySelector('.step-2').style.display = "none";
  });

  noBtn.addEventListener('click', function() {
    buttonsDiv.style.display = "block";
    document.querySelector('.step-2').style.display = "block";
    for (var i = 0; i < radioInputs.length; i++) {
      radioInputs[i].style.display = "block";
    }
    otherTextarea.style.display = "block";
  });

  for (var i = 0; i < radioInputs.length; i++) {
    radioInputs[i].addEventListener('click', function() {
      if (this.value === "other") {
        otherTextarea.style.display = "block";
      } else {
        otherTextarea.style.display = "none";
      }
    });
  }

  form.addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(form);
    $.ajax({
      url: '<?php echo admin_url("admin-ajax.php"); ?>',
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        console.log(response);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
</script>