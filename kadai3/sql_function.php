<?php
//DBへ接続
    $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
    $username = "co-19-356.99sv-c";
    $password = "Zv63jCKw";

    try {
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*         //SQL作成
        $createsql = 'CREATE TABLE users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            uid VARCHAR(30),
            name VARCHAR(30),
            password VARCHAR(100),
            registered BOOLEAN
        ) engine=innodb default charset=utf8';
        $create = $dbh->query($createsql); */

        //投稿用DBを画像，動画対応するように変更
        /* $createsql = 'CREATE TABLE posts3 (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30),
            comment VARCHAR(100),
            update_datetime DATETIME,
            password VARCHAR(30),
            fname TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
            extension TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
            raw_data LONGBLOB
        ) engine=innodb default charset=utf8';
        $create = $dbh->query($createsql); */

         //テーブル一覧
         $stmt = $dbh -> query('SHOW TABLES');
         while($re = $stmt -> fetch(PDO::FETCH_ASSOC)){
             var_dump($re);

 /*             //削除
        $sql = "TRUNCATE table posts3";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute(); */

        $sql = "SET GLOBAL max_allowed_packet=16777216";
        $sql = "SHOW VARIABLES LIKE 'max_allowed_packet'";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        //$result = queryAll("auto_login");
        //print(var_dump($result));
            
/*         $createsql = 'CREATE TABLE auto_login (
        uid VARCHAR(30),
        auto_login_key VARCHAR(40)
        ) engine=innodb default charset=utf8';

        $create = $dbh->query($createsql); */
    }

    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }

    $dbh = null;
    
    function queryAll($table){
        $db = connectDB();
        $stmt = $db->query("SELECT * FROM ".$table);
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $results;
    }
    function connectDB(){
        $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
        $username = "co-19-356.99sv-c";
        $password = "Zv63jCKw";
        try {
            $db = new PDO($dsn, $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
        }
    }
?>