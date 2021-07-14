<?php
$error_message = null;

    //clearTable("users");

    if(!empty($_POST['login'])){
        $uid = $_POST['id'];
        $pass = $_POST['password'];

        if(empty($_POST['id'])){
            $error_message = "ユーザー名が入力されていません";
        }
        if(empty($_POST['password'])){
            $error_message = "ユーザー名が入力されていません";
        }

        if(empty($error_message)){
            $result = queryUser($uid);
            if(empty($result)){
                print("hoge");
            }
            else {
                print(var_dump($result));
                session_start();
                print('セッションIDは '.$_COOKIE['PHPSESSID'].' です。');
                $_SESSION['name'] = $result[0]['name'];
                echo 'ユーザー名は '. $_SESSION['name'].' 。';

                unset($_SESSION['name']);

                if (!isset($_SESSION['name'])){
                    echo 'ユーザー名は削除されました。';
                }else{
                    echo 'ユーザー名は '. $_SESSION['name'].' 。';
                }
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
    <h1 class="title">ログインフォーム</h1>

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
        <h3>ID</h3>
            <input type = "text" name = "id" /><br/>
    </div>
    <h3>パスワード</h3>
        <input type="text" name = "password" /><br />
    
    <input class="login_button" type="submit" name = "login" value="ログイン">
    </form>

    <h2>ユーザ一覧</h2>
            <?php 
                $data = queryAll("users");
                if (empty($data)){
                    print("Not existing user");
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

    function queryUser($uid) {
        $db = connectDB();
        $stmt = $db -> prepare("SELECT * FROM users WHERE uid = :uid");
        $stmt -> bindParam(':uid', $uid);
        $stmt -> execute();
        $result = $stmt -> fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    function insert($uid) {
        $db = connectDB();
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
    ul.error_message {
        color : red;
        margin : 20px;
    }
input.login_button {
    width: 80px;
    height: 40px;
    margin-top: 30px;
}
</style>