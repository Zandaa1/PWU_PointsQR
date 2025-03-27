<?php
// filepath: c:\xampp\htdocs\points\claim_points.php
include('session.php');
include('config.php');

$message = '';

// Check if qr_code with unique_text 'Claim Points' exists, if not create it
$check_qr_code_sql = "SELECT * FROM qr_codes WHERE unique_text = 'Claim Points'";
$check_qr_code_result = mysqli_query($link, $check_qr_code_sql);

if (!$check_qr_code_result || mysqli_num_rows($check_qr_code_result) == 0) {
    // QR code with unique_text 'Claim Points' doesn't exist, create it
    $create_qr_code_sql = "INSERT INTO qr_codes (unique_text, booth_name, description, points, expiration_time) VALUES ('Claim Points', 'Claim Points', 'Claim Points', 0, NOW())";
    mysqli_query($link, $create_qr_code_sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $points_to_deduct = isset($_POST['points_to_deduct']) ? intval($_POST['points_to_deduct']) : 0;
    $description = mysqli_real_escape_string($link, $_POST['description']);

    if ($points_to_deduct <= 0) {
        $message = "Please enter a valid number of points to deduct.";
    } else {
        // Fetch current points from the database
        $user_id = $_SESSION['id'];
        $sql_points = "SELECT points FROM users WHERE id = '$user_id'";
        $result_points = mysqli_query($link, $sql_points);
        $row_points = mysqli_fetch_assoc($result_points);
        $current_points = $row_points['points'];

        if ($points_to_deduct > $current_points) {
            $message = "You don't have enough points to deduct.";
        } else {
            // Deduct points from the user's account
            $new_points = $current_points - $points_to_deduct;
            $update_sql = "UPDATE users SET points = '$new_points' WHERE id = '$user_id'";

            if (mysqli_query($link, $update_sql)) {
                // Record the deduction in the scan_history table
                $deduction_sql = "INSERT INTO scan_history (user_id, qr_code_id, points_added, description) VALUES ('$user_id', '0', '-$points_to_deduct', '$description')";
                if (mysqli_query($link, $deduction_sql)) {
                    $message = "Successfully deducted " . $points_to_deduct . " points. New balance: " . $new_points;
                } else {
                    $message = "Error recording deduction: " . mysqli_error($link);
                }
            } else {
                $message = "Error deducting points: " . mysqli_error($link);
            }
        }
    }
}

// Fetch current points after deduction
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
    <title>Claim Points</title>
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
            max-width: 600px;
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
        <h1>Claim Points</h1>
        <div class="alert alert-danger" role="alert">
            You should only claim points if you are at the claiming area booth.
        </div>
        <form method="post" action="">
            <div class="mb-3">
                <label for="points_to_deduct" class="form-label">Points to Deduct</label>
                <input type="number" class="form-control" id="points_to_deduct" name="points_to_deduct" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <button type="submit" class="btn btn-danger">Deduct Points</button>
            <?php if ($message) { ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <p id="currentPoints" style="color: white; font-size: 1.2em;">Current Points: <?php echo $current_points; ?></p>
        </form>
        <div class="button-container">
            <a href="student_dashboard.php" class="btn btn-light btn-sm" style="margin-top: 20px;">Back to Dashboard</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>