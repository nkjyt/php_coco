<?php
session_start();
    if(!empty($_GET['urltoken'])){
        $id = $_GET['urltoken'];
        $db = connectDB();
        if (!isRegistered($id)){
            $sql = "UPDATE users SET registered = :registered WHERE uid = :uid";
            $stmt = $db -> prepare($sql);
            $stmt -> execute(array(
                ':uid' => $id,
                ':registered' => true,
            ));
            $count = $stmt -> rowCount();
            if($count == 0){
                $error_message = "URLが無効です";
            } else {
                echo ('本登録が完了しました<br />');
                echo (' <a href="http://co-19-356.99sv-coco.com/kadai3/kadai_4_login.php">ログイン画面はこちら</a>');

            }
        }
        //header("Location: http://co-19-356.99sv-coco.com/kadai3/kadai_4_login.php");        
    }
?>

<?php

$error_message = null;

    //clearTable("users");
    $db = connectDB();

    if(!empty($_POST['register'])){
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $mail = $_POST['mail'];

        if(empty($_POST['name'])){
            $error_message = "ユーザー名が入力されていません";
        }
        if(empty($_POST['mail'])){
            $error_message = "メールアドレスが入力されていません";
        }
        if(empty($_POST['password'])){
            $error_message = "パスワードが入力されていません";
        }
        if($_POST['password'] != $_POST['confirm']){
            $error_message = "確認用パスワードが異なります";
        }

        if(empty($error_message)){
            //DB確認
            $sql = "SELECT id FROM users WHERE mail=:mail";
            $stmt = $db -> prepare($sql);
            $stmt -> bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt -> execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(isset($result["id"])){
                $error_message = "このメールアドレスはすでに利用されています。";
            }  
        }
        if(empty($error_message)){
            //ID生成、登録処理
            $uid = uniqid();
            $url = "http://co-19-356.99sv-coco.com/kadai3/kadai_4.php?urltoken=".$uid;
            try{
                insert($uid);
            }catch (PDOException $e){
                 print('Error:'.$e->getMessage());
                 die();
            }
            $mailTo = $mail;
            $subject = "Please verification you email !";
            $body = "Thank you for register! Please verify you email from {$url}";
            mb_language('ja');
            mb_internal_encoding("UTF-8");
            $header = "Form:nkjmyut0511@gmail.com";
            if(mb_send_mail($mailTo, $subject, $body, $header)){
                $message = "メールアドレスに認証メールを送信しました。<br />24時間以内に認証をしてください。<br />"; 
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
</head>

<body>
    <h1 class="title">登録フォーム</h1>

    <?php if(!empty($error_message)): ?>
        <ul class="error_message">
                <li class="error"><?php echo $error_message; ?> </li>
        </ul>
    <?php endif; ?>

    <?php if(!empty($message)): ?>
        <h2 class="message"><?php echo $message; ?></h2>
    <?php endif; ?>


    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>" >
    <div class="user_form">
        <h3>ユーザー名 : <input type = "text" name = "name" /></h3>
    </div>
    <div class="mail_form">
        <h3>メールアドレス : <input type="text" name = "mail" /></h3>
    </div>
        
    <h3>パスワード : <input type="text" name = "password" /></h3>
    <h3>確認用パスワード : <input type="text" name = "confirm" /></h3>
    
    <input class="register_button" type="submit" name = "register" value="登録">
    </form>

    <a href="http://co-19-356.99sv-coco.com/kadai3/kadai_4_login.php">ログイン画面</a><br />


    <h2>ユーザ一覧</h2>
            <?php 
                $data = queryAll("users");
                if (empty($data)){
                    print("ユーザは存在しません");
                }
                foreach( $data as $key1 => $val1){
                    $output = $val1['id'];
                    foreach($val1 as $key2 => $val2) {
                        if ($key2 == 'id'){
                            continue;
                        }
                        $output = $output.", ".$val2;
                    }
                    echo $output."<br/>";
                }
            ?>

</body>
</html>

<?php 
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

    function queryAll($table){
        $db = connectDB();
        $stmt = $db->query("SELECT * FROM ".$table);
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $results;
    }

    function insert($uid) {
        $db = connectDB();
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $sql = "INSERT INTO users (
            uid, name, mail, password, registered
        ) VALUES (
            :uid, :name, :mail, :password, :registered
        )";

        $stmt = $db -> prepare($sql);
        $stmt -> execute(array(
            ':uid' => $uid,
            ':name' => $name,
            ':mail' => $mail,
            ':password' => $password,
            ':registered' => false
        )); 
    }

    function isRegistered($uid){
        echo $uid;
        $db = connectDB();
        $sql = "SELECT * FROM users WHERE uid = :uid";
        $stmt = $db -> prepare($sql);
        $stmt -> execute(array(':uid' => $uid));
        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['registered'];
    }

    function clearTable($table) {
        $db = connectDB();
        $sql = "TRUNCATE table ".$table;
        $stmt = $db -> prepare($sql);
        $stmt -> execute();
    }

?>





<style>
    .message {
        font-size:30;
    }
    .user_form {
        margin-bottom: 10px
    }
    .mail_form {
        margin-bottom: 30px;
    }
    ul.error_message {
        color : red;
        margin : 20px;
    }
input.register_button {
    width: 50px;
    height: 30px;
    margin-top: 20px;
    margin-bottom: 30px;
}
</style>