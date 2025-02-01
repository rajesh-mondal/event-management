<?php

require_once 'db/db.php';

session_start();

$message = '';

if ( !isset( $_SESSION['user_id'] ) ) {
    die( "You must be logged in to register for an event." );
}

$user_id = (int) $_SESSION['user_id'];
$userQuery = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare( $userQuery );
$stmt->bind_param( "i", $user_id );
$stmt->execute();
$userResult = $stmt->get_result();

if ( $userResult->num_rows === 0 ) {
    die( "User not found." );
}

$user = $userResult->fetch_assoc();
$username = htmlspecialchars( $user['username'] );
$email = htmlspecialchars( $user['email'] );

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( !isset( $_POST['event_id'] ) ) {
        die( "Event ID is required to register." );
    }

    $event_id = (int) $_POST['event_id'];

    $eventQuery = "SELECT max_capacity,
                          (SELECT COUNT(*) FROM attendees WHERE event_id = ?) AS registered
                   FROM events WHERE id = ?";
    $stmt = $conn->prepare( $eventQuery );
    $stmt->bind_param( "ii", $event_id, $event_id );
    $stmt->execute();
    $eventResult = $stmt->get_result();

    if ( $eventResult->num_rows === 0 ) {
        die( "The event does not exist." );
    }

    $event = $eventResult->fetch_assoc();
    if ( $event['registered'] >= $event['max_capacity'] ) {
        die( "The event has reached its maximum capacity." );
    }

    $checkQuery = "SELECT id FROM attendees WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare( $checkQuery );
    $stmt->bind_param( "ii", $event_id, $user_id );
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ( $checkResult->num_rows > 0 ) {
        die( "You are already registered for this event." );
    }

    $registerQuery = "INSERT INTO attendees (event_id, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare( $registerQuery );
    $stmt->bind_param( "ii", $event_id, $user_id );

    if ( $stmt->execute() ) {
        $message = '<div class="alert alert-success">You have successfully registered for the event.</div>';
    } else {
        $message = '<div class="alert alert-danger">Error registering for the event: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}
?>

<?php include 'includes/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if ( $message ): ?>
                <div class="mb-3">
                    <?=$message;?>
                </div>
            <?php endif; ?>

            <h3 class="mb-3">Register for Event</h3>

            <?php
            $eventsQuery = "SELECT id, name, event_date FROM events WHERE max_capacity > (SELECT COUNT(*) FROM attendees WHERE event_id = events.id)";
            $eventsResult = $conn->query( $eventsQuery );

            if ( $eventsResult->num_rows > 0 ): ?>
                <form method="POST" action="register_attendee.php">
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Select Event</label>
                        <select class="form-select" id="event_id" name="event_id" required>
                            <option value="" disabled selected>Choose an event</option>
                            <?php while ($event = $eventsResult->fetch_assoc()): ?>
                                <?php
                                $event_timestamp = strtotime($event['event_date']);
                                $formattedDate = date("j F Y", $event_timestamp);
                                ?>
                                <option value="<?php echo $event['id']; ?>">
                                    <?php echo htmlspecialchars($event['name']); ?> (<?php echo $formattedDate; ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?php echo $username; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?php echo $email; ?>" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            <?php else: ?>
                <div class="alert alert-info">No events available for registration at the moment.</div>
            <?php endif; ?>

            <?php
                $conn->close();
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
