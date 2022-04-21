<?php
class PagenationSearch extends PaginationAll {

    private $keyword;
    public $total_results;
    public $total_pages;

    public function __construct($keyword) {
        $this->connect();
        $this->keyword = $keyword;
        self::getTotalResults();
        self::getTotalPages();
        parent::getPresentPage();
        parent::getOffset();
    }

    public function getTotalResults() {
        $total_todo_sql = "SELECT count(*) FROM posts WHERE title LIKE :keyword";
        $stmt = $this->dbh->prepare($total_todo_sql);
        $stmt->bindValue(":keyword", "%{$this->keyword}%");
        $stmt->execute();
        $this->total_results = $stmt->fetchColumn();
    }

    public function getTotalPages() {
        $this->total_pages = ceil($this->total_results / TODO_PER_PAGE);
    }


}