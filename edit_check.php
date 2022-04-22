<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// トークン作成
Token::create();

// POSTデータかを判定
Method::check();

$token = $_SESSION['token'];
$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

// 検索結果画面からの場合
if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
}

?>

<?php
$page_title = "Edit Check Page";
require_once(__DIR__ . "/components/head.php");
?>
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
        <form method="post" action="edit_done.php">
            <!-- 検索結果画面からの遷移の場合 -->
            <?php if (isset($_POST["keyword"])): ?>
                <input type="hidden" name="keyword" value="<?= Utils::h($keyword); ?>">
            <?php endif; ?>
            <input type="hidden" name="token" value="<?= Utils::h($token); ?>">
            <input type="hidden" name="id" value="<?= Utils::h($id); ?>">
            <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
            <input type="hidden" name="title" value="<?= Utils::h($title); ?>">
            <input type="hidden" name="content" value="<?= Utils::h($content); ?>">
            <br />
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="更新">
        </form>
    <?php endif; ?>
</body>
</html>