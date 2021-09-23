<?php

// if site visited via submit button, else go back to signup.php

if(isset($_POST["submit"])){
    
    // get userinput from form with _POST, make variables
    
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    // require connection to database (dbh.inc.php) and functions

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // functions to check for mistakes,

    if(emptyInputSignup($email,$username,$pwd,$pwdRepeat) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidUid($username) !== false){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if(invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    if(pwdMatch($pwd,$pwdRepeat) !== false){
        header("location: ../signup.php?error=nomatch");
        exit();
    }

    if(uidExists($conn,$username, $email) !== false){
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn,$email,$username,$pwd);


}
else{
    header("location: ../signup.php");
    exit();
}