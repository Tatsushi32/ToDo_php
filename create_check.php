<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// トークン作成
createToken();

// POSTデータかを判定
methodCheck();

$title = $_POST["title"];
$content = $_POST["content"];
$token = $_SESSION['token'];

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
    <!-- タイトルチェック -->
    <?php if ($title == ""): ?>
        <p>タイトルが入力されていません。</p>
    <?php elseif (mb_strlen($title) > 20): ?>
        <p>タイトルは20文字以内で入力してください。</p>
    <?php else: ?>
        <p>タイトル：<?= Utils::h($title); ?></p>
    <?php endif; ?>

    <!-- 内容チェック -->
    <?php if ($content == ""): ?>
        <p>内容が入力されていません。</p>
    <?php else: ?>
        <p>内容：<?= Utils::h($content); ?></p>
    <?php endif; ?>

    <!-- 条件を満たしていなければ戻るボタンのみ表示 -->
    <?php if ($title == "" || $content == "" || mb_strlen($title) > 20): ?>
        <form>
            <input type='button' onclick='history.back()' value='戻る'>
        </form>
    <?php else: ?>
        <form method="post" action="create_done.php">
            <input type="hidden" name="token" value="<?= Utils::h($token); ?>">
            <input type="hidden" name="title" value="<?= Utils::h($title); ?>">
            <input type="hidden" name="content" value="<?= Utils::h($content); ?>">
            <br />
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="登録">
        </form>
    <?php endif; ?>
</body>
</html>