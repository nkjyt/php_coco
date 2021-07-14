<?php 
    if(isset($_COOKIE["auto_login"])){
        $db = connectDB();
        $auto_login = $db->prepare(("SELECT * FROM auto_login WHERE auto_login_key=?"));
        $auto_login->execute(array(htmlspecialchars($_COOKIE["auto_login"])));
        $auto_login_info = $auto_login->fetch();

        //自動ログイントークンが一致したとき
        if($auto_login_info){
            session_regenerate_id(true);
            $_SESSION["uid"] = $auto_login_info["uid"];
            header("Location: http://co-19-356.99sv-coco.com/kadai3/kadai_2_posts.php");
            exit();
        } else {
             //クッキーとデータベースで、自動ログイントークンが一致しない場合は、クッキーからトークンを消去
            setcookie("auto_login",$auto_login_info["auto_login_key"],time()-60*60*24*7);
            header("Location: http://co-19-356.99sv-coco.com/kadai3/kadai_2_posts.php");
            exit();
        }
    }
?>

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
            $user = queryUser($uid);
            if(empty($user)){
                $error_message = "IDまたはパスワードが一致しません";
            }
            //一致するユーザデータがあった場合
            else {
                if(!empty($_POST['rb'])){
                    //オートログインにチェックあり
                    $auto_login_token = bin2hex(random_bytes(32));
                    //自動ログイントークンをクッキーに保存
                    setcookie("auto_login", $auto_login_token, time()+60*60*24*7);
                    
                    //ログインユーザの自動ログイントークンがDBにないか確認
                    $db = connectDB();
                    $exist = $db -> prepare("SELECT * FROM auto_login WHERE uid=?");
                    $exist -> execute(array($user["uid"]));

                    //すでにトークンが存在する場合は、DBのトークンを更新
                    if($exist->fetch()){
                        $update_key = $db->prepare("UPDATE auto_login SET auto_login_key =? WHERE uid=?");
                        $update_key->execute(array(
                            $auto_login_token,
                            $user['uid']
                        ));
                    }
                    //自動ログイントークンがない場合は、新規でレコードを追加
                    else {
                        $state=$db->prepare("INSERT INTO auto_login VALUES(?,?)");
                        $state->execute(array(
                            $user["uid"],
                            $auto_login_token
                        ));
                    }
                } else {
                    //手動ログイン
                }
            }
        }
    }

?>

<?php 
?>

<?php 

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
    
    <label class="auto_login_radio"><input class="auto_login" type="radio" name = "rb" value = "auto">自動でログインする</label></br>
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
        return $result[0];
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
    input{
        margin-bottom: 20px;
    }
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