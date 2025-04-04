<?php
include("config.php");
session_start();
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $sql_check = "SELECT * FROM users WHERE username = '$username'";
        $result_check = mysqli_query($link, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Username already exists!";
        } else {
            // Store the password as plain text (not recommended)
            // Store the password as plain text (not recommended for security reasons)
            $sql_insert = "INSERT INTO users (username, password, name, email) VALUES ('$username', '$password', '$name', '$email')";

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('img/pwu_bg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 420px;
            background: maroon;
            border: 2px solid rgba(255, 255, 255, .2);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .wrapper .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            padding: 10px 50px 10px 20px;
            color: #fff;
            outline: none;
        }

        .input-box input::placeholder {
            color: #fff;
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .wrapper .login-link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;
        }

        .login-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link p a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .wrapper {
                width: 90%;
                padding: 20px;
            }

            .wrapper h1 {
                font-size: 28px;
            }

            .input-box input {
                font-size: 14px;
                padding: 10px 40px 10px 15px;
            }

            .input-box i {
                font-size: 18px;
                right: 15px;
            }

            .wrapper .btn {
                height: 40px;
                font-size: 14px;
            }

            .wrapper .login-link {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="">
            <h1>Signup</h1>
            <div class="input-box">
                <input type="text" placeholder="Name" name="name" id="name" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="email" placeholder="Email" name="email" id="email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="text" placeholder="Username" name="username" id="username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" id="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button id="submit" type="submit" name="signup" class="btn">Signup</button>

            <div class="login-link">
                <p>Already have an account? <a href="login_revamped.php">Login</a></p>
            </div>
        </form>

        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <?php if ($success) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>