<?php
define("TODO_PER_PAGE", 5);

try {
    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 合計のtodo数とページ数取得
    $total = $dbh->query("SELECT count(*) FROM posts")->fetchColumn();
    $totalPages = ceil($total / TODO_PER_PAGE);

    // ページ数取得。GETで渡ってこない場合は1を格納
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        // urlに表記されているページ数が実際のページ数より多い場合、最後のページを格納
        if ($_GET['page'] > $totalPages) {
            $page = $totalPages;
        } else {
            $page = (int)$_GET["page"];
        }
    } else {
        $page = 1;
    }

    $offset = TODO_PER_PAGE * ($page - 1);
    $sql = "SELECT id,title,content,created_at,updated_at FROM posts WHERE 1 limit " . $offset . "," . TODO_PER_PAGE;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

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
    <title>Index Page</title>
</head>
<body>
    <h1>
        ToDo List Page
    </h1>
    <form action="create.php">
        <button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button>
    </form>


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
                <td><?= $rec['title']; ?></td>
                <td><?= $rec['content']; ?></td>
                <td><?= $rec['created_at']; ?></td>
                <td><?= $rec['updated_at']; ?></td>
                <td>
                    <form method="post" action="edit.php">
                        <input type="hidden" name="page" value="<?= $page; ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= $rec['id']; ?>">編集する</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="page" value="<?= $page; ?>">
                        <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= $rec['id']; ?>">削除する</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table> 
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>">前へ</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($page == $i): ?>
            <strong><a href="?page=<?= $i; ?>"><?= $i; ?></a></strong>
        <?php else: ?>
            <a href="?page=<?= $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>">次へ</a>
    <?php endif; ?>
</body>
</html>