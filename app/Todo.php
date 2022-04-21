<?php

class Todo extends Database{
    
    private $offset;
    private $keyword;

    public function __construct($keyword=null) {
        $this->connect();
        $this->keyword = isset($keyword) ? $keyword : null;
        $pagination = isset($keyword) ? new PagenationSearch($keyword) : new PaginationAll();
        $this->offset = $pagination->offset;
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

    public function create($title, $content) {
        $sql = "INSERT INTO posts(title,content) VALUES (:title, :content)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":content", $content);
        $stmt->execute();
    }

    public function get($id) {
        $sql = "SELECT title,content FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $selected_todo = $stmt->fetch();
        return $selected_todo;
    }

    public function update($title, $content, $id) {
        $sql = "UPDATE posts SET title=:title, content=:content WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":content", $content);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete($id) {
        $validateSql = "SELECT COUNT(*) FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($validateSql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $validateId = $stmt->fetchColumn();
    
        if ($validateId == 0) {
            exit("Invalid post request");
        }
    
        $sql = "DELETE FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}