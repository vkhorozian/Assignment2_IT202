<?php
session_start();
echo $_SESSION['current_balance'];
echo $_SESSION['user_name'];

include ("function.php");

/**
 * Created by PhpStorm.
 * User: vkhor
 * Date: 4/20/2017
 * Time: 2:05 PM
 */

$type = filter_input(INPUT_POST, 'type');
$amount = filter_input(INPUT_POST, 'amount');

if($type == 'D')
    {
        deposit($amount,$type);
    }
    else
    {
        withdraw($amount,$type);
    }


$type = $_SESSION['autority_level'];

if (isset($email_checked))
{
    email($type,$user_name,$message);
}

$message = "User. $user_name . was removed";
$url = "https://web.njit.edu/~vjk5/download/assignment2/admin.php";

redirect($message,$url);




?>