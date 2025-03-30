<?php
include("config.php");
session_start();
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $sql_check = "SELECT * FROM users WHERE username = '$username'";
        $result_check = mysqli_query($link, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Username already exists!";
        } else {
            // Store the password as plain text (not recommended)
            $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

            if (mysqli_query($link, $sql_insert)) {
                $success = "Account created successfully! You can now <a href='login_revamped.php'>login</a>.";
            } else {
                $error = "Error creating account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWU Signup</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>    <style>
        /* Reuse the same styles from login_revamped.php */Reuse the same styles from login_revamped.php */
        body {
            display: flex;splay: flex;
            justify-content: center;t: center;
            align-items: center;
            min-height: 100vh;
            background: url('img/pwu_bg.jpg') no-repeat;mg/pwu_bg.jpg') no-repeat;
            background-size: cover;
            background-position: center;nter;
        }

        .wrapper {        .wrapper {
            width: 420px; 420px;
            background: maroon;aroon;
            border: 2px solid rgba(255, 255, 255, .2);gba(255, 255, 255, .2);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: #fff;
            border-radius: 10px;s: 10px;
            padding: 30px 40px;
        }

        .wrapper h1 {        .wrapper h1 {
            font-size: 36px;: 36px;
            text-align: center;er;
        }

        .wrapper .input-box {        .wrapper .input-box {
            position: relative;e;
            width: 100%;
            height: 50px;;
            margin: 30px 0;0;
        }

        .input-box input {        .input-box input {
            width: 100%;
            height: 100%;;
            background: transparent;ransparent;
            border: 2px solid rgba(255, 255, 255, .2);55, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            padding: 10px 50px 10px 20px;px 10px 20px;
            color: #fff;
            outline: none;e;
        }

        .input-box input::placeholder {        .input-box input::placeholder {
            color: #fff;
        }

        .input-box i {        .input-box i {
            position: absolute;absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);: translateY(-50%);
            font-size: 20px;
        }

        .wrapper .btn {        .wrapper .btn {
            width: 100%;;
            height: 45px;;
            background: #fff;fff;
            border: none;
            outline: none;;
            border-radius: 40px; 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1); rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600; 600;
        }

        .wrapper .login-link {        .wrapper .login-link {
            font-size: 14.5px;
            text-align: center;;
            margin-top: 20px 0 15px;15px;
        }

        .login-link p a {        .login-link p a {
            color: #fff;
            text-decoration: none;ion: none;
            font-weight: 600;
        }

        .login-link p a:hover {        .login-link p a:hover {
            text-decoration: underline;derline;
        }
    </style>le>
</head>

<body><body>
    <div class="wrapper">iv class="wrapper">
        <form method="POST" action="">T" action="">
            <h1>Signup</h1>
            <div class="input-box">ut-box">
                <input type="text" placeholder="Username" name="username" id="username" required>placeholder="Username" name="username" id="username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">            <div class="input-box">
                <input type="password" placeholder="Password" name="password" id="password" required>rd" placeholder="Password" name="password" id="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required>rd" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button id="submit" type="submit" name="signup" class="btn">Signup</button>            <button id="submit" type="submit" name="signup" class="btn">Signup</button>

            <div class="login-link">            <div class="login-link">
                <p>Already have an account? <a href="login_revamped.php">Login</a></p>ccount? <a href="login_revamped.php">Login</a></p>
            </div>
        </form>

        <?php if ($error) { ?>        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert">alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <?php if ($success) { ?>        <?php if ($success) { ?>
            <div class="alert alert-success" role="alert">ert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>