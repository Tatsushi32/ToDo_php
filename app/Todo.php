<?php

class Todo extends Database{
    
    public function __construct() {
        $this->connect();
    }

    // 新規作成
    public function create($title, $content) {
        $sql = "INSERT INTO posts(title,content) VALUES (:title, :content)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":content", $content);
        $stmt->execute();
    }

    // 取得
    public function get($id) {
        $sql = "SELECT title,content FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $selected_todo = $stmt->fetch();
        return $selected_todo;
    }

    // 更新
    public function update($title, $content, $id) {
        $sql = "UPDATE posts SET title=:title, content=:content WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":content", $content);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // 削除
    public function delete($id) {
        $validateSql = "SELECT COUNT(*) FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($validateSql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $validateId = $stmt->fetchColumn();
    
        if ($validateId === 0) {
            exit("Invalid post request");
        }
        $sql = "DELETE FROM posts WHERE id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}