<?php

class PaginationAll extends Database{

    public $total_pages;
    public $page;
    public $offset;

    public function __construct() {
        $this->connect();
        self::getAllTodo();
        self::getPresentPage();
        self::getOffset();
    }

    public function getAllTodo() {
        $total_todo_sql = "SELECT count(*) FROM posts";
        $get_total_todos = $this->dbh->query($total_todo_sql);
        $total_results = $get_total_todos->fetchColumn();
        $this->total_pages = ceil($total_results / TODO_PER_PAGE);
    }
    
    public function getPresentPage() {
        if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
            $this->page = (int)$_GET["page"];
        } else {
            $this->page = 1;
        }
    }

    public function getOffset() {
        $this->offset = TODO_PER_PAGE * ($this->page - 1);
    }
}