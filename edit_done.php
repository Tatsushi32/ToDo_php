<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
MEthod::check();

// トークン判別
Token::validate();

$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

// 検索結果画面からの場合
if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
}

$todo = new Todo();
$todo->update($title, $content, $id);

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
    <a href="search_result.php?page=<?= Utils::h($page); ?>&keyword=<?= Utils::h($keyword); ?>">戻る</a>
<?php else: ?>
    <a href="index.php?page=<?= Utils::h($page); ?>">戻る</a>
<?php endif; ?>

</body>
</html>