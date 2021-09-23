<?php
    include_once 'inc/header.inc.php';
?>



    <section class="signup-form">

        <h2>Login</h2>
        <form action="inc/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username/Email...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">Login</button>
        </form>
        <?php
            if(isset($_GET["error"])){
                if($_GET["error"] == "emptyinput"){
                    echo "<p class='signupmsg'>Fill in all fields!</p>";
                }
                elseif($_GET["error"] == "wronglogin"){
                    echo "<p class='signupmsg'>Incorrect Username/Email or Password!</p>";
                }
            }
        ?>
    </section>









<?php
    include_once 'inc/footer.inc.php';
?>