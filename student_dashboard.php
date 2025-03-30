<?php
include('session.php');
include('config.php');

// Fetch current points from the database
$user_id = $_SESSION['id'];
$sql = "SELECT points FROM users WHERE id = '$user_id'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$current_points = $row['points'] ? $row['points'] : 0;

// Check if the user is an admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-image: url(img/pwu_bg.jpg);
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

        /* Redesigned Points Display */
        .points-display {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .points-display p {
            font-size: 1.8em;
            font-weight: bold;
            color: white; /* Gold color for points */
            margin: 0;
        }

        .points-display span {
            font-size: 1.2em;
            color: white;
            
        }
    </style>
</head>
<body>
    <div class="container main-page">
        <img class="animate__animated animate__fadeInDown" src="img/pwu_logo.png" width="75px" alt="" srcset="">
        <h1 class="animate__animated animate__fadeIn">PWU Points Dashboard</h1>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        <div class="button-container">
            <!-- Redesigned Points Display -->
            <div class="points-display">
                <p><?php echo $current_points; ?> Points</p>
            </div>
            <a href="scan_qr_code.php" class="btn btn-danger">Scan QR Code</a>
            <a href="historytracker.php" class="btn btn-danger">History Tracker</a>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#claimPointsModal">Claim Points</a>
            <?php if ($is_admin): ?>
                <a href="create_qr_code.php" class="btn btn-danger">! Create QR Code !</a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-light btn-sm" style="margin-top: 20px;">Logout</a>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="claimPointsModal" tabindex="-1" aria-labelledby="claimPointsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="claimPointsModalLabel">Confirm Points Reset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">
                        WARNING: This action will reset all your points to 0.<br>
                        This should only be done at the claiming booth.<br><br>
                        Are you sure you want to proceed?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="wipe_points.php" class="btn btn-danger">Confirm</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
