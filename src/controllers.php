<?php
require_once 'business.php';

function index(&$model){
    remove_files();
    remove_users();
    return 'index';
}

function gallery(&$model){
    if(!isset($_SESSION['saved'])){
        $_SESSION['saved'] = [];
    }
    $model['images'] = get_thumbnails();
    return 'gallery';
}

function signup(&$model) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user = $_POST['user'];
        $pass = $_POST['password'];
        $repeat = $_POST['password_repeat'];
        if (is_name_taken($user)){
            $model['error'] = 'Username already taken';
            return 'signup_view';
            exit;
        }
        if($pass === $repeat){
            $model['name'] = $_POST['user'];
            $_SESSION['fromRegister'] = true; // flag to display notification
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            register_user($user, $hash);
            return 'redirect:login'; //instead of viwew should call function for failed login
        }else{
            //todo tell user that name is taken
            //todo redirect to main page when fail is accsesd not via redirect
            $model['error'] = 'Failed to register user';
            return 'signup_view';
            exit;
        }
    } else {
        return 'signup_view';
    }   
}

function logout(&$model){
    session_destroy();
    return 'redirect:gallery';
}

function card(&$model){
    return 'card_view';
}

function upload(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(verify_file($_FILES['fileUp'], $model)){
            if(upload_file($_FILES['fileUp'])){
                return 'redirect:gallery';
            }
            else{
                print_r($_FILES);
                $model['error'] = 'Failed to upload file';
                $model['desc'] = 'Failed to save file';
                return 'upload_view';
            }
        }
        else{
            print_r($_FILES);
            return 'upload_view';
        }
    }
    else {
        return 'upload_view';
    }
}

function login(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $login = $_POST['user'];
        $pass = $_POST['password'];
        $user = get_user($login);
        if($user !== null &&
        password_verify($pass, $user['hash'])){
            session_regenerate_id();
            $_SESSION['user_id'] = $user['_id'];
            $_SESSION['user_name'] = $user['login'];
            return 'redirect:gallery';
            exit;
        } else{
            $model['error'] = 'Failed to log in';
            $model['desc'] = 'Login or password incorrect';
            return 'login_view';
        }
    }else{
        if(isset($_SESSION['fromRegister'])){
            $model['hasRegistered'] = true;
            unset($_SESSION['fromRegister']);
        }
        return 'login_view';
    }
}

function save(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (!isset($_POST['images'])){
            return 'redirect:gallery';
        }
        $images = $_POST['images'];
        if (!isset($_SESSION['user_id'])){
            return 'redirect:login';
        }
        if(!isset($_SESSION['saved'])){
            $_SESSION['saved'] = [];
        }
        foreach($images as $image){
            if(!in_array($image, $_SESSION['saved'])){
                $_SESSION['saved'][] = $image;
            }
        }
        return 'redirect:gallery';
    }
    else{
        return 'redirect:gallery';
    }
}


function saved(&$model){
    if(!isset($_SESSION['saved'])){
        $_SESSION['saved'] = [];
    }
    $model['images'] = get_saved();
    $model['file'] = $_SESSION['saved'];
    return 'saved_view';
}