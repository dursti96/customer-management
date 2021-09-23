<?php

        //
        // signup functions
        //


function emptyInputSignup($email,$username,$pwd,$pwdRepeat){

    $result;
    if(empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidUid($username){

    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false; 
    }
    return $result;
}

function invalidEmail($email){

    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false; 
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){

    $result;
    if($pwd !== $pwdRepeat){
        $result = true;
    }
    else{
        $result = false; 
    }
    return $result;
}

function uidExists($conn, $username, $email){

    // prepared sql statement
    $sql = "SELECT * FROM users WHERE usersUid = ? or usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    // execute the statement
    mysqli_stmt_execute($stmt);
    
    // save data from prepared statement into $resultData
    $resultData = mysqli_stmt_get_result($stmt);

    // if there is data, then uid is already in database; if not return false
    // set $row while checking if true
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        return false;
    }

    // close statement!!
    mysqli_stmt_close($stmt);

}

function createUser($conn, $email, $username, $pwd){

    // prepared sql statement
    $sql = "INSERT INTO users (usersEmail, usersPwd, usersUid) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    // check if prepared statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    // hash pwd
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);


    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "sss", $email, $hashedPwd, $username);
    // execute the statement
    mysqli_stmt_execute($stmt);


    // close statement!!
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}


        //
        // login functions
        //




function emptyInputLogin($conn,$username,$pwd){

    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function loginUser($conn,$username,$pwd){

    // uidExists returns the row of the user from the db
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../signup.php?error=wronglogin");
        exit();
    }


    // save usersPwd from $uidExists in new variable, then check if $pwd matches $pwdHashed
    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    elseif($checkPwd ===true){
        session_start();
        $_SESSION["useruid"] = $uidExists["usersUid"];
        header("location: ../index.php");
        exit();
    }


}




        //
        // save new contact functions
        //




function emptyInputCustomer($companyname,$contactperson,$phonenr){

    $result;
    if(empty($companyname) || empty($contactperson) || empty($phonenr)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidPhoneNr($phonenr){

    $result;
    if(!preg_match("/^[0-9]*$/", $phonenr)){
        $result = true;
    }
    else{
        $result = false; 
    }
    return $result;
}

function ContactPersonExists($conn, $contactperson, $phonenr){

    // prepared sql statement
    $sql = "SELECT * FROM customer WHERE ContactPerson = ? or PhoneNr = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ss", $contactperson, $phonenr);
    // execute the statement
    mysqli_stmt_execute($stmt);
    
    // save data from prepared statement into $resultData
    $resultData = mysqli_stmt_get_result($stmt);

    // if there is data, then contactperson/phonenr is already in database; if not return false
    // set $row while checking if true
    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        return false;
    }

    // close statement!!
    mysqli_stmt_close($stmt);

}

function createCustomer($conn, $companyname, $contactperson, $phonenr){

    // prepared sql statement
    $sql = "INSERT INTO customer (CompanyName, ContactPerson, PhoneNr, CreatedBy, CreatedAt, LastEdit) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    // check if prepared statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    //get uid of person that is loged in
    $createdby = $_SESSION["useruid"];

    $currentdate = date('Y-m-d H:i:s');


    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ssssss", $companyname, $contactperson, $phonenr, $createdby, $currentdate, $currentdate);
    // execute the statement
    mysqli_stmt_execute($stmt);


    // close statement!!
    mysqli_stmt_close($stmt);
    header("location: ../profile.php?error=none");
    exit();
}






        //
        // user functions; read, edit, delete customers
        //





function getCustomers($conn, $usersuid){

    $sql = "SELECT * FROM customer WHERE createdBy = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "s", $usersuid);
    // execute the statement
    mysqli_stmt_execute($stmt);
    
    // save data from prepared statement into $resultData
    $resultData = mysqli_stmt_get_result($stmt);

    return $resultData;
}


function editContactPerson($conn, $ContactPerson, $newContactPerson, $createdby){

    $sql = "UPDATE customer SET ContactPerson = ?, LastEdit = ?  WHERE ContactPerson = ? AND createdBy = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $createdby = $_SESSION["useruid"];
    $currentdate = date('Y-m-d H:i:s');

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ssss", $newContactPerson, $currentdate, $ContactPerson, $createdby);
    // execute the statement
    $resultData = mysqli_stmt_execute($stmt);

    return $resultData;
}

function editCompanyName($conn, $ContactPerson, $newCompanyname, $createdby){

    $sql = "UPDATE customer SET CompanyName = ?, LastEdit = ? WHERE ContactPerson = ? AND createdBy = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $currentdate = date('Y-m-d H:i:s');
    $createdby = $_SESSION["useruid"];

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ssss", $newCompanyname, $currentdate, $ContactPerson, $createdby);
    // execute the statement
    $resultData = mysqli_stmt_execute($stmt);

    return $resultData;
}

function editPhoneNr($conn, $ContactPerson, $newPhonenr, $createdby){

    $sql = "UPDATE customer SET PhoneNr = ?, LastEdit = ? WHERE ContactPerson = ? AND createdBy = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $currentdate = date('Y-m-d H:i:s');
    $createdby = $_SESSION["useruid"];

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ssss", $newPhonenr, $currentdate, $ContactPerson, $createdby);
    // execute the statement
    $resultData = mysqli_stmt_execute($stmt);

    return $resultData;
}
