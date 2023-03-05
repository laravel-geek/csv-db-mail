<?php

require_once 'config.php';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;

try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (($handle = fopen("users.csv", "r")) !== false) {

        $sql = "INSERT INTO users (number, name) VALUES (:number, :name)";
        $stmt = $pdo->prepare($sql);

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {

            $number = $data[0];
            $name = $data[1];

            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':name', $name);

            $stmt->execute();
        }
        fclose($handle);
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$pdo = null;
