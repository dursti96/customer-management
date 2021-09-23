<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap');
    </style>
</head>
<body>

    <nav>
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                    if(isset($_SESSION["useruid"])){
                        echo '<li><a href="profile.php">Upload Profile</a></li>';
                        echo '<li><a href="inc/logout.inc.php">Log out</a></li>';
                    }
                    else{
                        echo '<li><a href="login.php">Login</a></li>';
                        echo '<li><a href="signup.php">Sign up</a></li>';
                    }
                ?>

            </ul>
    	</div>
    </nav>