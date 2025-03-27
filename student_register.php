<?php
include("config.php");
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $role = mysqli_real_escape_string($link, $_POST['role']);

    // Check if the username already exists
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error = "ID already exists. Please contact the administrator.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, password, role, points) VALUES ('$username', '$password', '$role', 0)";
        if (mysqli_query($link, $sql)) {
            $_SESSION['login_user'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = mysqli_insert_id($link);
            header("location: student_dashboard.php");
            exit(); // Ensure that script stops execution after redirect
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student/Faculty Registration</title>
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
        <a href="index.php" class="btn btn-light btn-sm" style="position: absolute; top: 20px; left: 20px; width: auto;">Back</a>
        <h1>Student/Faculty Registration</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="registerId" class="form-label">ID</label>
                <input type="text" class="form-control" id="registerId" name="username" required>
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="registerPassword" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger" name="register">Register</button>
             <?php if ($error) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
        </form>
        <div class="button-container">
            <p>Already have an account? <a href="student_login.php" class="btn btn-link">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
