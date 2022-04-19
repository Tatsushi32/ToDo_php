<?php

class Database {

    public static function connect() {
        try {
            $dbh = new PDO(
                DSN, 
                DB_USER, 
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            return $dbh;
            
        } catch (Exeption $e) {
        
            echo "ただいま障害によりご迷惑をおかけしております。 <br />";
            header("Location: index.php");
            exit();
        }
    }
}