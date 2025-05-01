<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center">Login</h3>
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">UserName</label>
                <input type="text" class="form-control" id="username" name="username" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary form-control">Login</button>
            </div>
        </form>
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
                console.log(res);

                if (res.status === "success") {
                    Swal.fire({
                        title: "Login Successful!",
                        text: res.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect based on role
                            switch(res.role) {
                                case "Admin":
                                    window.location.href = "index.php";  // Admin Dashboard
                                    break;
                                case "Staff":
                                    window.location.href = "staff_dashboard.php";  // Staff Dashboard
                                    break;
                                default:
                                    window.location.href = "login.php";  // Fallback (in case no role matched)
                            }

                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: res.message,
                        icon: "error",
                        confirmButtonText: "Try Again"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    confirmButtonText: "Try Again"
                });
            }
        });
    });
});
</script>

<!-- <script>
$(document).ready(function () {
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "loginOperation.php", // Assuming loginOperation.php processes the login
            data: formData,
            dataType: "json",
            success: function (res) {
                console.log(res);

                if (res.status === "success") {
                    Swal.fire({
                        title: "Login Successful!",
                        text: res.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect based on role
                            switch(res.role) {
                                case "Admin":
                                    window.location.href = "index.php"; // Redirect to Admin dashboard
                                    break;
                                case "Staff":
                                    window.location.href = "staff_dashboard.php"; // Redirect to Staff dashboard
                                    break;
                                default:
                                    window.location.href = "login.php"; // Default case, should not happen
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: res.message,
                        icon: "error",
                        confirmButtonText: "Try Again"
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while submitting the form.",
                    icon: "error",
                    confirmButtonText: "Try Again"
                });
            }
        });
    });
});
</script> -->


<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>