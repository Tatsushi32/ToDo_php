<?php
 class Method {
    public static function check() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            exit("Invalid Request");
        }
    }
 }