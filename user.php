<?php
session_start();
include "function.php";

echo "Current Balance: ";
//echo $_SESSION['current_balance'];
//echo $_SESSION['email'];
$user_name = $_SESSION['user_name'];
$password = $_SESSION['password'];

//gatekeeper($user_name,$password);

if ($_SESSION["status"] != "user" && $_SESSION["logged"] != true)
    {
        $message = "invalid cradentials";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
    }
?>

<!DOCTYPE html>
<html>
<head><title>User Homepage</title><link rel="stylesheet" type="text/css" href="main.css"</head>
<body>
    <main>
        <form method="post" action = "transactions.php" >
            <br>
            <br>
            <fieldset>
            <ul> <legend>Action:</legend>
                <li>Deposit <input type=radio name ="type" value='D'></li>
                <li>Withdraw <input type=radio name ="type" value='W'> </li>
                <center>Amount   <input type =text name ="amount" id ="amount" autocomplete ="off" placeholder="enter transaction amount"  ></center><br>

            </ul>
            </fieldset>
            Email results </label> <input type = "checkbox" id = "cbox" name = "mail"> <br>

            <br>
            <input type = submit>
        </form>
    </main>
</body>
</html>
