<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// トークン作成
Token::create();

// POSTデータかを判定
Validate::method();

$title = $_POST["title"];
$content = $_POST["content"];
$token = $_SESSION['token'];

$validate = new Validate();
$validate->title($title);
$validate->content($content);

?>


<?php
$page_title = "Search Check Page";
require_once(__DIR__ . "/components/head.php");
?>

<body>
    <form method="post" action="create_done.php">
        <input type="hidden" name="token" value="<?= Utils::h($token); ?>">
        <input type="hidden" name="title" value="<?= Utils::h($title); ?>">
        <input type="hidden" name="content" value="<?= Utils::h($content); ?>">
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="登録">
    </form>
</body>
</html>