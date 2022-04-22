<?php
class PaginationSearch extends PaginationAll {

    private $keyword;
    public $total_results;

    public function __construct($keyword) {
        $this->connect();
        $this->keyword = $keyword;
        $this->getTotalResults();
        $this->getTotalPages();
        $this->getPresentPage();
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

    public function showPrevious() {
        echo '<a href="?page=' . Utils::h($this->page-1) . '&keyword=' . Utils::h($this->keyword) . '">前へ</a>';
    }

    public function showNext() {
        echo '<a href="?page=' . Utils::h($this->page+1) . '&keyword=' . Utils::h($this->keyword) . '">次へ</a>';
    }

    public function showPages() {
        for ($i = 1; $i <= Utils::h($this->total_pages); $i++) {
            echo '<a href="?page=' . $i . '&keyword=' . Utils::h($this->keyword) . '">' . $i . '</a>';
        }
    }

}