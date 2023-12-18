<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <title>Sign up</title>
</head>
<body>
    <div class="main">
        <div class="content">
            <form action="signup" method="POST">
                <label for="mail">E-mail</label>
                <input type="text" name="mial" required><br>
                <label for="user">Username</label>
                <input type="text" name="user" required><br>
                <label for="password">Password</label>
                <input type="password" name="password" required><br>
                <label for="password_repeat">Repeat password</label>
                <input type="password" name="password_repeat" required><br>
                <input type="submit" value="Sign in" class="finalButton">
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