<?php

class Pagination {
    private $db_manager;
    
    public function __construct() {
        $this->db_manager = new Database();
        $this->db_manager->connect();
    }

    // ページネーション
    public function pagination($keyword=null) {

        if (is_null($keyword)) {
            $total_todos = $this->db_manager->dbh->query("SELECT count(*) FROM posts")->fetchColumn();
            $total_pages = ceil($total_todos / TODO_PER_PAGE);
        }

        if (isset($keyword)) {
            $total_todo_sql = "SELECT count(*) FROM posts WHERE title LIKE :keyword";
            $stmt = $this->db_manager->dbh->prepare($total_todo_sql);
            $stmt->bindValue(":keyword", "%{$keyword}%");
            $stmt->execute();

            $total_results = $stmt->fetchColumn();
            $total_pages = ceil($total_results / TODO_PER_PAGE);
        }

        // ページ数取得。GETで渡ってこない場合は1を格納
        if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
            // urlのページ数が実際のページ数より多い場合、最後のページを格納
            if ($_GET['page'] > $total_pages) {
                $page = $total_pages;
            } else {
                $page = (int)$_GET["page"];
            }
        } else {
            $page = 1;
        }

        // データ取得スタート位置
        $offset = TODO_PER_PAGE * ($page - 1);

        if (is_null($keyword)) {
            return [$page, $total_pages, $offset];
        }
        if (isset($keyword)) {
            return [$page, $total_results, $total_pages, $offset];
        }
    }
}