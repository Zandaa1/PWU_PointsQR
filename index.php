<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWU Points Tracker BETA</title>
    <link rel="manifest" crossorigin="use-credentials" href="manifest.json" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/philfung/add-to-homescreen@3.2/dist/add-to-homescreen.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/philfung/add-to-homescreen@3.2/dist/add-to-homescreen.min.js"></script>

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

        p {
            font-family: Montserrat;
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

        <img src="img/pwu_logo.png" width="75px" alt=""
            style="animation-delay: 500ms;"
            class="animate__animated animate__fadeInDown">


        <p class="animate__animated animate__fadeIn">Welcome to</p>

        <h1 class="animate__animated animate__zoomIn">PWU Points Tracker</h1>


        <div class="button-container">
            <a href="login_revamped.php" class="btn btn-danger">
                Guest Login
            </a>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.AddToHomeScreenInstance = window.AddToHomeScreen({
                appName: 'PWU Points App', // Name of the app.
                // Required.
                appNameDisplay: 'standalone', // If set to 'standalone' (the default), the app name will be diplayed
                // on it's own, beneath the "Install App" header. If set to 'inline', the
                // app name will be displayed on a single line like "Install MyApp"
                // Optional. Default 'standalone'
                appIconUrl: 'img/pwu_logo.png', // App icon link (square, at least 40 x 40 pixels).
                // Required.
                assetUrl: 'img/', // Link to directory of library image assets.

                maxModalDisplayCount: -1, // If set, the modal will only show this many times.
                // [Optional] Default: -1 (no limit).  (Debugging: Use this.clearModalDisplayCount() to reset the count)
                displayOptions: {
                    showMobile: true,
                    showDesktop: true
                }, // show on mobile/desktop [Optional] Default: show everywhere
                allowClose: true, // allow the user to close the modal by tapping outside of it [Optional. Default: true]
                showArrow: true, // show the bouncing arrow on the modal [Optional. Default: true] (highly recommend leaving at true as drastically affects install rates)
            });

            ret = window.AddToHomeScreenInstance.show('en'); // show "add-to-homescreen" instructions to user, or do nothing if already added to homescreen
            // [optional] language.  If left blank, then language is auto-decided from (1) URL param locale='..' (e.g. /?locale=es) (2) Browser language settings
        });
    </script>
</body>
</body>

</html>