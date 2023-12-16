<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <title>LogIn</title>
</head>
<body>
    <div class="main">
        <div class="content">
            <form action="login" method="POST">
                <label for="user">Username</label>
                <input type="text" name="user" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" required><br>
                <input type="submit" value="Sign in" class="finalButton">
                <a href="signup">No account? Sign up.</a>
            </form>
            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>