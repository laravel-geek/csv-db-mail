<?php

require_once 'config.php';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;

try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO mailings (name, text, user_id)
            SELECT :name, :text, users.id FROM users
            LEFT JOIN mailings ON users.id = mailings.user_id AND mailings.sent = 1
            WHERE mailings.id IS NULL";
    $stmt = $pdo->prepare($sql);

    $name = 'Название рассылки';
    $text = 'Текст рассылки';
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':text', $text);
    $stmt->execute();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;
