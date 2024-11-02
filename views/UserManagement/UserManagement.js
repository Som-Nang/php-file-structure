const userManagement = () => {
  $("#submit").click(function () {
    let password = $("#password").val();
    let email = $("#email").val();
    let username = $("#username").val();
    let role = $("#role").val();
    let dpt_id = $("#dpt_id").val();
    let phone_number = $("#phone_number").val();
    let description = $("#description").val();
    let file = $("#file")[0].files[0];

    let formData = new FormData();

    formData.append("password", password);
    formData.append("email", email);
    formData.append("username", username);
    formData.append("role", role);
    formData.append("description", description);
    formData.append("dpt_id", dpt_id);
    formData.append("phone_number", phone_number);
    formData.append("files", file);

    Ajax(formData, "#large-modal");
  });
};

const editStaff = () => {
  $(".editBtn").click(function () {
    let staffId = this.id;
    $.ajax({
      type: "GET",
      url: editUrl,
      data: {
        staffId: staffId,
      },

      success: function (data) {
        // Show the modal
        const $targetEl = document.getElementById("edit-modal");
        const modal = new Modal($targetEl);
        modal.show();

        $(document).on("click", "#closeModal", function () {
          modal.hide();
        });

        $("#edit-modal").html(data.html);
        $("#save").click(function () {
          let email = $("#edit-modal").find("#email").val();
          let username = $("#edit-modal").find("#username").val();
          let role = $("#edit-modal").find("#role").val();
          let dpt_id = $("#edit-modal").find("#dpt_id").val();
          let phone_number = $("#edit-modal").find("#phone_number").val();
          let description = $("#edit-modal").find("#description").val();
          let file = $("#edit-modal").find("#fileEdit")[0].files[0];

          let formData = new FormData();
          formData.append("staffId", staffId);
          formData.append("email", email);
          formData.append("username", username);
          formData.append("role", role);
          formData.append("description", description);
          formData.append("dpt_id", dpt_id);
          formData.append("phone_number", phone_number);
          if (file) {
            formData.append("files", file);
          }

          Ajax(formData, "#edit-modal");
        });

        $(".resetPass").click(function () {
          let resetStaffID = this.id;
          let resetUrl = "/user-management/reset-user-password";
          ajaxPostFunc(resetStaffID, resetUrl, "Reset Password", "reset");
        });
      },
    });
  });
};

const Ajax = (formData, findParentClass) => {
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    enctype: "multipart/form-data",
    success: function (data) {
      if (data.message) {
        if (data.message === "success") {
          Swal.fire({
            title: "success",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
            position: "top-end",
            toast: true,
          });

          //   setTimeout(() => {
          //     location.reload();
          //   }, 1200);
        } else if (data.message !== "success") {
          Swal.fire({
            title: data.message,
            icon: "error",
            showConfirmButton: false,
            timer: 1500,
            position: "top-end",
            toast: true,
          });
        }
      } else if (data.errors) {
        if (data.errors.email) {
          $(findParentClass).find("#email").addClass("border-red-600");
          $(findParentClass).find("#error_email").removeClass("hidden");
          $(findParentClass).find("#error_email").addClass("block");
          $(findParentClass).find("#error_email").text(data.errors.email);
        }
        if (data.errors.username) {
          $(findParentClass).find("#username").addClass("border-red-600");
          $(findParentClass).find("#error_username").removeClass("hidden");
          $(findParentClass).find("#error_username").addClass("block");
          $(findParentClass).find("#error_username").text(data.errors.username);
        }
        if (data.errors.password) {
          $(findParentClass).find("#password").addClass("border-red-600");
          $(findParentClass).find("#error_password").removeClass("hidden");
          $(findParentClass).find("#error_password").addClass("block");
          $(findParentClass).find("#error_password").text(data.errors.password);
        }
        if (data.errors.role) {
          $(findParentClass).find("#role").addClass("border-red-600");
          $(findParentClass).find("#error_role").removeClass("hidden");
          $(findParentClass).find("#error_role").addClass("block");
          $(findParentClass).find("#error_role").text(data.errors.role);
        }
        if (data.errors.function) {
          $(findParentClass).find("#dpt_id").addClass("border-red-600");
          $(findParentClass).find("#error_function").removeClass("hidden");
          $(findParentClass).find("#error_function").addClass("block");
          $(findParentClass).find("#error_function").text(data.errors.function);
        }
      }
    },
  });
};
