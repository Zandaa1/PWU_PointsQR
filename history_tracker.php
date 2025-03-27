<<<<<<< HEAD
<?php
include('session.php');
include('config.php');

// Fetch scan history from the database
$user_id = $_SESSION['id'];
$sql = "SELECT sh.scan_time, sh.points_added, 
        COALESCE(qc.booth_name, 'Claim Points') AS booth_name, 
        sh.description 
        FROM scan_history sh
        LEFT JOIN qr_codes qc ON sh.qr_code_id = qc.id
        WHERE sh.user_id = '$user_id'
        ORDER BY sh.scan_time DESC";
$result = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Tracker</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start; /* Align items at the top */
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
            max-width: 800px; /* Increased max-width for better readability */
            text-align: center;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            margin-top: 20px;
        }

        .btn {
            width: auto; /* Adjusted width to auto */
            margin-bottom: 10px;
        }

        .history-table {
            width: 100%;
            color: white;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .history-table th, .history-table td {
            border: 1px solid white;
            padding: 8px;
            text-align: left;
        }

        .history-table th {
            background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent background */
        }

        /* Media query for mobile devices */
        @media (max-width: 768px) {
            .main-page {
                width: 95%;
            }

            .history-table th, .history-table td {
                padding: 6px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container main-page">
        <a href="student_dashboard.php" class="btn btn-light btn-sm" style="position: absolute; top: 20px; left: 20px; width: auto;">Back</a>
        <h1>History Tracker</h1>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Scan Time</th>
                    <th>Booth Name</th>
                    <th>Description</th>
                    <th>Points Added</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['scan_time'] . "</td>";
                        echo "<td>" . $row['booth_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['points_added'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
=======
<?php
include('session.php');
include('config.php');

// Fetch scan history from the database
$user_id = $_SESSION['id'];
$sql = "SELECT sh.scan_time, sh.points_added, 
        COALESCE(qc.booth_name, 'Claim Points') AS booth_name, 
        sh.description 
        FROM scan_history sh
        LEFT JOIN qr_codes qc ON sh.qr_code_id = qc.id
        WHERE sh.user_id = '$user_id'
        ORDER BY sh.scan_time DESC";
$result = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Tracker</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start; /* Align items at the top */
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
            max-width: 800px; /* Increased max-width for better readability */
            text-align: center;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            margin-top: 20px;
        }

        .btn {
            width: auto; /* Adjusted width to auto */
            margin-bottom: 10px;
        }

        .history-table {
            width: 100%;
            color: white;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .history-table th, .history-table td {
            border: 1px solid white;
            padding: 8px;
            text-align: left;
        }

        .history-table th {
            background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent background */
        }

        /* Media query for mobile devices */
        @media (max-width: 768px) {
            .main-page {
                width: 95%;
            }

            .history-table th, .history-table td {
                padding: 6px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container main-page">
        <a href="student_dashboard.php" class="btn btn-light btn-sm" style="position: absolute; top: 20px; left: 20px; width: auto;">Back</a>
        <h1>History Tracker</h1>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Scan Time</th>
                    <th>Booth Name</th>
                    <th>Description</th>
                    <th>Points Added</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['scan_time'] . "</td>";
                        echo "<td>" . $row['booth_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['points_added'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
>>>>>>> 5d788cbc96d3c2ba7cdc639f31545429c816a353
