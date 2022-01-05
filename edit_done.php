<?php
session_start();

require(__DIR__ . "/./config.php");

// POSTデータかを判定
methodCheck();

// トークン判別
validateToken();

$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

// 検索結果画面からの場合
if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
}

// データベース接続
$dbh = connectDb();

// todo更新
updateTodo($dbh, $title, $content, $id);

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

<p>修正しました。</p>
<br />

<!-- 編集ボタンを押したもとの画面に戻る -->
<?php if (isset($_POST["keyword"])): ?>
    <a href="search_result.php?page=<?= h($page); ?>&keyword=<?= h($keyword); ?>">戻る</a>
<?php else: ?>
    <a href="index.php?page=<?= h($page); ?>">戻る</a>
<?php endif; ?>

</body>
</html>