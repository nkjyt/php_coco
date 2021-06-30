<html>
<head><title>PHP TEST</title></head>
<body>

<?php
    //MySQL接続
    $pdo = new PDO('mysql:host=localhost;dbname=co_19_356_99sv_coco_com', 'co-19-356.99sv-c', 'Zv63jCKw');

    //tableの作成
    $pdo->query('CREATE TABLE co_19_356_99sv_coco_com (id INT, name VARCHAR(30), comment VARCHAR(100), data DATE');

    //データの取得
    $result = $pdo->query('SELECT * FROM co_19_356_99sv_coco_com');


//mysql_connectは古い関数？
/* $link = mysql_connect('localhost', 'co-19-356.99sv-c', 'Zv63jCKw');
if (!$link) {
    die('接続失敗です。'.mysql_error());
}

print('<p>接続に成功しました。</p>');

// MySQLに対する処理

$close_flag = mysql_close($link);

if ($close_flag){
    print('<p>切断に成功しました。</p>');
} */

?>
</body>
</html>