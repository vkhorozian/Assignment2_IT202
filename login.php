<?php
//session_set_cookie_params(0, '/');
session_start();

//includes my database credentials and extends the funcitons file so they can be used
include("account.php");
include("function.php");

    //TODO: You should really have a unique id in this for it to be secure
    //TODO: Hash the passwords and then compare them to their pre-hased version in the DB

//error reporting so i dont need to guess what went wrong
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
echo "<b>Results from Login.php</b><br><br>";

//pulls in user input
$user_name = filter_input(INPUT_POST, 'user_name'); echo "the username is ".$user_name.'<br>';
$password = filter_input(INPUT_POST, 'password'); echo "the password is " .$password.'<br>';
$autority_level = filter_input(INPUT_POST, 'type'); echo "you are a/an " .$autority_level.'<br>';


/*if($autority_level != 'admin'){
    $password = sha1($password);
}*/


$_SESSION["autority_level"] = $autority_level;

$array_of_user_data = get_users_data($user_name, $password);
print_r($array_of_user_data[0]);
set_session($array_of_user_data[0]);

echo $_SESSION['autority_level'] . "<br>";
echo $_SESSION['email'] . "<br>";
echo $_SESSION['current_balance'] . "<br>";


if($autority_level == "admin")
    {
        admin($user_name,$password,$autority_level);
    }elseif($autority_level == "user"){
        user($user_name,$password);
    }else{
        $message = "you must select a type of user";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
}




/*echo $array_of_user_data;


echo $user = $array_of_user_data['user'];
echo $pass = $array_of_user_data['password'];
echo $current_balance = $array_of_user_data['current_balance'];
echo $email = $array_of_user_data['email'];

echo $_SESSION['user'] = $user;
echo $_SESSION['password'] = $pass;
echo $_SESSION['current_balance'] = $current_balance;
echo $_SESSION['email'] = $email;
*/



//if($action == 'list_users'){}

/*


($dbh = mysql_connect($hostname, $user_name, $password))
        or die ("unable to connect to DB");
mysql_select_db($project);
print "success";

$select = "SELECT * FROM accounts WHERE user='$user_name' and pass='$password'";
print "<br> s = $s <br>";

($query = mysql_query($select)) or die (mysql_error());

if(mysql_num_rows($query) > 0)
    {
        $_SESSION["Logged"] = true;
    }else{
    $message = "cant get session vars";
    $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
    redirect($message,$url);

    while($row = mysql_fetch_array($query))
        {
            $user = $row["user"];
            $pass = $row["pass"];
            $current_balance = $row["current_balance"];
            $email = $row["email"];

            $_SESSION["user"] = $user;
            $_SESSION["pass"] = $pass;
            $_SESSION["current_balance"] = $current_balance;
            $_SESSION["email"] = $email;
            print "<br> User is: $user <br> Pass is: $pass <br>Current balance is $: $current_balance  <br>";
        }
}



/*




?>


