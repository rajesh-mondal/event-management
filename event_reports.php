<?php

require_once 'db/db.php';
session_start();

// echo "Session Role: " . ($_SESSION['role'] ?? 'Not Set') . "<br>";
// echo "Session User ID: " . ($_SESSION['user_id'] ?? 'Not Set') . "<br>";

if ( !isset( $_SESSION['user_id'] ) || !isset( $_SESSION['role'] ) || strtolower( $_SESSION['role'] ) !== 'admin' ) {
    die( "Access denied. Admins only." );
}

$eventsQuery = "SELECT id, name FROM events";
$eventsResult = $conn->query( $eventsQuery );
?>

<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
        <h3 class="mb-3">Event Reports</h3>
            <form method="POST" action="download_report.php">
                <div class="mb-3">
                    <label for="event_id" class="form-label">Select Event</label>
                    <select class="form-select" id="event_id" name="event_id" required>
                        <option value="" disabled selected>Choose an event</option>
                        <?php while ( $event = $eventsResult->fetch_assoc() ): ?>
                            <option value="<?php echo $event['id']; ?>">
                                <?php echo htmlspecialchars( $event['name'] ); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Download Attendee List</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>