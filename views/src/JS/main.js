// Input Profile image with default
var loadFile = function (event) {
  var image = document.getElementById("output");
  console.log("qqqq");
  image.src = URL.createObjectURL(event.target.files[0]);
};

var loadFileEdit = function (event) {
  var image = document.getElementById("outputEditFile");
  image.src = URL.createObjectURL(event.target.files[0]);

  console.log("sssssss");
};

const deleteData = (id, url) => {
  Swal.fire({
    title: "Delete",
    text: "Are you sure you want to delete?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it!",
    confirmButtonColor: "#E74C3C",
    cancelButtonText: "cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Processing",
        icon: "warning",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
          $.ajax({
            type: "POST",
            url: url,
            data: {
              deleteID: id,
            },
            success: function (response) {
              if (response === "success") {
                swal.close();
                Swal.fire({
                  title: "Success",
                  icon: "success",
                  showCancelButton: false,
                  confirmButtonText: "Yes",
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              } else {
                swal.close();
                Swal.fire({
                  title: response,
                  icon: "error",
                  showCancelButton: false,
                  confirmButtonText: "Yes",
                });
              }
            },
          });
        },
      });
    }
  });
};

const ajaxPostFunc = (id, url, text, key) => {
  Swal.fire({
    title: "Delete",
    text: "Are you sure you want to " + text + "?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, " + text + " it!",
    confirmButtonColor: "#E74C3C",
    cancelButtonText: "cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Processing",
        icon: "warning",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
          $.ajax({
            type: "POST",
            url: url,
            data: { [key]: id },

            success: function (response) {
              if (response === "success") {
                swal.close();
                Swal.fire({
                  title: "Success",
                  icon: "success",
                  showCancelButton: false,
                  confirmButtonText: "Yes",
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              } else {
                swal.close();
                Swal.fire({
                  title: response,
                  icon: "error",
                  showCancelButton: false,
                  confirmButtonText: "Yes",
                });
              }
            },
          });
        },
      });
    }
  });
};

// End Input Profile image with default
