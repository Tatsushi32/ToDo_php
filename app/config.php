<?php
// 1ページあたりのデータ
define("TODO_PER_PAGE", 5);

// データベース情報
define("DSN", "mysql:dbname=todo;host=localhost;charset=utf8mb4");
define("DB_USER", "root");
define("DB_PASS", "");

require_once(__DIR__ . "/Utils.php");
require_once(__DIR__ . "/functions.php");

?>