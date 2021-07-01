<?php

    //DBへ接続
    $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
    $username = "co-19-356.99sv-c";
    $password = "Zv63jCKw";

    try {
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //SQL作成
        $createsql = 'CREATE TABLE posts (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(20),
            comment VARCHAR(100),
            update_datetime DATETIME,
            pass VARCHAR(20)
        ) engine=innodb default charset=utf8';
        //$create = $dbh->query($createsql);

        //データの取得
        $stmt = $dbh->query("SELECT * FROM posts");
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        echo var_dump($results);

        //データの追加
        
        

    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }

    $dbh = null;
    
?>
