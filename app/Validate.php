<?php

Class Validate {
    public function title($title) {
        if ($title == "") {
            echo "タイトルを入力してください。<br>";
            return false;
        } elseif (mb_strlen($title) > 20) {
            echo "タイトルは20文字以内で入力してください。<br>";
            return false;
        } else {
            echo "タイトル：" . Utils::h($title) . "<br>";
        }
    }

    public function content($content) {
        if ($content == "") {
            echo "内容が入力されていません。<br>";
            return false;
        } else {
            echo "内容：" . Utils::h($content);
        }
    }

    public function hideResister() {
        
    }

    public function keyword() {

    }

    public function token() {
        
    }
}