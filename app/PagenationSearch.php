<?php
class PagenationSearch extends PaginationAll {

    private $keyword;

    public function __construct($keyword) {
        $this->connect();
        $this->keyword = $keyword;
    }

    public function getTotalResults() {
        $total_todo_sql = "SELECT count(*) FROM posts WHERE title LIKE :keyword";
        $stmt = $this->dbh->prepare($total_todo_sql);
        $stmt->bindValue(":keyword", "%{$this->keyword}%");
        $stmt->execute();
        $total_results = $stmt->fetchColumn();
        return $total_results;
    }

    public function getTotalPages($total_results) {
        $total_pages = ceil($total_results / TODO_PER_PAGE);
        return $total_pages;
    }


}