<?php
require_once(__DIR__ . "/app/config.php");

// データベース接続
$dbh = connectDb();

// ページネーション
$pagenation = pagination($dbh);
$page = $pagenation[0];
$total_pages = $pagenation[1];
$offset = $pagenation[2];

// Todo情報の取得
$todos = getTodos($dbh, $offset);

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index Page</title>
</head>
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
    <form action="search_result.php" method="get">
        <input type="text" name="keyword" style="padding: 10px;font-size: 16px;margin-bottom: 10px">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
    </form>

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
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">編集する</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="page" value="<?= Utils::h($page); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= Utils::h($todo->id); ?>">削除する</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> 

    <!-- ページング -->
    <?php if ($page > 1): ?>
        <a href="?page=<?= Utils::h($page)-1 ?>">前へ</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= Utils::h($i); ?>"><?= Utils::h($i); ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= Utils::h($i); ?>"><?= Utils::h($i); ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= Utils::h($page)+1 ?>">次へ</a>
    <?php endif; ?>
</body>
</html>