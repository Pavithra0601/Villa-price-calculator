<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
        /* Custom CSS styles can be added here */
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="image/spe.png" class="logo" alt="Logo">
            <p class="header-text blinking-text" style="font-family: cursive; font-size: 35px">
                Project Cost Calculator - Admin Login
            </p>
        </div>
    </header>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="login-container">
                    <br><br>
                    <form action="loginprocess.php" method="post">
                        <div class="form-group">
                            <label for="userid">Enter Admin User ID:</label>
                            <input type="text" class="form-control" name="userid" id="userid" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Enter Password:</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Enter">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
