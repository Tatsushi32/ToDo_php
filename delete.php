<?php

require("./functions.php");

// POSTデータかを判定
methodCheck();

try {

    $id = $_POST["id"];
    $page = $_POST["page"];

    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM posts WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);

    $dbh = null;
    
    header("Location: index.php?page=" . $page);
    exit();

} catch (Exeption $e) {

    echo "ただいま障害によりご迷惑をおかけしております。 <br />";
    header("Location: index.php");
    exit();
}

?>