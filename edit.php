<?php

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
Validate::method();

$id = $_POST["id"];
$page = $_POST["page"];

// 検索結果画面からの場合
$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : null;

$todo = new Todo();
$selected_todo = $todo->get($id);

?>

<?php
$page_title = "Edit Page";
require_once(__DIR__ . "/components/head.php");
?>
<body>
    <h1>
        Edit Todo Page
    </h1>
    <form method="post" action="edit_check.php">
        <!-- 検索結果画面からの遷移の場合 -->
        <?php if ($keyword): ?>
            <input type="hidden" name="keyword" value="<?= Utils::h($keyword); ?>">
        <?php endif; ?>
        <input type="hidden" name="id" value="<?= Utils::h($id); ?>">
        <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
        <div style="margin: 10px">
            <label for="title">タイトル：</label>
            <input id="title" type="text" name="title" value="<?= Utils::h($selected_todo->title); ?>">
        </div>
        <div style="margin: 10px">
            <label for="content">内容：</label>
            <textarea id="content" name="content" rows="8" cols="40"><?= Utils::h($selected_todo->content); ?></textarea>
        </div>
        <input type="submit" value="OK">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>