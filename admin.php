<?php
include_once ("function.php");
/*
 * Created by PhpStorm.
 * User: vkhor
 * Date: 4/18/2017
 * Time: 4:59 PM
 */

//USE PDO OBJECT TO PRINT ACCOUNTS TABLE AND TRANSACTION
$users = admin_get_users_data();
$transactions = admin_get_trans_data();

?>
<!DOCTYPE html5>
<html>
<head><title>Admin Homepage</title><link rel="stylesheet" type="text/css" href="main.css"></head>
<body>
    <main>
        <h1>View Details of Acounts</h1>
        <section>
            <h2>accounts</h2>
            <table>
                <tr>
                    <th>User</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Address</th>
                    <th>Initial Balance</th>
                    <th>Current Balance</th>
                </tr>
                <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['user']; ?></td>
                    <td><?php echo $user['pass']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['fullname']; ?></td>
                    <td><?php echo $user['address']; ?></td>
                    <td><?php echo $user['initial_balance']; ?></td>
                    <td><?php echo $user['current_balance']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
        <h2>transactions</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?php echo $transaction['user']; ?></td>
                    <td><?php echo $transaction['type']; ?></td>
                    <td><?php echo $transaction['amount']; ?></td>
                    <td><?php echo $transaction['date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        </section>
        <br>

        <form  method="post" action = "login.php" >
            <h4>This will redirect you to login page</h4>
            <input type="submit">

        </form>

        <form method="post" action="add_user.html" >
                <h4>Add User</h4>
                <input type="submit">
        </form>


        <form method="post" action = "delete_user.html">
                <h4>Delete User</h4>
                <input type="submit">
        </form>




    </main>
</body>
</html>
