<?php

require_once "dbh.inc.php";
session_start();


if(isset($_SESSION["useruid"])){

    $contactPerson = $_GET['Contact'];
    $createdby = $_SESSION['useruid'];

    // prepared sql statement
    $sql = "delete from customer where contactPerson = ? and createdBy = ?;";
    $stmt = mysqli_stmt_init($conn);

    // check if statement has an error/ if statement fails
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    // bind param to the prepared statement; ss => string,string
    mysqli_stmt_bind_param($stmt, "ss", $contactPerson, $createdby);
    // execute the statement
    $return = mysqli_stmt_execute($stmt);


    if($return)
    {
        header("location:../index.php?error=none"); // redirects to all records page
        mysqli_close($conn); // Close connection
        exit;
    }
    else
    {
        header("location:../index.php?error=delfailed"); // redirects to all records page
        mysqli_close($conn); // Close connection
        exit;
    }
}
else{
    header("location: ../index.php");
    exit();
}