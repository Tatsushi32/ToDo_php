<?php

class GetTodo extends Database {
    public $offset;
    public $present_page;
    private $keyword;
    private $total_results;

    public function __construct($keyword=null) {
        $this->connect();
        $this->keyword = isset($keyword) ? $keyword : null;
        $pagination = isset($keyword) ? new PaginationSearch($keyword) : new PaginationAll();
        $this->total_results = isset($keyword) ? $pagination->total_results : null;
        $this->offset = $pagination->getOffset();
        $this->present_page = $pagination->page;
    }

    public function getAll() {
        $sql = "SELECT * FROM posts limit " . $this->offset . "," . TODO_PER_PAGE;
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $todos = $stmt->fetchAll();
        return $todos;
    }

    public function getSearchResult() {
        $sql = "SELECT * FROM posts WHERE title LIKE :keyword LIMIT ". $this->offset . "," . TODO_PER_PAGE;
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":keyword", "%{$this->keyword}%");
        $stmt->execute();
        $todos = $stmt->fetchAll();
        return $todos;
    }

    public function resultNone() {
        if ($this->total_results == 0) {
            echo "<h2>見つかりませんでした。</h2>";
            exit();
        }
    }
}