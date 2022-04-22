<?php

class PaginationAll extends Database{

    public $total_pages;
    public $page;

    public function __construct() {
        $this->connect();
        $this->getAllTodo();
        $this->getPresentPage();
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
        return $this->offset;
    }
    
    public function showPagination() {
        if ($this->page > 1) {
            $this->showPrevious();
        }
        $this->showPages();
        if ($this->page < $this->total_pages) {
            $this->showNext();
        }
    }

    public function showPrevious() {
        echo '<a href="?page=' . Utils::h($this->page-1) . '">前へ</a>';
    }

    public function showNext() {
        echo '<a href="?page=' . Utils::h($this->page+1) . '">次へ</a>';
    }

    public function showPages() {
        for ($i = 1; $i <= Utils::h($this->total_pages); $i++) {
            echo '<a href="?page=' . $i . '">' . $i . '</a>';
        }
    }
}