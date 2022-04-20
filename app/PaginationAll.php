<?php

class PaginationAll extends Database{

    public function __construct() {
        $this->connect();
    }

    public function getAllTodo() {
        $total_todo_sql = "SELECT count(*) FROM posts";
        $get_total_todos = $this->dbh->query($total_todo_sql);
        $total_results = $get_total_todos->fetchColumn();
        $total_pages = ceil($total_results / TODO_PER_PAGE);
        return $total_pages;
    }
    
    public function getPresentPage($total_pages) {
        if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
            $page = (int)$_GET["page"];
        } else {
            $page = 1;
        }
        return $page;
    }

    public function getOffset($page) {
        $offset = TODO_PER_PAGE * ($page - 1);
        return $offset;
    }
}