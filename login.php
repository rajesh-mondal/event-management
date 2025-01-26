<?php
include 'db/db.php';

session_start();

$message = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $email = htmlspecialchars( $_POST['email'] );
    $password = $_POST['password'];

    $stmt = $conn->prepare( "SELECT id, username, password FROM users WHERE email = ?" );
    $stmt->bind_param( "s", $email );
    $stmt->execute();
    $result = $stmt->get_result();

    if ( $result->num_rows > 0 ) {
        $user = $result->fetch_assoc();
        if ( password_verify( $password, $user['password'] ) ) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $message = "<div class='alert alert-success'>Login Successful!</div>";
            // Redirect to dashboard after successful login
            header("Location: index.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Invalid Password.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>No user found with this email.</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ( $message ): ?>
                    <div class="mb-3">
                        <?=$message;?>
                    </div>
                <?php endif; ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
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
</body>
</html>