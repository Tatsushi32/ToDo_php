<?php
require_once(__DIR__ . "/app/config.php");

$todo = new Todo();
$todos = $todo->getAll();
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index Page</title>
</head>
<body>
    <a href="?page=1" style="text-decoration: none; color: black;">
        <h1>ToDo List Page</h1>
    </a>

    <!-- 新規作成ボタン -->
    <form action="create.php">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button>
    </form>
    <br />

    <!-- 検索ボックス -->
    <form action="search_result.php" method="get">
        <input type="text" name="keyword" style="padding: 10px;font-size: 16px;margin-bottom: 10px">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
    </form>

    <!-- Todo一覧 -->
    <?php require_once(__DIR__ . "/show_todo.php"); ?>

    <!-- ページング -->
    <?php require_once(__DIR__ . "/pagenation.php"); ?>
</body>
</html>