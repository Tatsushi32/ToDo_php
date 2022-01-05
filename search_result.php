<?php
require(__DIR__ . "/./config.php");

// 検索文字の取得
if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
}

// データベース接続
$dbh = connectDb();

// 検索結果の取得
$SearchResults = getSearchResult($dbh, $keyword);
$page = $SearchResults[0];
$total_results = $SearchResults[1];
$total_pages = $SearchResults[2];
$todos = $SearchResults[3];

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
        <input type="text" name="keyword" style="padding: 10px;font-size: 16px;margin-bottom: 10px" value=<?= h($keyword); ?>>
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
    </form>

    <!-- 検索結果が0件の場合 -->
    <?php if ($total_results == 0): ?>
        <h2>見つかりませんでした。</h2>
        <?= exit(); ?>
    <?php endif; ?>

    <!-- Todo一覧 -->
    <table border="1">
        <colgroup span="4"></colgroup>
        <tr>
            <th>タイトル</th>
            <th>内容</th>
            <th>作成日時</th>
            <th>更新日時</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        <?php foreach ($todos as $todo): ?>
            <tr>
                <td><?= h($todo->title); ?></td>
                <td><?= h($todo->content); ?></td>
                <td><?= h($todo->created_at); ?></td>
                <td><?= h($todo->updated_at); ?></td>
                <td>
                    <form method="post" action="edit.php">
                        <input type="hidden" name="page" value="<?= h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= h($todo->id); ?>">編集する</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="page" value="<?= h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= h($todo->id); ?>">削除する</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> 

    <!-- ページング -->
    <?php if ($page > 1): ?>
        <a href="?page=<?= h($page)-1 ?>&keyword=<?= h($keyword); ?>">前へ</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= h($i); ?>&keyword=<?= h($keyword); ?>"><?= h($i); ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= h($i); ?>&keyword=<?= h($keyword); ?>"><?= h($i); ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= h($page)+1 ?>&keyword=<?= h($keyword); ?>">次へ</a>
    <?php endif; ?>
</body>
</html>