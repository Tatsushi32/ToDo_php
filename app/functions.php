<?php

// ページネーション(一覧)
function pagination($dbh) {
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

    return [$page, $totalPages, $offset];
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
    $validateSql = "SELECT COUNT(*) FROM posts WHERE id=?";
    $stmt = $dbh->prepare($validateSql);
    $validate[] = $id;
    $stmt->execute($validate);
    $validateId = $stmt->fetchColumn();

    if ($validateId == 0) {
        exit("Invalid post request");
    }

    $sql = "DELETE FROM posts WHERE id=?";
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
}

// ページネーション(検索結果)
function searchResultPagination($dbh, $keyword) {
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

    return [$page, $total_results, $total_pages, $offset];
}

// 検索結果の取得
function getSearchResult($dbh, $keyword, $offset) {
    $sql = "SELECT * FROM posts WHERE title like ? limit ". $offset . "," . TODO_PER_PAGE;
    $stmt = $dbh->prepare($sql);
    $data[] = "%" . $keyword . "%";
    $stmt->execute($data);
    $todos = $stmt->fetchAll();
    return $todos;
}

?>