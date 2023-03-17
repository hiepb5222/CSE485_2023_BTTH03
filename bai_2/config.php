<?php
$db_host = 'localhost';
$db_name = 'btth03';
$db_user = 'root';
$db_pass = 'Duong123';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;port=3307", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
