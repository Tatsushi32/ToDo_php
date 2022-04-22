<?php
$page_title = "Create Page";
require_once(__DIR__ . "/components/head.php");
?>
<body>
    <h1>
        Post New ToDo Page
    </h1>
    <form method="post" action="create_check.php">
        <div style="margin: 10px">
            <label for="title">タイトル：</label>
            <input id="title" type="text" name="title">
        </div>
        <div style="margin: 10px">
            <label for="content">内容：</label>
            <textarea id="content" name="content" rows="8" cols="40"></textarea>
        </div>
        <input type="submit" name="post" value="登録">
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>
</html>