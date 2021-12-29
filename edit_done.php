<?php
session_start();

require("./functions.php");

// POSTデータかを判定
methodCheck();

// トークン判別
validateToken();

try {
    
    if (isset($_POST["keyword"])) {
        $keyword = $_POST["keyword"];
    }

    $id = $_POST["id"];
    $page = $_POST["page"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE posts SET title=?, content=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $title;
    $data[] = $content;
    $data[] = $id;
    $stmt->execute($data);

    // データベースから切断
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
    <title>Create Check Page</title>
</head>
<body>

<p>修正しました。</p>
<br />

<!-- 検索結果画面からの遷移の場合 -->
<?php if (isset($_POST["keyword"])): ?>
    <a href="search_result.php?page=<?= h($page); ?>&keyword=<?= h($keyword); ?>">戻る</a>
<?php else: ?>
    <a href="index.php?page=<?= h($page); ?>">戻る</a>
<?php endif; ?>

</body>
</html>