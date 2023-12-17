<?php
require_once 'business.php';

function index(&$model){
    return 'index';
}

function gallery(&$model){
    //todo log in 
    //todo sign in 
    //todo checking if logged in 
    //todo  
    return 'gallery';
}

function signup(&$model) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user = $_POST['user'];
        $pass = $_POST['password'];
        $repeat = $_POST['password_repeat'];
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
            return 'redirect:fail';
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

function fail(&$model){
    
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