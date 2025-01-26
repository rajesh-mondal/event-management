<?php
include 'db/db.php';

// Fetch all events
$query = "SELECT * FROM events ORDER BY event_date";
$result = $conn->query( $query );
?>

<?php include 'includes/header.php'; ?>
<div class="container my-5">
    <h3 class="text-center">All Events</h3>
    <a href="create_event.php" class="btn btn-success mb-3">Add New Event</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ( $row = $result->fetch_assoc() ): ?>
                <tr>
                    <td><?=$row['id'];?></td>
                    <td><?=htmlspecialchars( $row['name'] );?></td>
                    <td><?=htmlspecialchars( substr( $row['description'], 0, 55 ) );?>...</td>
                    <td><?=$row['event_date'];?></td>
                    <td><?=$row['location'];?></td>
                    <td><?=$row['max_capacity'];?></td>
                    <td class="d-flex">
                        <a href="edit_event.php?id=<?=$row['id'];?>" class="btn btn-primary btn-sm me-2">Edit</a>
                        <a href="delete_event.php?id=<?=$row['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>