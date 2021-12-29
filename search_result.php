<?php
require("./functions.php");

define("TODO_PER_PAGE", 5);

try {

    if (isset($_GET["keyword"])) {
        $keyword = $_GET["keyword"];
    }

    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 合計のtodo数とページ数取得
    $total_todo_sql = "SELECT count(*) FROM posts WHERE title like ?";
    $stmt = $dbh->prepare($total_todo_sql);
    $keywords[] = "%" . $keyword . "%";
    $stmt->execute($keywords);
    
    $total = $stmt->fetchColumn();
    $totalPages = ceil($total / TODO_PER_PAGE);

    // ページ数取得。GETで渡ってこない場合は1を格納
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        // urlに表記されているページ数が実際のページ数より多い場合、最後のページを格納
        if ($_GET["page"] > $totalPages) {
            $page = $totalPages;
        } else {
            $page = (int)$_GET["page"];
        }
    } else {
        $page = 1;
    }

    $offset = TODO_PER_PAGE * ($page - 1);
    $sql = "SELECT * FROM posts WHERE title like ? limit ". $offset . "," . TODO_PER_PAGE;
    $stmt = $dbh->prepare($sql);
    $data[] = "%" . $keyword . "%";
    $stmt->execute($data);

    $dbh = null;

} catch (Exeption $e) {

   echo "ただいま障害によりご迷惑をおかけしております。 <br />";
   exit();
}

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
    <form action="" method="get">
        <input type="text" name="keyword" style="padding: 10px;font-size: 16px;margin-bottom: 10px" value=<?= h($keyword); ?>>
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">Search Todo</button>
    </form>

    <!-- 検索結果が0件の場合 -->
    <?php if ($total == 0): ?>
        <h2>見つかりませんでした。</h2>
        <?= exit(); ?>
    <?php endif; ?>

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

        <?php while (true): ?>
            <?php $rec = $stmt->fetch(PDO::FETCH_ASSOC); ?>
            <?php if ($rec == false): ?>
                <?php break; ?>
            <?php endif; ?>
            <tr>
                <td><?= h($rec["title"]); ?></td>
                <td><?= h($rec["content"]); ?></td>
                <td><?= h($rec["created_at"]); ?></td>
                <td><?= h($rec["updated_at"]); ?></td>
                <td>
                    <form method="post" action="edit.php">
                        <input type="hidden" name="page" value="<?= h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= h($rec["id"]); ?>">編集する</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="page" value="<?= h($page); ?>">
                        <input type="hidden" name="keyword" value="<?= h($keyword); ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= h($rec["id"]); ?>">削除する</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table> 
    <?php if ($page > 1): ?>
        <a href="?page=<?= h($page)-1 ?>&keyword=<?= h($keyword); ?>">前へ</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= h($i); ?>&keyword=<?= h($keyword); ?>"><?= h($i); ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= h($i); ?>&keyword=<?= h($keyword); ?>"><?= h($i); ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= h($page)+1 ?>&keyword=<?= h($keyword); ?>">次へ</a>
    <?php endif; ?>
</body>
</html>