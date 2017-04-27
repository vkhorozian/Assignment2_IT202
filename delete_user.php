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
$email_checked = filter_input(INPUT_POST, 'mail');

delete_user($user_name);

$type = $_SESSION['autority_level'];

if (isset($email_checked))
    {
        email($type,$user_name,$message);
    }

$message = "User. $user_name . was removed";
$url = "https://web.njit.edu/~vjk5/download/assignment2/admin.php";

redirect($message,$url);

?>

