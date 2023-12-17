<?php

require_once __DIR__ . '../../vendor/autoload.php';

define('MB', 1048576);

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


function register_user($user, $hash){
    $db = get_db();
    $db->users->insertOne([
        'login'=>$user,
        'hash'=>$hash
    ]);
}

function get_user($user) {
    $db = get_db();
    $res = $db->users->findOne(['login' => $user]);
    return $res;
}

function verify_file($file){
    $allowed = array('png', 'jpg');
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if(!in_array($ext, $allowed)){
        return false;
    }
    if($file['size'] > MB){
        return false;
    }
    return true;
}
