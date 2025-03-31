<?php
include('session.php');
include('config.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: student_dashboard.php?message=Unauthorized access");
    exit();
}

// Fetch all QR codes from the database
$sql = "SELECT * FROM qr_codes ORDER BY created_at DESC";
$result = mysqli_query($link, $sql);

// Format datetime for display
function formatDateTime($timestamp) {
    return date('M d, Y h:i A', strtotime($timestamp));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes Overview</title>
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
            min-height: 100vh;
            padding: 20px 0;
            font-family: Montserrat, sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        h1, h2 {
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            background-color: white;
        }

        .back-btn {
            margin-top: 20px;
        }

        .expired {
            background-color: #ffeeee;
        }
        
        .qr-code-container {
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        
        .qr-code-container canvas {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <img class="animate__animated animate__fadeInDown" src="img/pwu_logo.png" width="75px" alt="PWU Logo">
            <h1 class="animate__animated animate__fadeIn">QR Codes Overview</h1>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>QR Image</th>
                            <th>QR Code</th>
                            <th>Booth Name</th>
                            <th>Description</th>
                            <th>Points</th>
                            <th>Expiration</th>
                            <th>Created</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): 
                            $expired = strtotime($row['expiration_time']) < time();
                            $rowClass = $expired ? 'expired' : '';
                            $qrId = 'qr-' . $row['id'];
                        ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td>
                                    <div id="<?php echo $qrId; ?>" class="qr-code-container"></div>
                                </td>
                                <td><?php echo htmlspecialchars($row['unique_text']); ?></td>
                                <td><?php echo htmlspecialchars($row['booth_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo $row['points']; ?></td>
                                <td><?php echo formatDateTime($row['expiration_time']); ?></td>
                                <td><?php echo formatDateTime($row['created_at']); ?></td>
                                <td>
                                    <?php if($expired): ?>
                                        <span class="badge bg-danger">Expired</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No QR codes found in the database.</div>
        <?php endif; ?>

        <div class="text-center back-btn">
            <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            <a href="create_qr_code.php" class="btn btn-danger">Create New QR Code</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qr-creator/dist/qr-creator.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all QR code data from the table
            const qrData = [
                <?php 
                // Reset the result pointer to the beginning
                mysqli_data_seek($result, 0);
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                {
                    id: 'qr-<?php echo $row['id']; ?>',
                    text: '<?php echo addslashes($row['unique_text']); ?>'
                },
                <?php endwhile; ?>
            ];
            
            // Generate all QR codes
            qrData.forEach(function(qr) {
                const container = document.getElementById(qr.id);
                if (container) {
                    QrCreator.render({
                        text: qr.text,
                        radius: 0,
                        ecLevel: "L",
                        background: "#fff",
                        size: 120
                    }, container);
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
