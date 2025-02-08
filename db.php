<?php
$servername = "192.168.7.48";    //adresse ip servere
$username = "utestpro";  // nom user
$password = "123"; // mdp user
$dbname = "dbtestpro"; //nom db

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
