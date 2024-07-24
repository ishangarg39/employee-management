<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form action="signup_process.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
                <!-- Display error message for username -->
                <span class="text-danger"><?php echo isset($username_err) ? $username_err : ''; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <!-- Display error message for password -->
                <span class="text-danger"><?php echo isset($password_err) ? $password_err : ''; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
