$(document).ready(function () {
  $("#form-message-success").hide();
  $(".loader").hide();
  $("#contactForm").validate({
    rules: {
      name : "required",
      email: {
        required: true,
        email   : true,
      },
      subject: "required",
      message: {
        required : true,
        minlength: 5,
      },
    },
    messages: {
      name   : "Please enter your name",
      email  : "Please enter a valid email address",
      subject: "Please enter a subject",
      message: "Please enter a message",
    },

    submitHandler: function (form) {
      $(".loader").show();
      var form_data = new FormData(form);
      form_data.append("action", "user_hook");
      form_data.append("nonce", myLink.nonce);
      $.ajax({
        url        : myLink.ajax_link,
        type       : "POST",
        contentType: false,
        processData: false,
        data       : form_data,
        success    : function (response) {
          if (response) {
            $("#form-message-success").show();
            $(".loader").hide();
            setTimeout(function () {
              location.reload(true);
            }, 5000);
          }
        },
      });
    },
  });
});
