<?php
$username = "root";
$password = "password";

$dsn = 'mysql:host=localhost;dbname=cards';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {  
    $error_message = $e->getMessage();
    echo "<p>Error Connecting to the Database: $error_message</p>";
    exit();
}
?>