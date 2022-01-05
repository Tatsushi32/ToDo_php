<?php

// エスケープ処理
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// POSTデータかの確認
function methodCheck() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit("Invalid Request");
    }
}

// トークン作成
function createToken() {
    if (!isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32));
    }
}

// トークン確認
function validateToken() {
    // セッションが空か、送信されたトークンが一致しない場合
    if (empty($_SESSION["token"]) || $_SESSION["token"] !== filter_input(INPUT_POST, "token")) {
        exit("Invalid post request");
    }
}

// データベース接続
function connectDb() {
    try {
        $dbh = new PDO(
            DSN, 
            DB_USER, 
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $dbh;
    
    } catch (Exeption $e) {
    
        echo "ただいま障害によりご迷惑をおかけしております。 <br />";
        header("Location: index.php");
        exit();
    }
}

// todo一覧(ページング)
function getTodos($dbh) {

    $totalTodos = $dbh->query("SELECT count(*) FROM posts")->fetchColumn();
    $totalPages = ceil($totalTodos / TODO_PER_PAGE);

    // ページ数取得。GETで渡ってこない場合は1を格納
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        // urlのページ数が実際のページ数より多い場合、最後のページを格納
        if ($_GET['page'] > $totalPages) {
            $page = $totalPages;
        } else {
            $page = (int)$_GET["page"];
        }
    } else {
        $page = 1;
    }

    // データ取得スタート位置
    $offset = TODO_PER_PAGE * ($page - 1);

    $sql = "SELECT id,title,content,created_at,updated_at FROM posts WHERE 1 limit " . $offset . "," . TODO_PER_PAGE;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $todos = $stmt->fetchAll();
    return [$page, $totalPages, $todos];
}

// 新規作成
function createTodo($dbh, $title, $content) {
    $sql = "INSERT INTO posts(title,content) VALUES (?,?)";
    $stmt = $dbh->prepare($sql);
    $data[] = $title;
    $data[] = $content;
    $stmt->execute($data);
}

// 編集するtodoの選択
function selectTodo($dbh, $id) {
    $sql = "SELECT title,content FROM posts WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
    $selected_todo = $stmt->fetch();
    return $selected_todo;
}

// 更新
function updateTodo($dbh, $title, $content, $id) {
    $sql = "UPDATE posts SET title=?, content=? WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $title;
    $data[] = $content;
    $data[] = $id;
    $stmt->execute($data);
}

// 削除
function deleteTodo($dbh, $id) {
    $sql = "DELETE FROM posts WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
}

// 検索結果の取得(ページング)
function getSearchResult($dbh, $keyword) {
    $total_todo_sql = "SELECT count(*) FROM posts WHERE title like ?";
    $stmt = $dbh->prepare($total_todo_sql);
    $keywords[] = "%" . $keyword . "%";
    $stmt->execute($keywords);

    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / TODO_PER_PAGE);

    // ページ数取得。GETで渡ってこない場合は1を格納
    if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
        // urlに表記されているページ数が実際のページ数より多い場合、最後のページを格納
        if ($_GET["page"] > $total_pages) {
            $page = $total_pages;
        } else {
            $page = (int)$_GET["page"];
        }
    } else {
        $page = 1;
    }

    // データ取得スタート位置
    $offset = TODO_PER_PAGE * ($page - 1);

    $sql = "SELECT * FROM posts WHERE title like ? limit ". $offset . "," . TODO_PER_PAGE;
    $stmt = $dbh->prepare($sql);
    $data[] = "%" . $keyword . "%";
    $stmt->execute($data);
    $todos = $stmt->fetchAll();
    return [$page, $total_results, $total_pages, $todos];
}

?>