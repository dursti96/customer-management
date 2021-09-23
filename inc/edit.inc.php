<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";
session_start();


if(isset($_POST["submit"])){


    $contactPerson = $_GET['contact'];
    $createdby = $_SESSION["useruid"];

    $newCompanyName = $_POST['newCompanyName'];
    $newContactPerson = $_POST['newContactPerson'];
    $newPhoneNr = $_POST['newPhoneNr'];
 
    // edit values which are not null
    if($newCompanyName != null){
        $resultName = editCompanyName($conn, $contactPerson, $newCompanyName, $createdby);
    }
    if($newPhoneNr != null){
        $resultPhoneNr = editPhoneNr($conn, $contactPerson, $newPhoneNr, $createdby);
    }
    if($newContactPerson != null){
        $resultContact = editContactPerson($conn, $contactPerson, $newContactPerson, $createdby);
    }

    // check if no statement got an error
    if(($resultName != false) && ($resultPhoneNr != false) && ($resultContact != false)){
        $return = true;
    }


    if($return)
    {
        header("location:../index.php?error=none"); // redirects to all records page
        mysqli_close($conn); // Close connection
        exit;
    }
    else
    {
        header("location:../index.php?error=editfailed"); // redirects to all records page
        mysqli_close($conn); // Close connection
        exit;
    }
}
else{
    header("location: ../index.php");
    exit();
}