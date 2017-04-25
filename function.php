<?php
session_start();
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
        header("refresh:3 ; url = $url");
        exit();
    }
function get_case(&$name,&$pass,&$type)
    {
        if ($type != "user" && $type != "admin")
        {
            $message = "You must select an account type.";
            $url = "https://web.njit.edu/`vjk5/download/assignment2/login.html";
            redirect($message,$url);
        }
        elseif ($name == "" || $pass == "")
        {
            $message = "You must enter a username and password.";
            $url = "https://web.njit.edu/`vjk5/download/assignment2/login.html";
            redirect($message,$url);        }
        // if everything works return the type (withdraw, deposit, or admin)
        else
        {
            $name = mysql_real_escape_string($name);
            $pass = mysql_real_escape_string($pass);
            return $type;
        } return $type;
    }// cheack this first them go to user
function admin($name,$pass)
    {
        if($name != "admin" and $pass != "007"){
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
            redirect($message = "Login sucessful",
                     $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html");
        }else{
            $_SESSION['status'] = "user";  //if they made it this far i can give them gate keeper cradentials
            $_SESSION['logged'] = true;    // this is the other gate keeper cradential needed
            // TODO: Redirect to Login
            redirect($message = "Login sucessful",
                     $url = "https://web.njit.edu/~vjk5/download/assignment2/user.php");
        }
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
        $query = "INSERT INTO transaction VALUES('user','type','amount','date')";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        if($cb < $amount and $type = 'W'){
            $message = "not enough money in account www";
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
            $message = "you sucessfully withdrew $.$amount.";
            $url = "https://web.njit.edu/~vjk5/download/assignment2/login.html";
            redirect($message,$url);
        }
    }
function deposit($amount,$type)
    {
        $cb = $_SESSION['current_balance'];
        $user = $_SESSION['user_name'];
        global $db;
        $query = "INSERT INTO transaction VALUES('user','type','amount','date')";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        $query2 = "INSERT INTO transaction VALUES('$user','$type','$amount',NOW())";
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $statement2->closeCursor();
        $query3 = "UPDATE accounts SET current_balance = current_balance + '$amount' WHERE user = '$user'";
        $statement3 = $db->prepare($query3);
        $statement3->execute();
        $statement3->closeCursor();
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

