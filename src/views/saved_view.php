<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved</title>
    <link rel="stylesheet" href="card.css">
</head>
<body>
<div class="main">
        <div class="content">
            <?php print_r($images) ?>
            <?php print_r($file) ?>
            <?php foreach($images as $image): ?>
                <div class="card">
                    <a href="./card?img=<?php echo $image['name'] ?>">
                        <img src="./images/<?php echo $image['path'] ?>" alt="asdasdas">
                    </a> <br>
                    <label>Save
                        <input type="checkbox" name="images[]" value="<?php echo $image['id'] ?>" 
                        <?php if (in_array($image['id'], $_SESSION['saved']) ) :?>

                            <?php echo 'checked' ?>
                        <?php endif; ?>
                        >
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>