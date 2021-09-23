<?php
    include_once 'inc/header.inc.php';
?>



    <section class="signup-form">

        <h2>Sign Up</h2>
        <form action="inc/signup.inc.php" method="post">
            <input type="text" name="email" placeholder="Email...">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <input type="password" name="pwdrepeat" placeholder="Repeat password...">
            <button type="submit" name="submit">Sign up</button>
        </form>
        <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                echo "<p class='signupmsg'>Fill in all fields!</p>";
            }
            elseif($_GET["error"] == "invaliduid"){
                echo "<p class='signupmsg'>Choose a proper username!</p>";
            }
            elseif($_GET["error"] == "invalidemail"){
                echo "<p class='signupmsg'>Choose a proper Email!</p>";
            }
            elseif($_GET["error"] == "nomatch"){
                echo "<p class='signupmsg'>Password don't match!</p>";
            }
            elseif($_GET["error"] == "stmtfailed"){
                echo "<p class='signupmsg'>Something went wrong, please try again!</p>";
            }
            elseif($_GET["error"] == "invaliduid"){
                echo "<p class='signupmsg'>Choose a proper username!</p>";
            }
            elseif($_GET["error"] == "usernametaken"){
                echo "<p class='signupmsg'>Username/Email already taken!</p>";
            }
            elseif($_GET["error"] == "none"){
                echo "<p class='signupmsg'>You have sucessfully signed up!</p>";
            }
        }
        ?>
    </section>






<?php 
    include_once 'inc/footer.inc.php';
?>