<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <!-- Bootstrap 5.3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/sidebar.css" rel="stylesheet"> <!-- Custom Sidebar Styles -->
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Event Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if ( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="all_events.php">All Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_event.php">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register_attendee.php">Register for Event</a>
                    </li>
                    <?php if ( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="event_reports.php">Event Reports</a>
                        </li>
                    <?php endif; ?>

                    <?php if ( isset( $_SESSION['user_id'] ) ): ?>
                        <!-- Show Logout if user is logged in -->
                        <li class="nav-item ps-2">
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Show Login if user is not logged in -->
                        <li class="nav-item ps-2">
                            <a href="login.php" class="btn btn-primary">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
