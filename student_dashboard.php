<?php
include('session.php');
include('config.php');

// Fetch current points from the database
$user_id = $_SESSION['id'];
$sql = "SELECT points FROM users WHERE id = '$user_id'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$current_points = $row['points'] ? $row['points'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-image: url(pwu_bg.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1, p {
            color: white;
            text-align: center;
            margin: 0;
        }

        h1 {
            font-family: Montserrat, sans-serif;
            font-weight: 600;
        }

        .main-page {
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .button-container {
            margin-top: 20px;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container main-page">
        <h1>Student Dashboard</h1>
        <div class="button-container">
            <p id="currentPoints" style="color: white; font-size: 1.5em;">Current Points: <?php echo $current_points; ?></p>
            <a href="scan_qr_code.php" class="btn btn-danger">Scan QR Code</a>
            <a href="history_tracker.php" class="btn btn-danger">History Tracker</a>
            <a href="#" class="btn btn-danger">Claim Points</a>
            <a href="create_qr_code.php" class="btn btn-danger">! Create QR Code !</a>
            <a href="index.php" class="btn btn-light btn-sm" style="margin-top: 20px;">Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Example script to fetch and display current points
        document.addEventListener('DOMContentLoaded', function() {
            // Replace with actual logic to fetch points
            //const points = 100; // Example points
            //document.getElementById('currentPoints').textContent = `Current Points: ${points}`;
        });
    </script>
</body>
</html>
