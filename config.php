<?php
// Detect if the script is running on localhost
$is_localhost = ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1');

if ($is_localhost) {
    // Localhost XAMPP settings
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'dbqrscan');
} else {
    // Hosting provider settings
    define('DB_SERVER', 'sql306.infinityfree.com'); // Replace with your hosting DB server
    define('DB_USERNAME', 'if0_38622671'); // Replace with your hosting DB username
    define('DB_PASSWORD', 'ko4peitdWr'); // Replace with your hosting DB password
    define('DB_NAME', 'if0_38622671_dbqrscan'); // Replace with your hosting DB name
}

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>