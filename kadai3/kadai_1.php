<?php
$error_message = null;
    if(!empty($_POST['register'])){
        $name = $_POST['name'];
        $pass = $_POST['password'];

        if(empty($_POST['name'])){
            $error_message = "ユーザー名が入力されていません";
        }

        if($_POST['password'] == $_POST['confirm']){
            //ID生成、登録処理
            $uid = uniqid();
            echo $uid;
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

</body>
</html>

<style>
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