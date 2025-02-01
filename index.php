<?php
require_once 'db/db.php';
session_start();

$eventsPerPage = 6;
$page = isset( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$offset = ( $page - 1 ) * $eventsPerPage;

$totalEventsQuery = "SELECT COUNT(*) as total FROM events";
$totalEventsResult = $conn->query( $totalEventsQuery );
$totalEvents = $totalEventsResult->fetch_assoc()['total'];
$totalPages = ceil( $totalEvents / $eventsPerPage );

$eventsQuery = "SELECT e.*,
                      (e.max_capacity - (SELECT COUNT(*) FROM attendees WHERE event_id = e.id)) AS remaining_capacity
                FROM events e ORDER BY e.event_date ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare( $eventsQuery );
$stmt->bind_param( "ii", $eventsPerPage, $offset );
$stmt->execute();
$events = $stmt->get_result();

?>

<?php include 'includes/header.php'; ?>
    <div class="container my-5">
        <h2 class="text-center mb-5">Upcoming Events</h2>
        <div class="row">
            <?php while ( $event = $events->fetch_assoc() ): ?>
                <div class="col-md-4 mb-4">
                    <div class="card event-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary-emphasis fw-semibold"> <?=htmlspecialchars( $event['name'] );?> </h5>
                            <p class="text-muted"><?=htmlspecialchars( mb_strlen( $event['description'] ) > 300 ? mb_substr( $event['description'], 0, 300 ) . '...' : $event['description'] );?></p>
                            <div class="event-icons">
                                <p><i class="fa-solid fa-calendar"></i> <?=date( "j F Y", strtotime( $event['event_date'] ) );?></p>
                                <p><i class="fa-solid fa-clock"></i> <?=date( "g:i A", strtotime( $event['event_time'] ) );?></p>
                                <p><i class="fa-solid fa-map-marker-alt"></i> <?=htmlspecialchars( $event['location'] );?></p>
                                <p><i class="fa-solid fa-users"></i> Remaining Capacity: <?=max( 0, $event['remaining_capacity'] );?></p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="event_details.php?id=<?=$event['id'];?>" class="btn btn-outline-secondary">View Details</a>
                                <?php if ( isset( $_SESSION['user_id'] ) ): ?>
                                    <form method="POST" action="register_attendee.php">
                                        <input type="hidden" name="event_id" value="<?=$event['id'];?>">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-warning">Login to Register</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ( $i = 1; $i <= $totalPages; $i++ ): ?>
                    <li class="page-item <?=( $i === $page ) ? 'active' : '';?>">
                        <a class="page-link" href="index.php?page=<?=$i;?>"> <?=$i;?> </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>

<?php $conn->close(); ?>

<?php include 'includes/footer.php'; ?>