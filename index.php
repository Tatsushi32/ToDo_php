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

<?php

try {
    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id,title,content,created_at,updated_at FROM posts WHERE 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

} catch (Exeption $e) {

    echo "ただいま障害によりご迷惑をおかけしております。 <br />";
    exit();
}

?>

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
                    <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= $rec['id'] ;?>">編集する</button>
                </form>
            </td>
            <td>
                <form method="post" action="delete.php">
                    <button type="submit" name="id" style="padding: 10px;font-size: 16px;" value="<?= $rec['id'] ;?>">削除する</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table> 
</body>
</html>