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
$title = $_POST['title'];
$contents = $_POST['contents'];

// XSS対策
$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
$contents = htmlspecialchars($contents, ENT_QUOTES, 'UTF-8');

if ($title == "") {
    echo "タイトルが入力されていません。 <br />";
} else {
    echo "タイトル：" . $title . "<br />";
}

if ($contents == "") {
    echo "内容が入力されていません。 <br />";
} else {
    echo "内容： <br />";
    echo $contents . "<br />";
}

if ($title == "" || $contents == "") {
    echo "<form>";
    echo "<input type='button' onclick='history.back()' value='戻る'>";
    echo "</form>";
} else {
    echo "<form method='post' action='create_done.php'>";
    echo "<input type='hidden' name='title' value='".$title."'>";
    echo "<input type='hidden' name='contents' value='".$contents."'>";
    echo "<br />";
    echo "<input type='button' onclick='history.back()' value='戻る'>";
    echo "<input type='submit' value='登録'>";
    echo "</form>";
}

?>
</body>
</html>