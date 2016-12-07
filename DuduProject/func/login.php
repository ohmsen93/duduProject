<?php

    $userLogin = $_POST['loginUsername'];
    $userPassword = $_POST['loginPassword'];
    if(isset($_POST['rememberMe'])){
        setcookie('username',$userLogin,time() + (86400 * 30), "/");
        setcookie('password',$userPassword,time() + (86400 * 30), "/");
    }

    tokenReq($userLogin, $userPassword);

    userGET($_SESSION['token']);



?>





