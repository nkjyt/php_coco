<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>簡易掲示板</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <link rel="stylesheet" href="style.css">
        <h1 class="title">簡易掲示板</h1>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
        <h3>名前</h3>
            <input type = "text" name = "name"/><br/>
        <h3>コメント</h3>
            <textarea class="commentbox" type = "text" name = "comment"></textarea><br/>
            <input class="postButton" type = "submit" value = "投稿"/>
        </form>

    </body>
</html>

        
<?php
    
    if(isset($_POST['name']) && isset($_POST['comment'])){
        $contents = file('data.txt', FILE_IGNORE_NEW_LINES);

        $id = count($contents) + 1;
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d" ,time());

        $row = $id."<>".$name."<>".$comment."<>".$date;
        //echo '<h2>以下の内容をテキストファイルに保存：'.$input.'</h2>';
        //ファイルの追記
        $file = fopen('data.txt', 'a');
        fwrite($file, $row."\n");
    }
?>