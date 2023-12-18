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
                <input type="file" name="fileUp" required>
                <br>
                <label for="watermark">Watermark</label>
                <input type="text" name="watermark" id="water" required> <br>
                <label for="author">Author</label>
                <input type="text" name="author" id="author" required 
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php echo 'value="' . $_SESSION['user_name'] . '"' ?>
                    <?php endif; ?>
                > <br>
                <div <?php if(!isset($_SESSION['user_id'])): ?>
                    <?php echo 'style="display: none;"' ?>
                <?php endif; ?>
                >
                    <input type="radio" name="private" id="pub" value="false" checked>
                    <label for="pub">Public</label> <br>
                    <input type="radio" name="private" id="prv" value="true">
                    <label for="prv">Private</label> <br>

                </div>
                
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
