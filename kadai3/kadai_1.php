<?php
$error_message = null;

    //clearTable("users");

    if(!empty($_POST['register'])){
        $name = $_POST['name'];
        $pass = $_POST['password'];

        if(empty($_POST['name'])){
            $error_message = "ユーザー名が入力されていません";
        }

        if($_POST['password'] == $_POST['confirm']){
            //ID生成、登録処理
            insert();
            $message = "登録完了<br /> ユーザ名：".$name.", パスワード：".$pass;
        } else {
            $error_message = "確認用パスワードが異なります";
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


    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <div class="user_form">
        <h3>ユーザー名</h3>
            <input type = "text" name = "name" /><br/>
    </div>
        
    <h3>パスワード</h3>
        <input type="text" name = "password" /><br />
    <h3>確認用パスワード</h3>
        <input type="text" name = "confirm" /><br/>
    
    <input class="register_button" type="submit" name = "register" value="登録">
    </form>

    <h2>ユーザ一覧</h2>
            <?php 
                $data = queryAll("users");
                if (empty($data)){
                    print("現在投稿はありません");
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

    function insert() {
        $db = connectDB();
        $uid = uniqid();
        $name = $_POST['name'];
        $password = $_POST['password'];
        $sql = "INSERT INTO users (
            uid, name, password, registered
        ) VALUES (
            :uid, :name, :password, :registered
        )";

        $stmt = $db -> prepare($sql);
        $stmt -> execute(array(
            ':uid' => $uid,
            ':name' => $name,
            ':password' => $password,
            ':registered' => TRUE
        )); 
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
        margin-bottom: 40px
    }
    ul.error_message {
        color : red;
        margin : 20px;
    }
input.register_button {
    width: 50px;
    height: 30px;
    margin-top: 30px;
}
</style>