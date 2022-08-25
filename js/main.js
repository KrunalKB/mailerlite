$(document).ready(function () {
  $("#contactForm").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true,
      },
      message: {
        required: true,
        minlength: 5,
      },
    },
    messages: {
      name: "Please enter your name",
      email: "Please enter a valid email address",
      message: "Please enter a message",
    },

    submitHandler: function (form) {
      var form_data = new FormData(form);
      form_data.append("action", "user_hook");
      form_data.append("nonce", myLink.nonce);
      $.ajax({
        url: myLink.ajax_link,
        type: "POST",
        contentType: false,
        processData: false,
        data: form_data,
        success: function (response) {
          // alert(response);
          //   $(".registerbtn").css({
          //     "background-color": "#0170b9",
          //     color: "#fff",
          //   });
          //   $(".loader").hide();
          //   $(".msg").html(response);
        },
      });
    },
  });
});
