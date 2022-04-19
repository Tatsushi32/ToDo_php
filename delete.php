<?php

require_once(__DIR__ . "/./config.php");

// POSTデータかを判定
methodCheck();

$id = $_POST["id"];
$page = $_POST["page"];

// 検索結果画面からの場合
if (isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];
}

// データベース接続
$dbh = connectDb();

// todo削除
deleteTodo($dbh, $id);

// 削除を実行した画面に戻る
if (isset($_POST["keyword"])) {
    header("Location: search_result.php?page=" . $page . "&keyword=" . $keyword);
} else {
    header("Location: index.php?page=" . $page);
}
exit();
?>