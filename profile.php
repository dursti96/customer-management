<?php
    include_once 'inc/header.inc.php';
?>


<section class="signup-form">

    <form action="inc/profile.inc.php" method="post">
        <p class='profile'>Upload new customer profile:</p>
        <input type="text" name="CompanyName"  placeholder="Company name">
        <input type="text" name="ContactPerson" placeholder="Contact person">
        <input type="text" name="PhoneNr" placeholder="Phone number">
        <br>
        <button type="submit" name="submit">Submit new customer</button>
    </form>
    <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyInputcustomer"){
                echo "<p class='signupmsg'>Fill in all fields!</p>";
            }
            elseif($_GET["error"] == "invalidPhoneNr"){
                echo "<p class='signupmsg'>Fill in a working phone number. Numbers only!</p>";
            }
            elseif($_GET["error"] == "ContactPersonExists"){
                echo "<p class='signupmsg'>Contact person/phone number already exists!</p>"; 
            }
            elseif($_GET["error"] == "stmtfailed"){
                echo "<p class='signupmsg'>Something went wrong, please try again!</p>";
            }
            elseif($_GET["error"] == "none"){
                echo "<p class='signupmsg'>New customer was successfully uploaded!</p>";
            }
        }  
    ?>
</section>




<?php
    include_once 'inc/footer.inc.php';
?>