<?php

    //DBへ接続
    $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
    $username = "co-19-356.99sv-c";
    $password = "Zv63jCKw";

    try {
        $dbh = new PDO($dsn, $username, $password);

        //SQL作成
        $createsql = 'CREATE TABLE posts (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name TEXT NOT NULL,
            comment TEXT NOT NULL,
            update_datetime DATETIME,
            pass TEXT NOT NULL,
        ) engine=innodb default charset=utf8';

        $res = $dbh->query($createsql);

        //テーブルの存在確認
        $sql = "SELECT 1 FROM information_schema.tables WHERE table_name = 'posts'";
        $query = $dbh->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data['0']['?column?'] == 1){
          echo "テーブルが存在しました。";
        }
        //実行
        
        

    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }

    $dbh = null;
    
?>
