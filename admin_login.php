<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        <h1>Admin Login</h1>
        <form method="post" action="connect.php">
            <div class="mb-3">
                <label for="adminId" class="form-label">ID</label>
                <input type="text" class="form-control" id="adminId" name="username" required>
            </div>
            <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="adminPassword" name="password" required>
            </div>
            <input type="hidden" name="role" value="admin">
            <button type="submit" class="btn btn-danger" name="login">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
