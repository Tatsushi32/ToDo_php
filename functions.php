<?php

// エスケープ処理
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function methodCheck() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit("Invalid Request");
    }
}

function createToken() {
    if (!isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32));
    }
}

function validateToken() {
    // セッションが空か、送信されたトークンが一致しない場合
    if (empty($_SESSION["token"]) || $_SESSION["token"] !== filter_input(INPUT_POST, "token")) {
        exit("Invalid post request");
    }
}

?>