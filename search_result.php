<?php
require_once(__DIR__ . "/app/config.php");

// 検索文字の取得
if (isset($_GET["keyword"])) {
    $keyword = $_GET["keyword"];
}

// データベース接続
$dbh = connectDb();

// ページネーション
$pagination = searchResultPagination($dbh, $keyword);
$page = $pagination[0];
$total_results = $pagination[1];
$total_pages = $pagination[2];
$offset = $pagination[3];

// 検索結果の取得
$todos = getSearchResult($dbh, $keyword, $offset);

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
                <td><?= Utils::h($todo->title); ?></td>
                <td><?= Utils::h($todo->content); ?></td>
                <td><?= Utils::h($todo->created_at); ?></td>
                <td><?= Utils::h($todo->updated_at); ?></td>
                <td>
                    <form method="post" action="edit.php">
                        <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= Utils::h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">編集する</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= Utils::h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">削除する</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> 

    <!-- ページング -->
    <?php if ($page > 1): ?>
        <a href="?page=<?= Utils::h($page)-1 ?>&keyword=<?= Utils::h($keyword); ?>">前へ</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= Utils::h($i); ?>&keyword=<?= Utils::h($keyword); ?>"><?= Utils::h($i); ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= Utils::h($i); ?>&keyword=<?= Utils::h($keyword); ?>"><?= Utils::h($i); ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= Utils::h($page)+1 ?>&keyword=<?= Utils::h($keyword); ?>">次へ</a>
    <?php endif; ?>
</body>
</html>