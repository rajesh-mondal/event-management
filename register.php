<?php
include 'db/db.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $username = htmlspecialchars( $_POST['username'] );
    $email = htmlspecialchars( $_POST['email'] );
    $password = password_hash( $_POST['password'], PASSWORD_DEFAULT );

    if ( !isset( $conn ) ) {
        die( "Database connection failed." );
    }

    $stmt = $conn->prepare( "INSERT INTO users (username, email, password) VALUES (?, ?, ?)" );
    $stmt->bind_param( "sss", $username, $email, $password );

    if ( $stmt->execute() ) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg col-md-6">
            <div class="card-header text-center bg-primary text-white">
                <h3>Register</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>