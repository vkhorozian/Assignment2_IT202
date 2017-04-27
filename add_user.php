<?php
session_start();
include_once ('function.php');
/**
 * Created by PhpStorm.
 * User: vkhor
 * Date: 4/26/2017
 * Time: 6:25 PM
 */


$user_name = filter_input(INPUT_POST, 'user_name'); echo "the username is ".$user_name.'<br>';
$pass = filter_input(INPUT_POST, 'password'); echo "the pass is ".$pass.'<br>';
$email = filter_input(INPUT_POST, 'email'); echo "the email is ".$email.'<br>';
$fullname = filter_input(INPUT_POST, 'fullname'); echo "the fullname is ".$fullname.'<br>';
$address = filter_input(INPUT_POST, 'address'); echo "the address is ".$address.'<br>';
$initial_balance = filter_input(INPUT_POST, 'initial_balance'); echo "the initial_balance is ".$initial_balance.'<br>';
$current_balance = filter_input(INPUT_POST, 'current_balance'); echo "the current_balance is ".$current_balance.'<br>';
$email_checked = filter_input(INPUT_POST, 'mail');

add_user($user_name,$pass,$email,$fullname,$address,$initial_balance,$current_balance);

$type = $_SESSION['autority_level'];

echo $type;

if (isset($email_checked))
{
    echo "is their anyone out their";
    email($type,$user_name,$message);
}





$message = "User:. $user_name . Pass: . $pass . Email: . $email . Fullname: . $fullname . Address: . $address . Initial Balance: . $initial_balance . Current Balance . $current_balance .";
$url = "https://web.njit.edu/~vjk5/download/assignment2/admin.php";

redirect($message,$url);




?>