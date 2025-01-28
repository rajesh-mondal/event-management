<?php

require_once 'db/db.php';
session_start();


if ( !isset( $_SESSION['user_id'] ) || $_SESSION['role'] !== 'admin' ) {
    die( "Access denied. Admins only." );
}


if ( !isset( $_POST['event_id'] ) ) {
    die( "Event ID is required." );
}

$event_id = (int) $_POST['event_id'];


$eventQuery = "SELECT name FROM events WHERE id = ?";
$stmt = $conn->prepare( $eventQuery );
$stmt->bind_param( "i", $event_id );
$stmt->execute();
$eventResult = $stmt->get_result();

if ( $eventResult->num_rows === 0 ) {
    die( "The event does not exist." );
}

$event = $eventResult->fetch_assoc();
$event_name = $event['name'];

$attendeeQuery = "SELECT u.username AS attendee_name, u.email AS attendee_email
                  FROM attendees a
                  JOIN users u ON a.user_id = u.id
                  WHERE a.event_id = ?";
$stmt = $conn->prepare( $attendeeQuery );
$stmt->bind_param( "i", $event_id );
$stmt->execute();
$attendeeResult = $stmt->get_result();

if ( $attendeeResult->num_rows === 0 ) {
    die( "No attendees found for this event." );
}

$formatted_name = strtolower(str_replace(' ', '_', $event_name));

header( 'Content-Type: text/csv' );
header( 'Content-Disposition: attachment; filename="attendees_' . $formatted_name . '.csv"' );

$output = fopen( 'php://output', 'w' );
fputcsv( $output, ['Name', 'Email'] ); // CSV headers

while ( $attendee = $attendeeResult->fetch_assoc() ) {
    fputcsv( $output, [$attendee['attendee_name'], $attendee['attendee_email']] );
}

fclose( $output );
$stmt->close();
$conn->close();
exit;