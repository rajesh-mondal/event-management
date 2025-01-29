<?php
session_start();
include 'db/db.php';

// Fetch all events
$query = "SELECT * FROM events ORDER BY event_date";
$result = $conn->query( $query );
?>

<?php include 'includes/header.php'; ?>
<div class="container my-4">
    <h3 class="text-center">Event List</h3>
    <?php if ( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ): ?>
        <a href="create_event.php" class="btn btn-success mb-2">Add New Event</a>
    <?php endif; ?>
    <table id="eventTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <!-- <th>Capacity</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serial = 1;
                while ( $event = $result->fetch_assoc() ): 
            ?>
                <tr>
                    <td><?=$serial++;?></td>
                    <td><?=htmlspecialchars( $event['name'] );?></td>
                    <td><?=htmlspecialchars( substr( $event['description'], 0, 45 ) );?>...</td>
                    <td><?= date("j M Y", strtotime($event['event_date'])); ?></td>
                    <td><?= date("h:i A", strtotime($event['event_time'])); ?></td>
                    <td><?=$event['location'];?></td>
                    <!-- <td><?=$event['max_capacity'];?></td> -->
                    <td class="d-flex">
                        <a href="edit_event.php?id=<?=$event['id'];?>" class="btn btn-primary btn-sm me-2">Edit</a>
                        <a href="delete_event.php?id=<?=$event['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#eventTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            // "pageLength": 10,
            // "lengthChange": false
        });

        $('div.dataTables_filter').addClass('mb-3');
    });
</script>

<?php include 'includes/footer.php'; ?>