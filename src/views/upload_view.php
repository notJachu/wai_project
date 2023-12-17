<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="main">
        <div class="content">
            <form>
                <input type="file" name="file">
                <br>
                <input class="finalButton" type="submit" value="Upload">
            </form>
            <?php if(isset($model['error'])): ?>
                <div class="error">
                    <?php echo $model['desc']; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
