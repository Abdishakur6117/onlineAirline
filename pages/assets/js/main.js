// $(document).ready(function () {
//   $("#loginForm").on("submit", function (e) {
//     e.preventDefault();
//     let formData = $(this).serialize();

//     $.ajax({
//       type: "POST",
//       url: "loginOperation.php?url=login",
//       data: formData,
//       dataType: "json", // Expecting JSON response from the server
//       success: function (res) {
//         // Log the response to verify if it's as expected
//         console.log(res); // Check what is inside res in the console

//         // Check for response status and act accordingly
//         if (res.status === "success") {
//           // Success response
//           swal({
//             title: "Login Successful!",
//             text: res.message,
//             icon: "success",
//             button: "OK",
//           }).then(function () {
//             // Redirect based on the role
//             let role = res.role;
//             if (role === "Admin") {
//               window.location.href = "index.php";
//             } else if (role === "Doctor") {
//               window.location.href = "doctor_dashboard.php";
//             } else if (role === "Patient") {
//               window.location.href = "patient_dashboard.php";
//             }
//           });
//         } else {
//           // Error response
//           swal({
//             title: "Error!",
//             text: res.message, // Show the error message from the response
//             icon: "error",
//             button: "Try Again",
//           });
//         }
//       },
//       error: function (jqXHR, textStatus, errorThrown) {
//         console.log(textStatus, errorThrown); // Log the error details

//         swal({
//           title: "Error!",
//           text: "An error occurred while submitting the form.",
//           icon: "error",
//           button: "Try Again",
//         });
//       },
//     });
//   });
// });

// $(document).ready(function () {
//   $("#loginForm").on("submit", function (e) {
//     e.preventDefault();
//     let formData = $(this).serialize();

//     $.ajax({
//       type: "POST",
//       url: "loginOperation.php?url=login", // Make sure this URL is correct
//       data: formData,
//       dataType: "json", // Expecting JSON response from the server
//       success: function (res) {
//         console.log(res); // Log the response to check if it’s what we expect

//         // Check the response status to trigger appropriate alert
//         if (res.status === "success") {
//           // If login is successful, show success alert and redirect based on role
//           swal({
//             title: "Login Successful!",
//             text: res.message, // Display the success message
//             icon: "success", // SweetAlert icon for success
//             button: "OK", // Button text
//           }).then(function () {
//             // Redirect based on the role received from the server response
//             let role = res.role;
//             if (role === "Admin") {
//               window.location.href = "index.php"; // Admin dashboard
//             } else if (role === "Doctor") {
//               window.location.href = "doctor_dashboard.php"; // Doctor dashboard
//             } else if (role === "Patient") {
//               window.location.href = "patient_dashboard.php"; // Patient dashboard
//             }
//           });
//         } else {
//           // If login fails, show error alert
//           swal({
//             title: "Error!",
//             text: res.message, // Display the error message
//             icon: "error", // SweetAlert icon for error
//             button: "Try Again", // Button text
//           });
//         }
//       },
//       error: function (jqXHR, textStatus, errorThrown) {
//         // If AJAX request fails for any reason, show an error alert
//         swal({
//           title: "Error!",
//           text: "An error occurred while submitting the form.",
//           icon: "error", // SweetAlert icon for error
//           button: "Try Again", // Button text
//         });
//       },
//     });
//   });
// });


$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "loginOperation.php?url=login", // Make sure this URL is correct
      data: formData,
      dataType: "json", // Expecting JSON response from the server
      success: function (res) {
        console.log(res); // Log the response to check if it’s what we expect

        // Ensure the response contains the 'status' and 'message'
        if (res.status === "success") {
          console.log("Login success");

          swal({
            title: "Login Successful!",
            text: res.message, // Display the success message
            icon: "success", // SweetAlert icon for success
            button: "OK", // Button text
          }).then(function () {
            // Redirect based on the role received from the server response
            let role = res.role;
            console.log("User role: ", role); // Debugging role value
            if (role === "Admin") {
              window.location.href = "index.php"; // Admin dashboard
            } else if (role === "Doctor") {
              window.location.href = "doctor_dashboard.php"; // Doctor dashboard
            } else if (role === "Patient") {
              window.location.href = "patient_dashboard.php"; // Patient dashboard
            }
          });
        } else {
          console.log("Login failed");

          swal({
            title: "Error!",
            text: res.message, // Display the error message
            icon: "error", // SweetAlert icon for error
            button: "Try Again", // Button text
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX error:", textStatus, errorThrown); // Log AJAX error
        // If AJAX request fails for any reason, show an error alert
        swal({
          title: "Error!",
          text: "An error occurred while submitting the form.",
          icon: "error", // SweetAlert icon for error
          button: "Try Again", // Button text
        });
      },
    });
  });
});
