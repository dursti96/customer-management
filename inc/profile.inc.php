<?php

session_start();
if(isset($_SESSION["useruid"])){
        echo "<p class='loginmsg'>" . $_SESSION['useruid'] . "'s profile</p>";

        if(isset($_POST["submit"])){
    
            // get userinput from form with _POST, make variables
            
            $companyname = $_POST["CompanyName"];
            $contactperson = $_POST["ContactPerson"];
            $phonenr = $_POST["PhoneNr"];
        
            // require connection to database (dbh.inc.php) and functions
        
            require_once 'dbh.inc.php';
            require_once 'functions.inc.php';
        
            // functions to check for mistakes
        
            if(emptyInputCustomer($companyname,$contactperson,$phonenr) !== false){
                header("location: ../profile.php?error=emptyInputcustomer");
                exit();
            }

            if(invalidPhoneNr($phonenr) !== false){
                header("location: ../profile.php?error=invalidPhoneNr");
                exit();
            }
        
            if(ContactPersonExists($conn, $contactperson, $phonenr) !== false){
                header("location: ../profile.php?error=ContactPersonExists");
                exit();
            }
        
            createCustomer($conn, $companyname, $contactperson, $phonenr);
        
        }
        else{
            header("location: ../index.php");
            exit();
        }
        
}
else{
    header("location: ../aindex.php");
    exit();
}