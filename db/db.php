<?php

include 'config.php';

$conn = new mysqli( DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME );

// Check the connection
if ( $conn->connect_error ) {
    die( "Connection failed: " . $conn->connect_error );
} 
// else {
//     echo "Database Connected!";
// }