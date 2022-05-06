<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
Validate::method();

// トークン判別
Validate::token();

$title = $_POST["title"];
$content = $_POST["content"];

$todo = new Todo();
$todo->create($title, $content);

?>

<?php
$page_title = "Create Done Page";
require_once(__DIR__ . "/components/head.php");
?>
<body>
    <p>「<?= Utils::h($title); ?>」を追加しました。</p>
    <p>内容：<?= Utils::h($content); ?></p>

    <a href="index.php?page=1">戻る</a>
</body>
</html>