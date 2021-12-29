<?php
session_start();

require("./functions.php");

// トークン作成
createToken();

// POSTデータかを判定
methodCheck();

if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
    $keyword = htmlspecialchars($keyword, ENT_QUOTES, "UTF-8");
}

$token = $_SESSION['token'];
$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

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
        <p>タイトル：<?= h($title); ?></p>
    <?php endif; ?>

    <!-- 内容チェック -->
    <?php if ($content == ""): ?>
        <p>内容が入力されていません。</p>
    <?php else: ?>
        <p>内容：<?= h($content); ?></p>
    <?php endif; ?>

    <?php if ($title == "" || $content == "" || mb_strlen($title) > 20): ?>
        <form>
            <input type='button' onclick='history.back()' value='戻る'>
        </form>
    <?php else: ?>
        <form method="post" action="edit_done.php">
            <!-- 検索結果画面からの遷移の場合 -->
            <?php if (isset($_POST["keyword"])): ?>
                <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
            <?php endif; ?>
            <input type="hidden" name="token" value="<?= h($token); ?>">
            <input type="hidden" name="id" value="<?= h($id); ?>">
            <input type="hidden" name="page" value="<?= h($page); ?>">
            <input type="hidden" name="title" value="<?= h($title); ?>">
            <input type="hidden" name="content" value="<?= h($content); ?>">
            <br />
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="更新">
        </form>
    <?php endif; ?>
</body>
</html>