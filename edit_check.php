<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// トークン作成
Token::create();

// POSTデータかを判定
Validate::method();

$token = $_SESSION['token'];
$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

// 検索結果画面からの場合、keywordをセット
$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : null;

$validate = new Validate();
$validate->title($title);
$validate->content($content);

?>

<?php
$page_title = "Edit Check Page";
require_once(__DIR__ . "/components/head.php");
?>
<body>
    <form method="post" action="edit_done.php">
        <!-- 検索結果画面からの遷移の場合 -->
        <?php if ($keyword): ?>
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
</body>
</html>