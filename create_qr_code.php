<?php
include('session.php');
include("config.php");
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_text = mysqli_real_escape_string($link, $_POST['unique_text']);
    $booth_name = mysqli_real_escape_string($link, $_POST['booth_name']);
    $description = mysqli_real_escape_string($link, $_POST['description']);
    $points = mysqli_real_escape_string($link, $_POST['points']);
    $expiration_time = mysqli_real_escape_string($link, $_POST['expiration_time']);

    // Check for duplicate unique_text
    $check_sql = "SELECT * FROM qr_codes WHERE unique_text = '$unique_text'";
    $result = mysqli_query($link, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        $error = "Error: A QR code with this unique text already exists.";
    } else {
        // Insert the new QR code into the database
        $sql = "INSERT INTO qr_codes (unique_text, booth_name, description, points, expiration_time) VALUES ('$unique_text', '$booth_name', '$description', '$points', '$expiration_time')";
        if (mysqli_query($link, $sql)) {
            $success_message = "QR Code created successfully!";
        } else {
            $error = "Error: " . $sql . "<br>" . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
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

        h1, p, label {
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
            max-width: 900px;
            text-align: center;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        #q {
            margin: auto;
            width: 100%;
            padding: 5px;
        }

        #q canvas {
            margin: auto;
            display: block;
        }

        .qr-container {
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container main-page">
        <h1>Create QR Code</h1>
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-6">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="unique_text" class="form-label">Unique Text</label>
                        <input type="text" class="form-control" id="unique_text" name="unique_text" oninput="generateQRCode()" required>
                    </div>
                    <div class="mb-3">
                        <label for="booth_name" class="form-label">Booth Name</label>
                        <input type="text" class="form-control" id="booth_name" name="booth_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Points</label>
                        <input type="number" class="form-control" id="points" name="points" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiration_time" class="form-label">Expiration Time</label>
                        <input type="datetime-local" class="form-control" id="expiration_time" name="expiration_time" required>
                    </div>
                   
                    <button type="submit" class="btn btn-danger" name="create">Create QR Code</button>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($success_message)) { ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php } ?>
                </form>
                <div class="button-container">
                    <a href="student_dashboard.php" class="btn btn-light btn-sm" style="margin-top: 20px;">Back to Dashboard</a>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="col-md-6">
                <div id="q" class="qr-container"></div>
                <p class="text-white mt-3">Right-click on the QR code to save it.</p>
                <div class="alert alert-warning">
                        Please save the QR code image before clicking "Create QR Code."
                    </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qr-creator/dist/qr-creator.min.js"></script>
    <script>
        function generateQRCode() {
            const q = document.getElementById("q");
            const uniqueText = document.getElementById("unique_text").value;
            const maxLength = 2950;

            if (uniqueText.length > maxLength) {
                alert(`Text is ${uniqueText.length - maxLength} characters too long.`);
                return;
            }

            q.innerHTML = ""; // Clear previous QR code
            try {
                QrCreator.render({
                    text: uniqueText,
                    radius: 0,
                    ecLevel: "L",
                    background: "#fff",
                    size: 250, // Fixed size for better alignment
                }, q);
            } catch (e) {
                alert("Failed to generate QR code");
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
