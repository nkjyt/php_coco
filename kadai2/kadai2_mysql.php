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

/*         //テーブル一覧
            $stmt = $dbh -> query('SHOW TABLES');
            while($re = $stmt -> fetch(PDO::FETCH_ASSOC)){
                var_dump($re);
            } */

/*     //データの挿入
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
        $stmt -> execute(); */
    
/*     //複数データの一括挿入
        $update_time = date("Y-m-d" ,time());
        $aryInsert = [];
        $aryInsert[] = ['name' => 'hideki', 'comment' => 'yoro', 'update_datetime' => $update_time, 'pass' => 'abc'];
        $sql = "INSERT INTO posts (
            name, comment, update_datetime , pass
        ) VALUES";

        $arySql1 = [];
        foreach($aryInsert as $key1 => $val1){
            $arySql2 = [];
            foreach($val1 as $key2 => $val2){
                $arySql2[] = ':'.$key2.$key1;
            }
            $arySql1[] = '('.implode(',', $arySql2).')';
        }

        $sql .= implode(',', $arySql1);

        //bind処理
        $stmt = $dbh -> prepare($sql);
        foreach($aryInsert as $key => $val1) {
            foreach($val1 as $key2 => $val2) {
                $stmt -> bindValue(':'.$key2.$key1, $val2);
            }
        }

        $stmt -> execute(); */
    
/*     //データの更新
        $id = 1;
        $name = 'p1_new';
        $comment = 'コメント編集';
        $update_time = date("Y-m-d" ,time());
        $pass = '123';
        //idが一致するデータを更新する
        $sql = "UPDATE posts SET name = :name, comment = :comment, update_datetime = :update_datetime
         WHERE id = :id";
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(':id', $id);
        $stmt -> bindParam(':name', $name);
        $stmt -> bindParam(':comment', $comment);
        $stmt -> bindParam(':update_datetime', $update_time);

        $stmt -> execute();
         */

/*     //データの削除
        $id = 1;
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(':id', $id);

        $stmt -> execute();
 */
        $sql = "TRUNCATE table posts";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

    //データの全件取得
        $stmt = $dbh->query("SELECT * FROM posts");
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        echo var_dump($results);
        
        

    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }

    $dbh = null;
    
?>
