<?php

require(__DIR__ . "/./config.php");

// POSTデータかを判定
methodCheck();

$id = $_POST["id"];
$page = $_POST["page"];

// 検索結果画面からの場合
if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
}

// データベース接続
$dbh = connectDb();

// 選択したtodoの情報取得
$selected_todo = selectTodo($dbh, $id);

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
        <!-- 検索結果画面からの遷移の場合 -->
        <?php if (isset($_POST["keyword"])): ?>
            <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
        <?php endif; ?>
        <input type="hidden" name="id" value="<?= h($id); ?>">
        <input type="hidden" name="page" value="<?= h($page); ?>">
        <div style="margin: 10px">
            <label for="title">タイトル：</label>
            <input id="title" type="text" name="title" value="<?= h($selected_todo->title); ?>">
        </div>
        <div style="margin: 10px">
            <label for="content">内容：</label>
            <textarea id="content" name="content" rows="8" cols="40"><?= h($selected_todo->content); ?></textarea>
        </div>
        <input type="submit" value="OK">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>