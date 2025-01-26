<?php
include 'db/db.php';
session_start();

if ( !isset( $_SESSION['user_id'] ) ) {
    echo "Error: You must be logged in to edit an event.";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare( $query );
$stmt->bind_param( "i", $id );
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if ( !$event ) {
    echo "Error: Event not found.";
    exit;
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $name = htmlspecialchars( $_POST['name'] );
    $description = htmlspecialchars( $_POST['description'] );
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $max_capacity = $_POST['max_capacity'];

    if ( empty( $max_capacity ) ) {
        echo "Error: Capacity cannot be empty.";
        exit;
    }

    $updateQuery = "UPDATE events SET name = ?, description = ?, event_date = ?, location = ?, max_capacity = ? WHERE id = ?";
    $stmt = $conn->prepare( $updateQuery );
    $stmt->bind_param( "ssssii", $name, $description, $event_date, $location, $max_capacity, $id );

    if ( $stmt->execute() ) {
        header( "Location: index.php?success=Event updated successfully" );
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<?php include 'includes/header.php'; ?>
<div class="container d-flex justify-content-center align-items-center vh-100 my-5">
    <div class="col-12 col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Edit Event</h3>
            <a href="index.php" class="btn btn-sm btn-secondary">Back to Events</a>
        </div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" id="name" name="name" value="<?=htmlspecialchars( $event['name'] );?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?=htmlspecialchars( $event['description'] );?></textarea>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="<?=$event['event_date'];?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?=htmlspecialchars( $event['location'] );?>" required>
            </div>
            <div class="mb-3">
                <label for="max_capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="max_capacity" name="max_capacity" value="<?=$event['max_capacity'];?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
