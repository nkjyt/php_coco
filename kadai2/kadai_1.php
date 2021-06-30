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
            <input type = "text" name = "input"/><br/>
        <h3>コメント</h3>
            <textarea class="commentbox" type = "text" name = "comment"></textarea><br/>
            <input class="postButton"type = "submit" value = "投稿"/>
        </form>

    </body>
</html>