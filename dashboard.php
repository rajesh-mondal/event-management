<?php
session_start();
include 'db/db.php';

if ( !isset( $_SESSION['user_id'] ) || !isset( $_SESSION['role'] ) || strtolower( $_SESSION['role'] ) !== 'admin' ) {
    die( "Access denied. Admins only." );
}

$totalEvents = $conn->query( "SELECT COUNT(*) AS total FROM events" )->fetch_assoc()['total'];
$totalAttendees = $conn->query( "SELECT COUNT(*) AS total FROM attendees" )->fetch_assoc()['total'];
$newRegistrations = $conn->query( "SELECT COUNT(*) AS total FROM users WHERE created_at >= NOW() - INTERVAL 7 DAY" )->fetch_assoc()['total'];

$recentEvents = $conn->query( "SELECT id, name, event_date, event_time, location FROM events ORDER BY event_date ASC LIMIT 10" );
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2 class="mt-4">Dashboard</h2>
            <div class="row my-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Events</h5>
                            <p class="card-text display-6"><?=$totalEvents;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Total Attendees</h5>
                            <p class="card-text display-6"><?=$totalAttendees;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">New Registrations (Last 7 Days)</h5>
                            <p class="card-text display-6"><?=$newRegistrations;?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h4>Upcomming Events</h4>
            <table id="eventTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $serial = 1;while ( $event = $recentEvents->fetch_assoc() ): ?>
                    <tr>
                        <td><?=$serial++;?></td>
                        <td><?=htmlspecialchars( $event['name'] );?></td>
                        <td><?=date( "j M Y", strtotime( $event['event_date'] ) );?></td>
                        <td><?=htmlspecialchars( $event['location'] );?></td>
                        <td>
                            <form method="POST" action="download_report.php" class="d-inline">
                                <input type="hidden" name="event_id" value="<?=$event['id'];?>">
                                <button type="submit" class="btn btn-primary btn-sm">Download Attendees</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#eventTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "pageLength": 5,
            "lengthChange": false
        });
    });
</script>

<?php include 'includes/footer.php'; ?>