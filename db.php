<?php
    try {
        $user = "user";
        $pass = "password";
        $pdo = new PDO('mysql:host=server:port;dbname=database', $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>