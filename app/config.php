<?php
// 1ページあたりのデータ
define("TODO_PER_PAGE", 5);

// データベース情報
define("DSN", "mysql:dbname=todo;host=localhost;charset=utf8mb4");
define("DB_USER", "root");
define("DB_PASS", "");

spl_autoload_register(function ($class) {
    $fileName = sprintf(__DIR__ . "/%s.php", $class);
    if (file_exists($fileName === false)) {
        echo "File not found: " . $fileName;
        exit;
    }
    require($fileName);
});