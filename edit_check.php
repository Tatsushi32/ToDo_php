<?php

require("./functions.php");

// POSTデータかを判定
methodCheck();

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];

// XSS対策
$title = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
$content = htmlspecialchars($content, ENT_QUOTES, "UTF-8");

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Check Page</title>
</head>
<body>
    <!-- タイトルチェック -->
    <?php if ($title == ""): ?>
        <p>タイトルが入力されていません。</p>
    <?php elseif (mb_strlen($title) > 20): ?>
        <p>タイトルは20文字以内で入力してください。</p>
    <?php else: ?>
        <p>タイトル：<?= $title; ?></p>
    <?php endif; ?>

    <!-- 内容チェック -->
    <?php if ($content == ""): ?>
        <p>内容が入力されていません。</p>
    <?php else: ?>
        <p>内容：<?= $content; ?></p>
    <?php endif; ?>

    <?php if ($title == "" || $content == "" || mb_strlen($title) > 20): ?>
        <form>
            <input type='button' onclick='history.back()' value='戻る'>
        </form>
    <?php else: ?>
        <form method="post" action="edit_done.php">
        <input type="hidden" name="id" value=<?= $id; ?>>
        <input type="hidden" name="title" value=<?= $title; ?>>
        <input type="hidden" name="content" value=<?= $content; ?>>
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="登録">
        </form>
    <?php endif; ?>
</body>
</html>