<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <!-- Bootstrap 5.3 CSS (Latest Version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Custom Stylesheets -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/sidebar.css" rel="stylesheet"> <!-- Custom Sidebar Styles -->
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Event Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">All Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_event.php">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register_attendee.php">Register for Event</a>
                    </li>
                    <?php if ( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="event_reports.php">View Attendees</a>
                        </li>
                    <?php endif; ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Welcome, <?=htmlspecialchars( $_SESSION['username'] ?? 'Guest' );?></a>
                    </li> -->
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <!-- <div class="container mt-4"> -->
