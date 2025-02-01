<?php
include 'db/db.php';

$id = $_GET['id'];
$query = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare( $query );
$stmt->bind_param( "i", $id );

if ( $stmt->execute() ) {
    header( "Location: all_events.php?success=Event deleted successfully" );
} else {
    echo "Error: " . $stmt->error;
}