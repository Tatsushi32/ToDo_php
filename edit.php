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

    $sql = "SELECT title,content FROM posts WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $rec["title"];
    $content = $rec["content"];

    $dbh = null;

} catch (Exeption $e) {

    echo "ただいま障害によりご迷惑をおかけしております。 <br />";
    exit();
}

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Page</title>
</head>
<body>
    <h1>
        Edit Todo Page
    </h1>
    <form method="post" action="edit_check.php">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="page" value="<?= $page; ?>">
        <div style="margin: 10px">
            <label for="title">タイトル：</label>
            <input id="title" type="text" name="title" value="<?= $title; ?>">
        </div>
        <div style="margin: 10px">
            <label for="content">内容：</label>
            <textarea id="content" name="content" rows="8" cols="40"><?= $content; ?></textarea>
        </div>
        <input type="submit" value="OK">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>