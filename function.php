<?php
require_once ("account.php");
require_once ("database.php");
/**
 * Created by PhpStorm.
 * User: vkhor
 * Date: 4/19/2017
 * Time: 11:40 AM
 */

function redirect ($message, $url)
    {
        echo $message;
        header("refresh: 5 ; url = $url");
        exit();
    }

function admin($name,$pass,$autority_level)
    {
        if($name != "admin" or $pass != "007" or $autority_level != "admin"){
            $message = "invalid user name or password.";
            $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
            redirect($message,$url);
        }else{
            redirect("sucess","https://web.njit.edu/~vjk5/download/assignment2/admin.php");
        }
    }/// here you pulling in

function user($name,$pass)
    {
        $temp = identify_user($name,$pass);
        if (count($temp) ==  0 )
        {
            // TODO: Redirect to Login
            redirect($message = "Login not sucessful",
                     $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html");
        }else{
            $_SESSION['status'] = "user";  //if they made it this far i can give them gate keeper cradentials
            $_SESSION['logged'] = true;    // this is the other gate keeper cradential needed
            // TODO: Redirect to Login
            redirect($message = "Login sucessful",
                     $url = "https://web.njit.edu/~vjk5/download/assignment2/user.php");
        }
    }

function add_user($user,$pass,$email,$fullname,$address,$inital_balance,$current_balance)
{
    global $db;
    $query = "INSERT INTO accounts VALUES('$user','$pass','$email','$fullname','$address','$inital_balance','$current_balance')";
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
}

function delete_user($user)
    {
        global $db;
        $query = "DELETE FROM accounts WHERE user = '$user'";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
    }

function admin_get_users_data()
    {
        global $db;
        $query = "SELECT * FROM accounts";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();
        return $users;
    }

function admin_get_trans_data()
    {
        global $db;
        $query = "SELECT * FROM transaction";
        $statement = $db->prepare($query);
        $statement->execute();
        $transactions = $statement->fetchAll();
        $statement->closeCursor();
        return $transactions;
    }

function get_users_data($user,$pass)
    {
        global $db;
        $query = "SELECT * FROM accounts WHERE user = '$user' AND pass ='$pass'";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();

        return $users;
    }

function set_session($array)
    {
        $current_balance = $array["current_balance"];
        $email = $array["email"];
        $user = $array["user"];

        $_SESSION["current_balance"] = $current_balance;
        $_SESSION["email"] = $email;
        $_SESSION["user"] = $user;
    }

function get_trans_data($user,$pass)
    {
        global $db;
        $query = "SELECT * FROM transaction WHERE user = '$user' AND pass ='$pass'";
        $statement = $db->prepare($query);
        $statement->execute();
        $transactions = $statement->fetchAll();
        $statement->closeCursor();
        return $transactions;
    }

function withdraw($amount,$type)
    {
        $cb = $_SESSION['current_balance'];
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        echo ".$cb.  = cb";
        echo ".$user. = user";
        echo "$email. = email";
        global $db;
        if($cb < $amount && $type = 'W'){
            $message = "not enough money in account";
            $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
            redirect($message,$url);
        }else{
            $query2 = "INSERT INTO transaction VALUES('$user','$type','$amount',NOW())";
            $statement2 = $db->prepare($query2);
            $statement2->execute();
            $statement2->closeCursor();
            $query3 = "UPDATE accounts SET current_balance = current_balance - '$amount' WHERE user = '$user'";
            $statement3 = $db->prepare($query3);
            $statement3->execute();
            $statement3->closeCursor();
            $message = "you sucessfully withdrew $$amount "; // removed the . $amount .
            $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
            redirect($message,$url);
        }
    }

function deposit($amount,$type)
    {
        $user = $_SESSION['user'];
        print_r($_SESSION);
        echo $amount;
        global $db;
        $query = "INSERT INTO transaction VALUES('$user','$type','$amount',NOW())";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        $query2 = "UPDATE accounts SET current_balance = current_balance + '$amount' WHERE user = '$user'";
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $statement2->closeCursor();
        $message = "you sucessfully deposited $.$amount.";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
    }

function identify_user($user,$pass)
    {
        //session_start();
        global $db;
        $query = "SELECT * FROM accounts WHERE user = '$user' AND pass = '$pass'";
        $statement = $db->prepare($query);
        $statement->execute();
        $discovered = $statement->fetchAll();
        $statement->closeCursor();
        return $discovered;
    }

function gatekeeper($user,$pass)
{
    include("account.php");
    ($dbh = mysql_connect($hostname, $username, $password)) or die ( "Unable to connect to MySQL database" );
    mysql_select_db($project);

    $select="SELECT * FROM accounts WHERE user='$user' and pass='$pass'";
    ($t = mysql_query($select)) or die (mysql_error());
    // TODO: Redirect to Login

    if(mysql_num_rows($t) == 0){
        $message = "invalid user name or password, you will now be redirected by the gatekeeper";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
    }
}
function retrieve_email($user,$type)
{
    global $db;
    if($type == 'admin') //admins default email
    {
        return 'vjk5@njit.edu';
    }
    elseif($type != 'admin') //users email search
    {
        $query = "SELECT email FROM accounts WHERE user = :user";
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user);
        $statement->execute();
        $email_addr = $statement->fetchAll();
        $statement->closeCursor();
        return $email_addr[0]['email'];
    }
}
function email($type,$user,$message)
{
    $to = retrieve_email($user,$type);
    $subject = "user account and transaction";
    $message = "$message" . "\n";
    $headers = 'From: vkhorozian@gmail.com' . "\r\n" .
        'Reply-To: vkhorozian@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    echo "TO: " . $to . '<br>';
    echo "SUBJECT: " . $subject . '<br>';
    echo "MESSAGE: " . $message . '<br>';
    echo "HEADERS: " . $headers . '<br>';

    mail($to,$subject,$message,$headers);

}






/*
function admin($name,$pass,$autority_level)
{
    if($name = "admin" and $pass = "007" and $autority_level = "admin"){
        redirect("sucess","https://web.njit.edu/~vjk5/download/assignment2/admin.php");
    }else{
        $message = "invalid user name or password.";
        $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
        redirect($message,$url);
    }
}

function set_session_var($user,$pass)
    {
        session_start();
        global $db;
        $query = "SELECT * FROM accounts WHERE user = '$user' AND pass = '$pass'";
        $statement = $db->prepare($query);
        $statement->execute();
        $discovered = $statement->fetchAll();
        $statement->closeCursor();
        // $discovered;
    }
*/














