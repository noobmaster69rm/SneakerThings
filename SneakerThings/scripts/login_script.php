<?php

//Include libraries
include('../../vendor/autoload.php');

//Create instance of MongoDB client, selecting database and collection(s)
$mongoClient = (new MongoDB\Client);
$db = $mongoClient->SneakerThings;
$collection = $db->Customer;

$email= filter_input(INPUT_POST, 'loginUsername', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_STRING);

$findCriteria = [ 'loginUsername' => $email];

$resultArray = $db->Customer->find($findCriteria)->toArray();

if(count($resultArray) == 0)
{
    echo 'Email does not exist!';
    return;
}

$Customer = $resultArray[0];

if($Customer['password'] != $password)
{
    echo("Incorrect email and password combination");
    return;
}

else{
    echo '<script>
                window.location.replace("../index.php");
          </script>';
}

//Start session for this user
$_SESSION['loggedInUserEmail'] = $email;
//Start session  management
session_start();