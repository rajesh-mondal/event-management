<?php
include 'db/db.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['ajax'] ) ) {
    header( "Content-Type: application/json" );
    $response = [];

    $username = htmlspecialchars( $_POST['username'] );
    $email = htmlspecialchars( $_POST['email'] );
    $password = password_hash( $_POST['password'], PASSWORD_DEFAULT );

    if ( !isset( $conn ) ) {
        $response["error"] = "Database connection failed.";
        echo json_encode( $response );
        exit;
    }

    $checkStmt = $conn->prepare( "SELECT id FROM users WHERE email = ?" );
    $checkStmt->bind_param( "s", $email );
    $checkStmt->execute();
    $checkStmt->store_result();

    if ( $checkStmt->num_rows > 0 ) {
        $response["error"] = "Email is already registered!";
    } else {
        $stmt = $conn->prepare( "INSERT INTO users (username, email, password) VALUES (?, ?, ?)" );
        $stmt->bind_param( "sss", $username, $email, $password );

        if ( $stmt->execute() ) {
            $response["success"] = "Registration successful!";
        } else {
            $response["error"] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $checkStmt->close();

    echo json_encode( $response );
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <div id="message"></div>
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <form id="registrationForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#registrationForm").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: "register.php",
                    type: "POST",
                    data: $(this).serialize() + "&ajax=1",
                    dataType: "json",
                    beforeSend: function() {
                        $("button").prop("disabled", true).text("Registering...");
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#message").html('<div class="alert alert-success text-center mt-3">' + response.success + '</div>');
                            $("#registrationForm")[0].reset();
                        } else {
                            $("#message").html('<div class="alert alert-danger text-center mt-3">' + response.error + '</div>');
                        }
                        $("button").prop("disabled", false).text("Register");
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $("#message").html('<div class="alert alert-danger text-center mt-3">Something went wrong!</div>');
                        $("button").prop("disabled", false).text("Register");
                    }
                });
            });
        });
    </script>

</body>
</html>
