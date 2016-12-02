<?php
ob_start();
session_start();
require_once '../func/functions.php';
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('auto_reload' => true));



if(isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = Null;
}
if(isset($_GET['subPage'])){
    $subPage = $_GET['subPage'];
} else {
    $subPage = Null;
}

switch ($page){
    case 'user':
        $template = $twig->loadTemplate('user.html.twig');
        break;
    case 'forum':
        $template = $twig->loadTemplate('forum.html.twig');
        break;
    case 'absence':
        $template = $twig->loadTemplate('absence.html.twig');
        break;
    default:
        $template = $twig->loadTemplate('index.html.twig');
        break;
}


if(isset($_POST['loginSubmit'])){
    include '../func/login.php';
}



/* Create user via curl post http */
if(isset($_POST['create'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];
    $photo = $_POST['photo'];
    $id = $_POST['id'];

    userCreate($email, $password, $confirmPassword);

    tokenReq($email, $password);

    userGET($_COOKIE['token']);

    studentCreate($_COOKIE['token'], $id, $name, $address, $photo, $zipcode, $_SESSION['userId']);
}

if(isset($_POST['logout'])){
    include '../func/logout.php';
}







if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
} else {
    $userId = Null;
}

if(isset($_COOKIE['username'])){
    $username = $_COOKIE['username'];
} else {
    $username = Null;
}
if(isset($_COOKIE['password'])){
    $password = $_COOKIE['password'];
} else {
    $password = Null;
}



echo $template->render(
    array(
        'page' => $page,
        'subPage' => $subPage,
        'token' => $token,
        'userId' => $userId,
        'username' => $username,
        'password' => $password
    ));



?>
