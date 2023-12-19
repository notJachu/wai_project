<?php
use MongoDB\BSON\ObjectID;
require_once __DIR__ . '../../vendor/autoload.php';

define('MB', 1048576);
define("PAGE_SIZE", 15);

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]
    );
    $db = $mongo->wai;
    return $db;
}


function remove_files(){
    $db = get_db();
    $db->files->deleteMany([]);
}

function remove_users(){
    $db = get_db();
    $db->users->deleteMany([]);
}

function is_name_taken($user){
    $db = get_db();
    $res = $db->users->findOne(['login' => $user]);
    if($res){
        return true;
    }
    return false;
}

function register_user($user, $hash){
    $db = get_db();
    $db->users->insertOne([
        'login'=>$user,
        'hash'=>$hash,
        'mail'=>$_POST['mail']
    ]);
}

function get_user($user) {
    $db = get_db();
    $res = $db->users->findOne(['login' => $user]);
    return $res;
}


function get_saved(){
    $db = get_db();
    if(!isset($_SESSION['saved'])){
        $_SESSION['saved'] = [];
    }
   
    $thumbnails = [];
    foreach($_SESSION['saved'] as $file){

        $res = $db->files->findOne(['_id' => new ObjectID($file)]); // extension bug lol
        $thumbnails[] = [
            'name'=>$res['name'],
            'path'=> "thumb_" . $res['name'],
            'id'=>$res['_id']
        ];
    }
    return $thumbnails;
}

function get_file($id){
    $db = get_db();
    $res = $db->files->findOne(['_id' => new ObjectID($id)]);
    return $res;
}


function is_img_private($name){
    $db = get_db();
    if(strpos($name, 'marked_') !== false){
        $name = str_replace('marked_', '', $name);
    }
    if (strpos($name, 'thumb_') !== false){
        $name = str_replace('thumb_', '', $name);
    }
    $res = $db->files->findOne(['name' => $name]);
    if ($res['isPrivate'] === 'true'){
        return true;
    }
    return false;
}

function get_thumbnails(){
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $db = get_db();
    $opt = [
        'skip' => ($page - 1) * PAGE_SIZE,
        'limit' => PAGE_SIZE,
    ];
    $res = $db->files->find([], $opt);
    $thumbnails = [];
    foreach($res as $file){
       // if (isset($_SESSION['user_id'])){
      //      if ($file['isPrivate'] === 'true' && $file['user'] !== $_SESSION['user_id']){
                //continue;
      //      }
      //  } else{
        if ($file['isPrivate'] === 'true'){
            if (isset($_SESSION['user_id'])){
                if ($file['user'] != $_SESSION['user_id']){
                    continue;
                }
            } else{
                continue;
            }
        }
            $thumbnails[] = [
                'name'=>$file['name'],
                'path'=> "thumb_" . $file['name'],
                'id'=>$file['_id']
            ];
     //   }
    }
    return $thumbnails;
}

function verify_file($file, &$model){
    $allowed = array('png', 'jpg');
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if(!in_array($ext, $allowed)){
        $model['error'] = true;
        $model['desc'] = 'File type not allowed';
        return false;
    }
    if($file['size'] > MB){
        $model['error'] = true;
        $model['desc'] = 'File is too big (max 1MB)';
        return false;
    }
    return true;
}

function create_miniature($img, $upload_dir, $name, $ext){
    $width = imagesx($img);
    $height = imagesy($img);

    $thumb = imagecreatetruecolor(200, 125);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 125, $width, $height);

    if ($ext === 'jpg'){
        imagejpeg($thumb, $upload_dir . $name);
        imagedestroy($thumb);
        return true;
    } else if ($ext === 'png'){
        imagepng($thumb, $upload_dir . $name);
        imagedestroy($thumb);
        return true;
    }

    return false;
}

function create_watermark($img, $watermark, $upload_dir, $name, $ext){
    $font = './fonts/Roboto-Black.ttf';
    $textclor = imagecolorallocate($img, 255, 255, 255);    
    imagettftext($img, 20, 0, 10, 20, $textclor, $font, $watermark);
    if ($ext === 'jpg'){
        imagejpeg($img, $upload_dir . $name);
        return true;
    } else if ($ext === 'png'){
        imagepng($img, $upload_dir . $name);
        return true;
    }   
    return false;
}   

function save_file($file){
    $upload_dir = __DIR__ . '/web/images/';
    if(!file_exists($upload_dir)){
        mkdir($upload_dir);
    }
    if(move_uploaded_file($file['tmp_name'], $upload_dir . $file['name'])){
        return true;
    }
    return false;
}

function upload_file($file){
    $upload_dir = __DIR__ . '/web/images/';
    $db = get_db();
    if(!save_file($file)){
        return false;
    }
    
    // opens image according to format

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if($ext === 'jpg'){
        $img = imagecreatefromjpeg($upload_dir . $file['name']);
    } else if($ext === 'png'){
        $img = imagecreatefrompng($upload_dir . $file['name']);
    } else {
        return false;
    }
    
     // creates miniature
     $name = 'thumb_' . $file['name'];
     if(!create_miniature($img, $upload_dir, $name, $ext)){
         return false;
     }

    // creates watermark
    $name = 'marked_' . $file['name'];
    if(!create_watermark($img, $_POST['watermark'], $upload_dir, $name, $ext)){
        return false;
    }


    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
    } else {
        $id = null;
    }
    $db->files->insertOne([
        'name'=>$file['name'],
        'size'=>$file['size'],
        'type'=>$file['type'],
        'user'=>$id,
        'path'=> $upload_dir . $file['name'],
        'isPrivate'=> $_POST['private'],
        'author'=> $_POST['author'],
        'title'=> $_POST['title']
    ]);
    return true;
}

function get_images_by_query($name){
    $query = [ 'title' =>
        [ '$regex' => $name, '$options' => 'i' ]
    ];
    $db = get_db();
    $res = $db->files->find($query);
    $thumbnails = [];
    foreach($res as $file){
        $thumbnails[] = [
            'name'=>$file['name'],
            'path'=> "thumb_" . $file['name'],
            'id'=>$file['_id']
        ];
    }
    return $thumbnails;
}
