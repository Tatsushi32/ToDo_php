<?php

require(__DIR__ . "/./config.php");

// POSTデータかを判定
methodCheck();

$id_check = $_POST["id_check"];
$id = $_POST["id"];
$page = $_POST["page"];

// 意図したデータの削除かを判定
deleteDataCheck($id_check, $id);

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