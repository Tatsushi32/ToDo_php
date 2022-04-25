<?php

Class Validate {

    private $text;
    private $area;

    public static function token() {
        if (empty($_SESSION["token"]) || $_SESSION["token"] !== filter_input(INPUT_POST, "token")) {
            exit("Invalid post request");
        }
    }

    // POST送信
    public static function method() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            exit("Invalid Request");
        }
    }

    public function title($title) {
        $this->area = "タイトル";
        $this->text = $title;
        $this->textNone();
        $this->length();
        echo "タイトル：" . Utils::h($this->text) . "<br>";
    }

    public function content($content) {
        $this->area = "内容";
        $this->text = $content;
        $this->textNone();
        echo "内容：" . Utils::h($content);
    }

    public function textNone() {
        if ($this->text === "") {
            echo $this->area . "を入力してください<br>";
            echo "<input type='button' onclick='history.back()' value='戻る'>";
            exit();
        }
    }

    public function length() {
        if (mb_strlen($this->text) > 20) {
            echo $this->area . "は20文字以内で入力してください<br>";
            echo "<input type='button' onclick='history.back()' value='戻る'>";
            exit();
        }
    }
}