<?php

require_once __DIR__ . '../../vendor/autoload.php';

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

