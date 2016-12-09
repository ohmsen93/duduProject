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
  #  $tokenReq = curl_init( 'http://localhost:1158/token' );
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


    if($array[7] == "The user name or password is incorrect."){
        session_destroy();
        $_SESSION['message'] = $array[7];
        header('URL = index.php');
    } else {
        /* Token response*/
/*
        echo "<pre>";
        print_r($array[3]);
        echo "</pre>";
*/
        $_SESSION['token'] = $array[3];
    }



}

function userGET($authorization){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Account/UserId" );
  #  curl_setopt($curl, CURLOPT_URL, "http://localhost:1158/api/Account/UserId" );
    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);

    $_SESSION['userId'] = $jsonresult;

}

function studentsGET($authorization){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Students/NonDeleted" );
    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $token));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);
    /*
    echo "<pre>";
    print_r($jsonresult);
    echo"</pre>";
    */
    return $jsonresult;

}

function studentGET($authorization, $user){




    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Students/User/$user/" );
  #  curl_setopt($curl, CURLOPT_URL, "http://localhost:1158/api/Students/User/$user/" );

    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $token));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

  #  print_r($jsonresult);

    $_SESSION['studentId'] = $jsonresult->Id;

    curl_close($curl);

    return $jsonresult;

}


function emailGET($id, $authorization){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Account/UserEmail?id=$id" );
    # curl_setopt($curl, CURLOPT_URL, "http://localhost:1158/api/Account/UserId" );
    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);


    return $jsonresult;

    #  print_r($jsonresult);


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

function userDelEmail($email, $authorization){


        $accDel = curl_init();
        curl_setopt($accDel, CURLOPT_URL,"http://fravaerswepapi.azurewebsites.net/api/Account/DeleteUser/$email/");
        curl_setopt($accDel, CURLOPT_CUSTOMREQUEST, "DELETE");

    $token = "Authorization: Bearer $authorization";

    curl_setopt($accDel, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));

        $result = curl_exec($accDel);
        $httpCode = curl_getinfo($accDel, CURLINFO_HTTP_CODE);
        curl_close($accDel);



        return $result;

}

function studentCreate($authorization, $id, $name, $address, $photo, $zipcode, $user){
    $studentCreate = curl_init( 'http://fravaerswepapi.azurewebsites.net/api/students' );
   # $studentCreate = curl_init( 'http://localhost:1158/api/students' );

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

/*
    echo "<pre>";
    print_r($data);
    print_r($result);
    echo "</pre>";
*/
}

function cityGET($authorization, $zipcode){

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Cities/$zipcode/" );
  #  curl_setopt($curl, CURLOPT_URL, "http://localhost:1158/api/Students/User/$user/" );

    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $token));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);

    return $jsonresult->Name;

}

function absenceGET($authorization, $userId){

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "http://fravaerswepapi.azurewebsites.net/api/Absences/Percent/$userId" );
    #  curl_setopt($curl, CURLOPT_URL, "http://localhost:1158/api/Students/User/$user/" );

    $token = "Authorization: Bearer $authorization";
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $token));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result =(curl_exec($curl));

    $jsonresult = json_decode($result);

    curl_close($curl);

    return $jsonresult;

}


function studentUpdate($authorization, $id, $name, $address, $photo, $zipcode, $user, $studentId){

    $studentUpdate = curl_init( "http://fravaerswepapi.azurewebsites.net/api/students/user/$user/" );
   # $studentUpdate = curl_init( "http://localhost:1158/api/students/$studentId/" );

    $cityName = cityGET($authorization, $zipcode);
    $data = array('Absences' => [], 'CheckIns' => [], 'City' => ['students'=>[], 'ZipCode' => $zipcode, 'Name' => $cityName] ,'Photo1' => null, 'Id' => $id,'Name' => $name, 'Address' => $address, 'Photo' => $photo, 'ZipCode' => $zipcode, 'User' => $user);
    $token = "Authorization: Bearer $authorization";
    $payload = json_encode( $data );


    curl_setopt($studentUpdate, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ));

    curl_setopt($studentUpdate, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($studentUpdate, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($studentUpdate, CURLOPT_POSTFIELDS,$payload);
    curl_setopt($studentUpdate, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($studentUpdate);
    curl_close($studentUpdate);

    $jsonresult = json_decode($result);
/*
    echo "<pre>";
    print_r($result);
    print_r($data);
    echo "</pre>";
*/
}