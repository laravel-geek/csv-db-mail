<?php

require_once 'config.php';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;

try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "INSERT INTO mailings (name, text, user_id) VALUES (:name, :text, :user_id)";
    $stmt = $pdo->prepare($sql);

    foreach ($users as $user) {
        // Проверка, была ли рассылка уже отправлена данному пользователю
        $stmt_check = $pdo->prepare("SELECT * FROM mailings WHERE user_id = :user_id AND sent = 1");
        $stmt_check->bindParam(':user_id', $user['id']);
        $stmt_check->execute();

        if ($stmt_check->rowCount() == 0) { // Если рассылка не была отправлена, добавляем запись в таблицу рассылок
            $name = 'Название рассылки';
            $text = 'Текст рассылки';
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':user_id', $user['id']);
            $stmt->execute();
        }
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;