<?php

    $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
    $username = "co-19-356.99sv-c";
    $password = "Zv63jCKw";
    //PDO::__construct($dsn,$username,$password,$option)

    try {
        $dbh = new PDO($dsn, $username, $password);
        echo "接続成功";
    } catch (PDOException $e){
        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
    }
?>
