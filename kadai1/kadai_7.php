<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>kadai1-7 ファイルを配列にして表示</title>
    </head>
    <body>
        <h1>読み込んだファイル 'kadai_5_output.txt'</h1>
            <?php
                $contents = file('kadai_5_output.txt', FILE_IGNORE_NEW_LINES);
                foreach ($contents as $contents => $value) {
                    echo "<h2>".$value."</h2>";
                }
            ?>

    </body>
</html>