<?php
require_once(__DIR__ . "/app/config.php");

// 検索文字の取得
if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
}

$todo = new Todo($keyword);
$pagenation = new PagenationSearch($keyword);

// ページネーション
$total_results = $pagenation->total_results;
$total_pages = $pagenation->total_pages;
$page = $pagenation->page;
$offset = $pagenation->offset;

// 検索結果の取得
$todos = $todo->getSearchResult($keyword, $offset);

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Result Page</title>
</head>
<body>
    <h1>検索結果</h1>

    <a href="index.php?page=1" style="text-decoration: none; color: black;">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">一覧に戻る</button>
    </a>
    <br />

    <!-- 検索ボックス -->
    <form action="" method="get">
        <input type="text" name="keyword" style="padding: 10px;font-size: 16px;margin-bottom: 10px" value=<?= Utils::h($keyword); ?>>
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
    </form>

    <!-- 検索結果が0件の場合 -->
    <?php if ($total_results == 0): ?>
        <h2>見つかりませんでした。</h2>
        <?= exit(); ?>
    <?php endif; ?>

    <!-- Todo一覧 -->
    <?php require_once(__DIR__ . "/show_todo.php"); ?>

    <!-- ページング -->
    <?php require_once(__DIR__ . "/pagenation.php"); ?>
</body>
</html>