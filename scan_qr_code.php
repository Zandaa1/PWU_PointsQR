<?php
include('session.php');
include('config.php');

$scan_result = '';
$current_points = 0; // Initialize current_points

// Fetch current points from the database
$user_id = $_SESSION['id'];
$sql_points = "SELECT points FROM users WHERE id = '$user_id'";
$result_points = mysqli_query($link, $sql_points);
if ($result_points && mysqli_num_rows($result_points) > 0) {
    $row_points = mysqli_fetch_assoc($result_points);
    $current_points = $row_points['points'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_text = mysqli_real_escape_string($link, $_POST['unique_text']);

    // Fetch QR code details from the database
    $sql = "SELECT * FROM qr_codes WHERE unique_text = '$unique_text'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $qr_code = mysqli_fetch_assoc($result);

        // Check if the QR code has expired
        if (strtotime($qr_code['expiration_time']) < time()) {
            $scan_result = "This QR code has expired.";
        } else {
            // Check if the user has already scanned this QR code
            $check_sql = "SELECT * FROM scan_history WHERE user_id = '$user_id' AND qr_code_id = '" . $qr_code['id'] . "'";
            $check_result = mysqli_query($link, $check_sql);

            if (mysqli_num_rows($check_result) > 0) {
                $scan_result = "You have already claimed points from this QR code.";
            } else {
                $points_to_add = $qr_code['points'];
                $qr_code_id = $qr_code['id'];

                // Add points to the user's scan history
                $insert_sql = "INSERT INTO scan_history (user_id, qr_code_id, points_added) VALUES ('$user_id', '$qr_code_id', '$points_to_add')";
                if (mysqli_query($link, $insert_sql)) {
                    // Update the user's points in the users table
                    $update_sql = "UPDATE users SET points = points + $points_to_add WHERE id = '$user_id'";
                    if (mysqli_query($link, $update_sql)) {
                        $scan_result = "Successfully added " . $points_to_add . " points!";

                        // Fetch updated points
                        $sql_updated_points = "SELECT points FROM users WHERE id = '$user_id'";
                        $result_updated_points = mysqli_query($link, $sql_updated_points);
                        if ($result_updated_points && mysqli_num_rows($result_updated_points) > 0) {
                            $row_updated_points = mysqli_fetch_assoc($result_updated_points);
                            $current_points = $row_updated_points['points'];
                        }

                    } else {
                        $scan_result = "Error updating user points: " . mysqli_error($link);
                    }
                } else {
                    $scan_result = "Error adding points: " . mysqli_error($link);
                }
            }
        }
    } else {
        $scan_result = "Invalid QR code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
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

        h1,
        p {
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
        <a href="student_dashboard.php" class="btn btn-light btn-sm"
            style="position: absolute; top: 20px; left: 20px; width: auto;">Back</a>
        <h1>Scan QR Code</h1>
        <div class="button-container">
            <p id="currentPoints" style="color: white; font-size: 1.5em;">Current Points: <?php echo $current_points; ?></p>
            <div id="qr-reader"></div>
            <div id="qr-reader-results">
                <?php if ($scan_result) { ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $scan_result; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="html5-qrcode.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                // Send the decoded text to the server using a hidden form
                var form = document.createElement('form');
                form.method = 'post';
                form.action = ''; // Current page
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'unique_text';
                input.value = decodedText;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            console.warn(`Code scan error = ${error}`);
        }

    </script>

</body>

</html>