<?php
require_once(__DIR__ . "/app/config.php");

// 検索文字の取得
if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
}

$todo = new GetTodo($keyword);
$todos = $todo->getSearchResult();
$page = $todo->present_page;
?>

<?php
$page_title = "Search Result Page";
require_once(__DIR__ . "/components/head.php");
?>

<body>
    <h1>検索結果</h1>

    <a href="index.php?page=1" style="text-decoration: none; color: black;">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">一覧に戻る</button>
    </a>
    <br />

    <!-- 検索ボックス -->
    <?php require_once(__DIR__ . "/components/search_box.php"); ?>

    <!-- 検索結果が0件の場合 -->
    <?php $todo->resultNone(); ?>

    <!-- Todo一覧 -->
    <?php require_once(__DIR__ . "/components/show_todo.php"); ?>

    <!-- ページング -->
    <?php require_once(__DIR__ . "/components/pagination.php"); ?>
</body>
</html>