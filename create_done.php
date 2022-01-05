<?php
session_start();

require(__DIR__ . "/./config.php");

// POSTデータかを判定
methodCheck();

// トークン判別
validateToken();

$title = $_POST["title"];
$content = $_POST["content"];

// データベース接続
$dbh = connectDb();

// 新規todo作成
createTodo($dbh, $title, $content);

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Check Page</title>
</head>
<body>
    <p>「<?= h($title); ?>」を追加しました。</p>
    <p>内容：<?= h($content); ?></p>

    <a href="index.php?page=1">戻る</a>
</body>
</html>