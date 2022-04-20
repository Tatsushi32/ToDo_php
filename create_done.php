<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
Method:: check();

// トークン判別
Token::validate();

$title = $_POST["title"];
$content = $_POST["content"];

$todo = new Todo();
$todo->create($title, $content);

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
    <p>「<?= Utils::h($title); ?>」を追加しました。</p>
    <p>内容：<?= Utils::h($content); ?></p>

    <a href="index.php?page=1">戻る</a>
</body>
</html>