<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="pages/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="pages/assets/js/sweetalert.min.js"></script>
    <script src="pages/assets/js/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center">Login</h3>
        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary  form-control">Login</button>
            </div>
        </form>
        <p class="text-center text-sm text-gray-600 mt-2">
        Don't have an account?
        <a href="register.php" class="text-green-500 font-semibold"
          >Signup</a
        >
      </p>
    </div>
</div>

<script>
$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "loginOperation.php?url=login",
      data: formData,
      dataType: "json",
      success: function (res) {
        console.log(res);  // Log the response

        if (res.status === "success") {
          swal({
            title: "Login Successful!",
            text: res.message,
            icon: "success",
            button: "OK",
          }).then(function () {
            // Redirect based on the role
            let role = res.role;
            if (role === "Admin") {
              window.location.href = "index.php";  // Admin dashboard
            } else if (role === "Doctor") {
              window.location.href = "doctor_dashboard.php";  // Doctor dashboard
            } else if (role === "Patient") {
              window.location.href = "patient_dashboard.php";  // Patient dashboard
            }
          });
        } else {
          swal({
            title: "Error!",
            text: res.message,
            icon: "error",
            button: "Try Again",
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal({
          title: "Error!",
          text: "An error occurred while submitting the form.",
          icon: "error",
          button: "Try Again",
        });
      }
    });
  });
});
</script>

</body>
</html>
