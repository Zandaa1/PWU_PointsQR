<?php
include('session.php');
include('config.php');

// Fetch the current user's ID
$user_id = $_SESSION['id'];

// Reset the user's points to 0
$reset_points_sql = "UPDATE users SET points = 0 WHERE id = '$user_id'";
if (mysqli_query($link, $reset_points_sql)) {
    // Redirect back to the dashboard with a success message
    header("Location: student_dashboard.php?message=Points successfully reset to 0.");
    exit();
} else {
    // Redirect back to the dashboard with an error message
    header("Location: student_dashboard.php?message=Error resetting points: " . mysqli_error($link));
    exit();
}
?>