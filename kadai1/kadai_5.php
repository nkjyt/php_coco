<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>PHP kadai 5 テキストファイルに保存</title>
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
                    //ファイル保存処理
                    $fileName = 'kadai_5_output.txt';
                    file_put_contents($fileName, $input."\n");
                }
            
            ?>

    </body>
</html>