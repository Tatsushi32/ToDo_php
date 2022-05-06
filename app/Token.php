<?php

class Token {
    public static function create() {
        if (!isset($_SESSION["token"])) {
            $_SESSION["token"] = bin2hex(random_bytes(32));
        }
    }
}