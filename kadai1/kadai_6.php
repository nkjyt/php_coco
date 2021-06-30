<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>kadai1-6 ファイルに追記</title>
    </head>
    <body>
        <h1>フォームの送信</h1>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type = "text" name = "input"/><br/>
            <input type = "submit" value = "送信"/>
        </form>

            <?php
                if(isset($_POST['input'])){
                    $input = $_POST['input'];
                    echo '<h2>以下の内容をテキストファイルに保存：'.$input.'</h2>';
                    //ファイルの追記
                    $file = fopen('kadai_5_output.txt', 'a');
                    fwrite($file, $input."\n");
                }
            
            ?>

    </body>
</html>