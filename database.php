<?php
    $dsn = 'mysql:host=sql1.njit.edu;dbname=vjk5';
    $username = 'vjk5';
    $password = 'zurich68';


    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        exit();
    }
?>