<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="main">
        <div class="content">
            <form method="POST" action="upload" enctype="multipart/form-data">
                <input type="file" name="fileUp">
                <br>
                <input class="finalButton" type="submit" value="Upload">
            </form>
            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo $desc; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
