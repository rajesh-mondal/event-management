<?php
require_once 'db/db.php';
session_start();

if ( !isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
    header( "Location: index.php" );
    exit();
}

$event_id = (int) $_GET['id'];

$query = "SELECT e.*,
                 (e.max_capacity - (SELECT COUNT(*) FROM attendees WHERE event_id = e.id)) AS remaining_capacity
          FROM events e
          WHERE e.id = ?";
$stmt = $conn->prepare( $query );
$stmt->bind_param( "i", $event_id );
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if ( !$event ) {
    header( "Location: index.php" );
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars( $event['name'] );?> - Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .event-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .event-header {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .event-icons p {
            font-size: 1rem;
            margin: 8px 0;
        }
        .event-icons i {
            color: #0d6efd;
            margin-right: 10px;
        }
        .btn-register {
            background: #0d6efd;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .btn-register:hover {
            background: #0048b3;
        }
        .btn-back {
            background: #6c757d;
            color: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #545b62;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="event-container">
        <h2 class="event-header"><?=htmlspecialchars( $event['name'] );?></h2>

        <div class="event-icons d-flex flex-wrap align-items-center gap-4">
            <p class="mb-0"><i class="fa-solid fa-calendar"></i> <?=date( "j F Y", strtotime( $event['event_date'] ) );?></p>
            <p class="mb-0"><i class="fa-solid fa-clock"></i> <?=date( "g:i A", strtotime( $event['event_time'] ) );?></p>
            <p class="mb-0"><i class="fa-solid fa-map-marker-alt"></i> <?=htmlspecialchars( $event['location'] );?></p>
            <p class="mb-0"><i class="fa-solid fa-users"></i> Remaining Capacity: <?=max( 0, $event['remaining_capacity'] );?></p>
        </div>

        <p class="text-muted pt-3"><?=htmlspecialchars( $event['description'] );?></p>

        <div class="mt-4 d-flex justify-content-between">
            <a href="index.php" class="btn btn-outline-secondary btn-back">Back to Events</a>

            <?php if ( isset( $_SESSION['user_id'] ) ): ?>
                <?php if ( $event['remaining_capacity'] > 0 ): ?>
                    <form method="POST" action="register_attendee.php">
                        <input type="hidden" name="event_id" value="<?=$event_id;?>">
                        <button type="submit" class="btn btn-primary btn-register">Register Now</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-danger" disabled>Event Full</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn btn-warning">Login to Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
