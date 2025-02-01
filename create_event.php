<?php
include 'db/db.php';
session_start();

if ( !isset( $_SESSION['user_id'] ) ) {
    echo "Error: You must be logged in to create an event.";
    exit;
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $name = htmlspecialchars( $_POST['name'] );
    $description = htmlspecialchars( $_POST['description'] );
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $max_capacity = $_POST['max_capacity'];

    $created_by = $_SESSION['user_id'];

    if ( empty( $max_capacity ) ) {
        echo "Error: Capacity cannot be empty.";
        exit;
    }

    $stmt = $conn->prepare( "INSERT INTO events (name, description, event_date, event_time, location, max_capacity, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)" );

    $stmt->bind_param( "sssssii", $name, $description, $event_date, $event_time, $location, $max_capacity, $created_by );

    if ( $stmt->execute() ) {
        header( "Location: all_events.php?success=Event added successfully" );
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<?php include 'includes/header.php'; ?>
<div class="container d-flex justify-content-center align-items-center my-5 ">
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Add New Event</h3>
            <a href="all_events.php" class="btn btn-sm btn-secondary">Back to Events</a>
        </div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" required>
            </div>
            <div class="mb-3">
                <label for="event_time" class="form-label">Time</label>
                <input type="time" class="form-control" id="event_time" name="event_time" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="max_capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="max_capacity" name="max_capacity" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
