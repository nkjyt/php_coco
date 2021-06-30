<?php 

if( !empty($_POST['btn_submit'])) {
        if (empty($_POST['name']) ){
            $error_message[] = '名前を入力してください';
        }

        if (empty($_POST['comment']) ){
            $error_message[] = 'コメントを入力してください';
        }

        if (empty($error_message)) {
            writefile();
        }
}


?>

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
            <?php if(!empty($error_message)): ?>
                <ul class="error_message">
                    <?php foreach($error_message as $value): ?>
                     <li class="error"><?php echo $value; ?> </li>
                   <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <input class="postButton" type = "submit" value = "投稿" name ="btn_submit"/>
        </form>

        
        
        

        <h3>削除対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>", onsubmit="return confirm_form()">
            <input type="text" name ="delete"/><br/>
            <input class="postButton" type = "submit" value = "削除"/>
        </form>

        <?php 
            if(isset($_POST['delete'])){
                $delete_index = $_POST['delete'];
                $isDeleted = false;
                
                $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                $file = fopen('data.txt', 'w');
                foreach ($contents as $contents => $row){
                    $li = explode('<>', $row);
                    if($delete_index != $li[0]){
                        fwrite($file, $row."\n");
                    } else {
                        $isDeleted = !$isDeleted;
                    }
                }
                if($isDeleted){
                    echo "<p>".$delete_index."番目の投稿を削除しました</p>";
                } else {
                    echo "<p>".$delete_index."番目の投稿は存在しません</p>";
                }

            }

        ?>

        <h2>過去の投稿</h2>
            <?php 
                $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                foreach($contents as $contents => $content) {
                    $outputs = explode('<>', $content);
                    
                    $line = $outputs[0];
                    array_shift($outputs);

                    foreach($outputs as $outputs => $output) {
                        $line = $line.", ".$output;
                    }
                    echo $line."<br/>";
                }
            ?>

    </body>
</html>

<?php

/* 
    if(empty($_POST['name']) || empty($_POST['comment'])){
        print('未入力');
    } else {
        //データの追加
        if( !is_nullorempty($_POST['name']) && !is_nullorempty($_POST['comment'])){
            writefile();
            
        }else {
            echo '<p>未入力です</p>';
            
        }
            /**
             * validate string. null is true, "" is true, 0 and "0" is false, " " is false.
             */
            
/*     }
    function is_nullorempty($obj)
            {
                if($obj === 0 || $obj === "0"){
                    return false;
                }
                return empty($obj);
            } 
     */
?>
  




<script>
    //確認フォーム
    function confirm_form() {
        var select = confirm("本当に削除しますか？");
        return select;
    }
</script>

<?php 

?>

<?php 
    function writefile() {
        $contents = file('data.txt', FILE_IGNORE_NEW_LINES);

        $id = count($contents) + 1;
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d" ,time());

        $row = $id."<>".$name."<>".$comment."<>".$date;

        //ファイルの追記
        $file = fopen('data.txt', 'a');
        fwrite($file, $row."\n");
    }
?>

<style>
    ul.error_message {
        color : red;
    }
</style>