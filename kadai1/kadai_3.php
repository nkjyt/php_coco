<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>PHP kadai 3</title>
    </head>
    <body>
        <h1>
            <?php
                $fileName = 'kadai_2.txt';
                $content = file_get_contents($fileName);
                echo $content;
            ?>
        <h1>
    </body>
</html>