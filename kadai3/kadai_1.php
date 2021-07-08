<?php
$error_message = null;
    if(!empty($_POST['register'])){
        if(empty($_POST['name'])){
            $error_message = "ユーザー名が入力されていません";
        }

        if($_POST['password'] == $_POST['confirm']){
            //ID生成、登録処理
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
    <title>Document</title>
</head>

<body>
    <h1 class="title">登録フォーム</h1>
    <?php if(!empty($error_message)): ?>
        <ul class="error_message">
                <li class="error"><?php echo $error_message; ?> </li>
        </ul>
    <?php endif; ?>
    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <h3>ユーザー名</h3>
        <input type = "text" name = "name" /><br/>
    <h3>パスワード</h3>
        <input type="text" name = "password" /><br />
    <h3>確認用パスワード</h3>
        <input type="text" name = "confirm" /><br/>
    
    <input class="register_button" type="submit" name = "register" value="登録">
    </form>

</body>
</html>

<style>
    ul.error_message {
        color : red;
        margin : 20px;
    }
input.register_button {
    width: 50px;
    height: 30px;
    margin-top: 20px;
}
</style>