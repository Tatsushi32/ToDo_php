<?php

try {

    $id = $_POST["id"];

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
    
    header("Location: index.php");

} catch (Exeption $e) {

    echo "ただいま障害によりご迷惑をおかけしております。 <br />";
    header("Location: index.php");
    exit();
}

?>