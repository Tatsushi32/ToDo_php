<?php

class Todo {
    private $dbh;
    
    public function __construct($dbh) {
        $this->dbh =  $dbh;
    }

    public function getAll($offset) {
        $sql = "SELECT * FROM posts limit " . $offset . "," . TODO_PER_PAGE;
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $todos = $stmt->fetchAll();
        return $todos;
    }
}