<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="gallery.css">
</head>
<body>
    <div class="main">
            
        <nav class="menu">
            <ul id="bar">
               <li><a href="index.html">Home Page</a></li>
               <li><a href="#">Gallery</a></li>
               <li><a href="form.html">Form</a></li>
               <?php if(isset($_SESSION['user_id'])): $user = $_SESSION['user_name']; ?>
                    <li>Hi, <?php echo $user ?></li>
                <?php endif; ?>
                <li id="log">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="logout">
                        <?php
                        echo("Log out");
                        ?>
                        </a>
                    <?php else: ?>
                        <a href="login">
                        <?php
                        echo("Log in");
                        ?>
                        </a>
                    <?php endif; ?>
                </li>
             </ul>
       </nav>
       
       <div class="content">
            <div id="gallery">
                
                    </defs>
                </svg>
                <div id="title">
                    <h1>A gallery of AI generated images</h1>
                    <a href="https://www.craiyon.com" target="_blank"><img id="logo" src="../resources/photo-ai.svg" alt="gallery logo"></a>
                </div>
                <div id="display">
                    <div class="card">
                     <a href="./resources/photo1.png" target="_blank"><img src="./resources/photo1.png" alt="image of a guitar"></a>
                    </div>
                   <?php foreach($images as $image): ?>
                        <div class="card">
                            <img src="./images/<?php echo $image['path'] ?>" alt="asdasdas">
                        </div>
                    <?php endforeach; ?>
                    <?php print_r($images) ?>
                </div>
            </div>
            <div class="break"></div>
            <a id="upl" href="upload">Your photo not here? Upload it!</a>
       </div>
       <footer>
        AUTHOR - JAN STĄSIEK
    </footer>
    </div>
</body>
</html>