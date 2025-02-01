<?php

require_once 'db/db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    die("Access denied. Admins only.");
}

$eventsQuery = "SELECT * FROM events ORDER BY event_date";
$eventsResult = $conn->query($eventsQuery);
?>

<?php include 'includes/header.php'; ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="container my-5">
    <h3 class="mb-3">Event Reports</h3>
    <div class="table-responsive">
        <table id="eventTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $serial = 1;
                while ($event = $eventsResult->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?= $serial++; ?></td>
                        <td><?= htmlspecialchars($event['name']); ?></td>
                        <td><?= date("j M Y", strtotime($event['event_date'])); ?></td>
                        <td><?=$event['location'];?></td>
                        <td>
                            <form method="POST" action="download_report.php" class="d-inline">
                                <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Download Attendees</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#eventTable').DataTable({
        "paging": true, 
        "searching": true, 
        "ordering": true, 
        "info": true 
    });
});
</script>

<?php include 'includes/footer.php'; ?>
