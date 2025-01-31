<?php
include 'db/db.php';
session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['ajax'] ) ) {
    header( "Content-Type: application/json" );
    $response = [];

    $email = htmlspecialchars( $_POST['email'] );
    $password = $_POST['password'];

    $stmt = $conn->prepare( "SELECT id, username, password, role FROM users WHERE email = ?" );
    $stmt->bind_param( "s", $email );
    $stmt->execute();
    $result = $stmt->get_result();

    if ( $result->num_rows > 0 ) {
        $user = $result->fetch_assoc();
        if ( password_verify( $password, $user['password'] ) ) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ( $user['role'] === 'admin' ) {
                $response["redirect"] = "dashboard.php";
            } else {
                $response["redirect"] = "index.php";
            }

            $response["success"] = "Login Successful!";
        } else {
            $response["error"] = "Invalid Password.";
        }
    } else {
        $response["error"] = "No user found with this email.";
    }

    $stmt->close();
    echo json_encode( $response );
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="message"></div>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Don't have an account? <a href="register.php" class="text-primary">Register here</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#loginForm").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: "login.php",
                    type: "POST",
                    data: $(this).serialize() + "&ajax=1",
                    dataType: "json",
                    beforeSend: function() {
                        $("button").prop("disabled", true).text("Logging in...");
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#message").html('<div class="alert alert-success text-center mt-3">' + response.success + '</div>');
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1500);
                        } else {
                            $("#message").html('<div class="alert alert-danger text-center mt-3">' + response.error + '</div>');
                            $("button").prop("disabled", false).text("Login");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $("#message").html('<div class="alert alert-danger text-center mt-3">Something went wrong!</div>');
                        $("button").prop("disabled", false).text("Login");
                    }
                });
            });
        });

    </script>

</body>
</html>
