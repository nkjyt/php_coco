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


    //データの挿入
        $name = 'p1';
        $comment = '最初のコメント';
        $update_time = date("Y-m-d" ,time());
        $pass = '123';

        $sql = "INSERT INTO posts (
                name, comment, update_datetime , pass
            ) VALUES (
                :name, :comment, :update_datetime, :pass
            )";

        //実行準備
        $stmt = $dbh -> prepare($sql);
        //クエリのパラメータごとに値を組み込む
        $stmt -> bindValue(':name', $name);
        $stmt -> bindValue(':comment', $comment);
        $stmt -> bindValue(':update_datetime', $update_time);
        $stmt -> bindValue(':pass', $pass);
        //組み込んだ後にSQL文を実行
        $stmt -> execute();
        

    //データの取得
        $stmt = $dbh->query("SELECT * FROM posts");
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        echo var_dump($results);
        
        

    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }

    $dbh = null;
    
?>
