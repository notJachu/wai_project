<?php
include_once '../business.php';
    if ($isPrivate){
        if (isset($_SESSION['user_id'])){
            if ($user != $_SESSION['user_id']){
                header('HTTP/1.0 403 Forbidden');
                exit;
            }
        } else{
            header('HTTP/1.0 403 Forbidden');
            exit;
        }
    }
    $img = file_get_contents('../web/images/' . $name);

    
    $extension = pathinfo($img, PATHINFO_EXTENSION);
    if ($extension == 'jpg' || $extension == 'jpeg')
        header('Content-Type: image/jpeg');
    else if ($extension == 'png')
        header('Content-Type: image/png');
    
    echo $img;
    //print_r($img);
?>

