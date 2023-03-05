<?php

require_once 'config.php';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;

try {
    // Создание нового объекта PDO для установления соединения с БД
    $pdo = new PDO($dsn, $username, $password);
    // Установка режима обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Подготовка SQL-запроса для выбора пользователей из очереди рассылки
    $stmt = $pdo->prepare("SELECT * FROM mailings WHERE sent = 0");
    $stmt->execute();
    $mailings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Цикл для обработки каждой рассылки
    foreach ($mailings as $mailing) {
        $stmt_user = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt_user->bindParam(':user_id', $mailing['user_id']);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        // Формирование тела сообщения
        $body = "Уважаемый(ая) " . $user['name'] . ",\n\n";
        $body .= $mailing['text'];

        // Отправка уведомления по email
        $headers = "From: " . EMAIL_FROM;
        $subject = $mailing['name'];
        $to = $user['email'];

        if (mail($to, $subject, $body, $headers)) { // Если уведомление успешно отправлено, обновляем флаг "sent"
            $stmt_update = $pdo->prepare("UPDATE mailings SET sent = 1 WHERE id = :id");
            $stmt_update->bindParam(':id', $mailing['id']);
            $stmt_update->execute();
        }
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;

?>
