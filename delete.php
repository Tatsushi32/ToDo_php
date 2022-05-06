<?php

require_once(__DIR__ . "/app/config.php");

// POSTデータかを判定
Validate::method();

$id = $_POST["id"];
$page = $_POST["page"];

// 検索結果画面からの場合
$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : null;

$todo = new Todo();
$todo->delete($id);

// 削除を実行した画面に戻る
if ($keyword) {
    header("Location: search_result.php?page=" . $page . "&keyword=" . $keyword);
} else {
    header("Location: index.php?page=" . $page);
}
exit();