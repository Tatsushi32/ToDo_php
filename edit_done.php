<?php
session_start();

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
Validate::method();

// トークン判別
Validate::token();

$id = $_POST["id"];
$page = $_POST["page"];
$title = $_POST["title"];
$content = $_POST["content"];

// 検索結果画面からの場合
$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : null;

$todo = new Todo();
$todo->update($title, $content, $id);

?>

<?php
$page_title = "Edit Done Page";
require_once(__DIR__ . "/components/head.php");
?>
<body>

<p>修正しました。</p>
<br />

<!-- 編集ボタンを押したもとの画面に戻る -->
<?php if ($keyword): ?>
    <a href="search_result.php?page=<?= Utils::h($page); ?>&keyword=<?= Utils::h($keyword); ?>">戻る</a>
<?php else: ?>
    <a href="index.php?page=<?= Utils::h($page); ?>">戻る</a>
<?php endif; ?>

</body>
</html>