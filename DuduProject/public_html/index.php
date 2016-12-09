<?php
ini_set('max_execution_time', 300);
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

    userGET($_SESSION['token']);

    studentCreate($_SESSION['token'], $id, $name, $address, $photo, $zipcode, $_SESSION['userId']);

}



if(isset($_POST['logout'])){
    include '../func/logout.php';
}



if(isset($_POST['deleteUser'])){
    $userDelEmail = emailGET($_POST['deleteUser'], $_SESSION['token']);



    userDelEmail($userDelEmail, $_SESSION['token']);


}

if(isset($_POST['updateInfo'])){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];
    $photo = $_POST['photo'];
    $id = $_POST['id'];


    userGET($_SESSION['token']);

    studentUpdate($_SESSION['token'], $id, $name, $address, $photo, $zipcode, $_SESSION['userId'], $_SESSION['studentId']);
}

if(isset($_POST['changePassword'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
}

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $student = studentGET($_SESSION['token'], $_SESSION['userId']);
} else {
    $userId = Null;
    $student = Null;
}
if(isset($_SESSION['token'])){
    $token = $_SESSION['token'];
    $students = studentsGET($_SESSION['token']);

} else {
    $token = Null;
    $students = null;
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

if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
}
/*
$absences = array();

foreach ($students as $key => $student){
   $userAbsenceId = $student->User;

    $absence = absenceGET($_SESSION['token'], $userAbsenceId);

    array_push($absences, $absence);
}




echo $student->User;
*/
echo $template->render(
    array(
        'page' => $page,
        'subPage' => $subPage,
        'token' => $token,
        'userId' => $userId,
        'username' => $username,
        'password' => $password,
        'students' => $students,
        'student' => $student
    ));



?>
