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

if($type == 'deposit')
    {
        deposit($amount,$type);
    }
    else
    {
        withdraw($amount,$type);
    }






?>