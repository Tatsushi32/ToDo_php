<?php
require_once(__DIR__ . "/app/config.php");

$todo = new GetTodo();
$todos = $todo->getAll();
$page = $todo->present_page;
?>

<?php
$page_title = "Index Page";
require_once(__DIR__ . "/components/head.php");
?>

<body>
    <a href="?page=1" style="text-decoration: none; color: black;">
        <h1>ToDo List Page</h1>
    </a>

    <!-- 新規作成ボタン -->
    <form action="create.php">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button>
    </form>
    <br />

    <!-- 検索ボックス -->
    <?php require_once(__DIR__ . "/components/search_box.php"); ?>

    <!-- Todo一覧 -->
    <?php require_once(__DIR__ . "/components/show_todo.php"); ?>

    <!-- ページング -->
    <?php require_once(__DIR__ . "/components/pagination.php"); ?>
</body>
</html>