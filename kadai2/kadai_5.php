<?php 

$error_message = array();
$error_message_edit = null;
global $edit_index;



if( !empty($_POST['btn_submit'])) {
        if (empty($_POST['name']) ){
            $error_message[] = '名前を入力してください';
        }

        if (empty($_POST['comment']) ){
            $error_message[] = 'コメントを入力してください';
        }

        if (empty($error_message)) {
            //編集モード
            if($_POST['func'] == "編集"){
                $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                $file = fopen('data.txt', 'w');
                foreach($contents as $contents => $row) {
                    $index = str_replace("/", "",$_POST['editted']);
                    print($index);
                    $li = explode('<>', $row);
                    if($index == $li[0]){
                         $row = $index."<>".$_POST['name']."<>".$_POST['comment']."<>".date("Y-m-d H:i:s");
                        }
                fwrite($file, $row."\n");
                }
            } else {
                writefile();
            }
        }
}

if (!empty($_POST['edit']) ){
    if(empty($_POST['edit_number']) ){
        $error_message_edit = '番号を入力してください';
    }
    if (empty($error_message_edit)){
        global $edit_index;
        $edit_index = $_POST['edit_number'];
        $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
        foreach($contents as $row) {
            $li = explode('<>', $row);
            if($edit_index == $li[0]){
                $edit_data = $li;
            }
        }
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
            <input type = "text" name = "name" value="<?php if(!empty($_POST['edit'])){ echo $edit_data[1]; }?>"/><br/>
        <h3>コメント</h3>
            <div>
                <textarea class="commentbox" type = "text" name = "comment" ><?php if(!empty($_POST['edit'])){ echo $edit_data[2];}?></textarea><br/>
            </div>
            <?php if(!empty($error_message)): ?>
                <ul class="error_message">
                    <?php foreach($error_message as $value): ?>
                     <li class="error"><?php echo $value; ?> </li>
                   <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <input class="postButton" type = "submit" value = "<?php if(empty($_POST['edit'])){echo "投稿";} else {echo "編集";} ?>" name ="btn_submit"/>
            <input type="hidden" name = "func" value = "<?php if(empty($_POST['edit'])){echo "投稿";} else {echo "編集";} ?>" />
            <input type="hidden" name="editted" value=<?php if(!empty($_POST['edit'])){ echo $edit_data[0]; } ?>/>
        </form>

        
        
        

        <h3>削除対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>", onsubmit="return confirm_form()">
            <input type="text" name ="delete"/><br/>
            <input class="postButton" type = "submit" value = "削除"/>
        </form>

        <?php 
        //削除する
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

        <h3>編集対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type="text" name ="edit_number"/><br/>
            <?php if(!empty($error_message_edit)): ?>
                <ul class="error_message">
                     <li class="error"><?php echo $error_message_edit; ?> </li>
                </ul>
            <?php endif; ?>
            <input class="postButton" type = "submit" value = "編集" name="edit" />
        </form>

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
        $date = date("Y-m-d　H:i:s");

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
    div#textarea{
        text-align: center;
    }
</style>