<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_SESSION["useruid"])){
    echo "<p class='loginmsg'>" . $_SESSION["useruid"] . "'s customers:</p> <br>";

    // get customers from user
    $usersuid = $_SESSION["useruid"];
    $customers = getCustomers($conn, $usersuid);

    // if no data, print msg; else print data
    if($customers == false){
        echo "<p>No customers available.</p>";
    }
    else{

        //table for customers
        echo "<table class='customers'>";
        echo"<tr class='customers' id='headline'>
            <td>Company</td>
            <td>Contact Person</td>
            <td>Phone number</td>
            <td>Created by</td>
            <td>Created at</td>
            <td>Last edit</td>
            <td></td>
            <td></td>
            </tr>";

        while ($row = $customers->fetch_assoc()) {
            echo "<tr class='customers'>";
            echo '<td> ' . $row["CompanyName"] . "</td>";
            echo '<td> ' . $row["ContactPerson"] . "</td>";
            echo '<td> ' . $row["PhoneNr"] . "</td>";
            echo "<td>" . $row["CreatedBy"] . "</td>";
            echo "<td>" . $row["CreatedAt"] . "</td>";
            echo "<td>" . $row["LastEdit"] . "</td>";
            echo '<td><a href="index.php?Contact=' . $row['ContactPerson'] . '&function=edit">Edit</a></td>';
            echo '<td><a href="inc/delete.inc.php?Contact=' . $row['ContactPerson'] . '">Delete</a></td>';
            echo "</tr>";

        }

        echo "</table>";

        // form for editing
        if (isset($_GET['function'])){
            if($_GET['function'] == 'edit'){
                $contact = $_GET['Contact'];
                echo '<div id="edit">';
                echo 'Please fill in the values you want to change.<br>Skip values you do not want to change.';
                echo '
                <form class="formedit" action="inc/edit.inc.php?contact=' . $contact . '" method="post">
                <p>Contact Person: ' . $contact . '</p>
                <input size="10" type="text" name="newCompanyName" placeholder="New company name...">
                <input type="text" name="newContactPerson" placeholder="New contact person...">
                <input type="text" name="newPhoneNr" placeholder="New phone number...">
                <button type="submit" name="submit">Save changes!</button>
                </form></div>';
            }
            else{
                header("location:../index.php");
                exit();
            }
        }

    }
}
else{
    echo '<h1>Guten Tag!<br><br>Bitte melden Sie sich an, um Ihre Kunden zu managen.</h1>';
}