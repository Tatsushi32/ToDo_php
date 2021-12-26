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

<?php

try {
    $title = $_POST["title"];
    $contents = $_POST["contents"];

    // XSS対策
    $title = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
    $contents = htmlspecialchars($contents, ENT_QUOTES, "UTF-8");

    // データベース接続
    $dsn = "mysql:dbname=todo;host=localhost;charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO posts(title,content) VALUES (?,?)";
    $stmt = $dbh->prepare($sql);
    $data[] = $title;
    $data[] = $contents;
    $stmt->execute($data);

    // データベースから切断
    $dbh = null;

    echo "「" . $title . "」を追加しました。 <br />";
    echo "内容： <br />";
    echo $contents . "<br />";

} catch (Exeption $e){

    echo "ただいま障害によりご迷惑をおかけしております。 <br />";
    exit();
}

?>

<a href="index.php">戻る</a>

</body>
</html>