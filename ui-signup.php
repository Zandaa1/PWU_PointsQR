<?php
include("config.php");
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $nickname = mysqli_real_escape_string($link, $_POST['nickname']);
    $isStudent = mysqli_real_escape_string($link, $_POST['isStudent']);

    // Check if the username already exists
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, password, name, nickname, isStudent) VALUES ('$username', '$password', '$name', '$nickname', '$isStudent')";
        if (mysqli_query($link, $sql)) {
            $_SESSION['login_user'] = $username;
            $_SESSION['isStudent'] = $isStudent;
            $_SESSION['nickname'] = $nickname;
            $_SESSION['id'] = mysqli_insert_id($link);
            header("location: ui-classroom-v2.php");
        } else {
            $error = "Error: " . $sql . "<br>" . mysqli_error($link);
        }
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/f59bcd8580.js"></script>
    <style>
        body {
            background-color: #ffffff;
            min-height: 100vh;
        }

        .login-container {
            max-width: 400px;
        }

        .custom-blue {
            background-color: #1a237e;
        }

        .btn-custom-blue {
            background-color: #1a237e;
            color: white;
        }

        .btn-custom-blue:hover {
            background-color: #0d1757;
            color: white;
        }

        .login-image {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-style input {
            border: 0;
            height: 50px;
            border-radius: 0;
            border-bottom: 1px solid #ebebeb;
        }

        .form-style input:focus {
            border-bottom: 1px solid #007bff;
            box-shadow: none;
            outline: 0;
            background-color: #ebebeb;
        }

        .sideline {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #ccc;
        }

        .sideline:before,
        .sideline:after {
            content: '';
            border-top: 1px solid #ebebeb;
            margin: 0 20px 0 0;
            flex: 1 0 20px;
        }

        .sideline:after {
            margin: 0 0 0 20px;
        }

        button {
            height: 50px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    <div class="container">
        <div class="row m-5 no-gutters shadow-lg">
            <div class="col-md-6 d-none d-md-block">
                <img src="img/pwu.jpg" alt="Signup Image" class="img-fluid login-image" />
            </div>
            <div class="col-md-6 bg-white p-5">
                <h3 class="pb-3">Create Your Account</h3>
                <div class="form-style">
                    <form action="" method="post">
                        <div class="form-group pb-3">
                            <input type="text" placeholder="School ID" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group pb-3">
                            <input type="password" placeholder="Password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group pb-3">
                            <input type="text" placeholder="Full Name" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group pb-3">
                            <input type="text" placeholder="Nickname" class="form-control" id="nickname" name="nickname" required>
                        </div>
                        <div class="form-group pb-3">
                            <select class="form-control" id="isStudent" name="isStudent" required>
                                <option value="1">Student</option>
                                <!-- <option value="0">Teacher</option> !-->
                            </select>
                        </div>
                        <div class="pb-2">
                            <button type="submit" class="btn btn-dark w-100 font-weight-bold mt-2">Sign Up</button>
                        </div>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger mt-3"> <svg class="bi flex-shrink-0 me-2" width="24" height="24" fill="red">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg><?php echo $error; ?></div>
                        <?php } ?>
                    </form>
                    <div class="pt-4 text-center">
                        Already have an account? <a href="index.php">Login</a>
                    </div>
                    <div class="text-center">
                        <small class="text-center mt-3">
                            v2.28   .2025
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>