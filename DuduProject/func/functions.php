<?php
/**
 * Created by PhpStorm.
 * User: Mads Ohmsen
 * Date: 25-11-2016
 * Time: 09:49
 */

function tokenReq($userlogin, $userpass){
    # Token request.
    $tokenReq = curl_init( 'http://fravaerswepapi.azurewebsites.net/token' );
    # Setup request to send json via POST.
    $payload = "username=$userlogin&password=$userpass&grant_type=password";
    curl_setopt( $tokenReq, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $tokenReq, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt( $tokenReq, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($tokenReq);
    curl_close($tokenReq);

    $array = preg_split('/"/', $result);
    /* Token response*/
    echo "<pre>";
    print_r($array[3]);
    echo "</pre>";

    setcookie('token', $array[3],  time() + (1080), "/");
}

function userGET($authorization){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Account/UserId" );
    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);

    $_SESSION['userId'] = $result;

}

function studentGET($authorization){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Students" );
    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $token));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $result = json_decode($result);

    curl_close($curl);


}







function userCreate($email, $password, $confirmPassword){
    $data = array('Email' => $email, 'Password' => $password, 'ConfirmPassword' => $confirmPassword);

    $userCreate = curl_init( 'http://fravaerswepapi.azurewebsites.net/api/Account/Register' );
# Setup request to send json via POST.
    $payload = json_encode( $data );
    curl_setopt( $userCreate, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $userCreate, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
    curl_setopt( $userCreate, CURLOPT_RETURNTRANSFER, true );
# Send request.
    curl_exec($userCreate);
    curl_close($userCreate);
}

function studentCreate($authorization, $id, $name, $address, $photo, $zipcode, $user){
    $studentCreate = curl_init( 'http://fravaerswepapi.azurewebsites.net/api/students' );

    $data = array('Id' => $id,'Name' => $name, 'Address' => $address, 'Photo' => $photo, 'ZipCode' => $zipcode, 'User' => $user);
    $payload = json_encode( $data );
    $token = "Authorization: Bearer $authorization";

    curl_setopt($studentCreate, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));

    curl_setopt($studentCreate, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($studentCreate, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($studentCreate, CURLOPT_POSTFIELDS,$payload);
    curl_setopt($studentCreate, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($studentCreate);
    curl_close($studentCreate);
    return json_decode($result);
}