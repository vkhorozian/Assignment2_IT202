<?php
session_start();
//includes my database credentials and extends the funcitons file so they can be used
include("account.php");
include("function.php");

    //TODO: You should really have a unique id in this for it to be secure

//error reporting so i dont need to guess what went wrong
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
echo "<b>Results from Login.php</b><br><br>";

//pulls in user input
$user_name = filter_input(INPUT_POST, 'user'); echo "the username is ".$user_name.'<br>';
$password = filter_input(INPUT_POST, 'password'); echo "the password is " .$password.'<br>';
$autority_level = filter_input(INPUT_POST, 'type'); echo "you are a/an " .$autority_level.'<br>';


$_SESSION["user_name"] = $user_name;
$_SESSION["password"] = $password;

/*if($autority_level != 'admin'){
    $password = sha1($password);
}*/

if($autority_level == "admin")
    {
        admin($user_name,$password);
    }elseif($autority_level == "user"){
        user($user_name,$password);
    }else{
        $message = "you must select a type of user";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
}
//if($action == 'list_users'){}

$array_of_user_data = get_users_data($user_name,$password);

echo $array_of_user_data;


echo $user = $array_of_user_data['user'];
echo $pass = $array_of_user_data['password'];
echo $current_balance = $array_of_user_data['current_balance'];
echo $email = $array_of_user_data['email'];

echo $_SESSION['user'] = $user;
echo $_SESSION['password'] = $pass;
echo $_SESSION['current_balance'] = $current_balance;
echo $_SESSION['email'] = $email;









?>


