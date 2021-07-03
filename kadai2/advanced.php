<?php 

$error_message = array();
$error_message_edit = null;


if( !empty($_POST['btn_submit'])) {
    $func = str_replace("/", "",$_POST['btn_submit']);

        if (empty($_POST['name']) ){
            $error_message[] = '名前を入力してください';
        }

        if (empty($_POST['comment']) ){
            $error_message[] = 'コメントを入力してください';
        }

        if (empty($_POST['password']) ){
            $error_message[] = 'パスワードを入力してください';
        }
        

        if (empty($error_message)) {
            if($func == "投稿"){
                insert();
            }
            //編集モード
            if(!empty($_POST['editted'])){
                $index = str_replace("/", "",$_POST['editted']);
                update($index);
                /* $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                $file = fopen('data.txt', 'w');
                foreach($contents as $contents => $row) {
                    $index = str_replace("/", "",$_POST['editted']);
                    $li = explode('<>', $row);
                    if($index == $li[0]){
                         $row = $index."<>".$_POST['name']."<>".$_POST['comment']."<>".date("Y-m-d" ,time())."<>".$li[4];
                        }
                fwrite($file, $row."\n");
                } */
            }
        }
}

?>

<?php
    //パスワード関連
    if(!empty($_POST['pw_submit'])){
        $pw = $_POST['pw_submit'];
        $number = $_POST['number'];

        //編集の場合
        if( $_POST['function'] == "編集"){
            passCheck($number, $pw);
            /* $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
            foreach ($contents as $contents => $row){
                $li = explode('<>', $row);
                //パスワード一致
                if($number == $li[0] && $pw == $li[4]){
                    $edit_data = $li;
                } else {
                    $pw_error_message = "パスワードが違います";
                }
            } */
        } 
        //削除
        else {
            delete($number);
            /* $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                $file = fopen('data.txt', 'w');
                foreach ($contents as $contents => $row){
                    $li = explode('<>', $row);
                    if($number != $li[0]){
                        fwrite($file, $row."\n");
                    } elseif($number == $li[0] && $pw == $li[4]) {
                        $pw_error_message =  "<p>".$number."番目の投稿を削除しました</p>";
                    } else {
                        fwrite($file, $row."\n");
                        $pw_error_message = "パスワードが違います";
                    }
                }
                if(empty($pw_error_message)){
                    $pw_error_message =  "<p>".$number."番目の投稿は存在しません</p>";
                } */
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

        <?php if(!empty($pw_error_message)): ?>
                <ul class="error_message">
                     <li class="error"><?php echo $pw_error_message; ?> </li>
                </ul>
        <?php endif; ?>

        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
        <h3>名前</h3>
            <input type = "text" name = "name" value="<?php if(!empty($_POST['pw_submit']) && !empty($edit_data)){ echo $edit_data[1]; }?>"/><br/>
        <h3>コメント</h3>
            <div>
                <textarea class="commentbox" type = "text" name = "comment" ><?php if(!empty($_POST['pw_submit']) && !empty($edit_data)){ echo $edit_data[2];}?></textarea><br/>
            </div>
            <h3>パスワード</h3>
            <input class="passwordform" type="text" name="password" value="" /></br>
            <?php if(!empty($error_message)): ?>
                <ul class="error_message">
                    <?php foreach($error_message as $value): ?>
                     <li class="error"><?php echo $value; ?> </li>
                   <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <input class="postButton" type = "submit" value = "<?php if(empty($_POST['pw_submit'])){echo "投稿";} else {echo "編集";} ?>" name ="btn_submit"/>
            <input type="hidden" name="editted" value=<?php if(!empty($_POST['edit']) && !empty($edit_data)){ echo $edit_data[0]; } ?>/>
        </form>

        
        
        

        <h3>削除対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type="text" name ="delete_number"/><br/>
            <input class="postButton" type = "submit" value = "削除" name ="delete" />
        
            <?php if(!empty($_POST['delete'])):?>
                    <form method ="POST" action="<?php print($_SERVER['PHP_SELF']) ?>"　onsubmit= "return confirm_form()" >
                    <h3>削除するためのパスワードを入力</h3>
                        <input type="text" name ="pw_submit"/><br/>
                        <input class="postButton" type = "submit" value = "確認"/>
                        <input type="hidden" name = "number" value="<?php echo $_POST['delete_number']?>">
                        <input type="hidden" name = "function" value ="<?php echo $_POST['delete']?>">
                    </form>
            <?php endif;?>
        </form>


        <h3>編集対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type="text" name ="edit_number"/><br/>
            <?php if(!empty($error_message_edit)): ?>
                <ul class="error_message">
                     <li class="error"><?php echo $error_message_edit; ?> </li>
                </ul>
            <?php endif; ?>
            <input class="postButton" type = "submit" value = "編集" name="edit" />
            
            <?php if(!empty($_POST['edit'])):?>
                <form method ="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
                <h3>編集するためのパスワードを入力</h3>
                    <input type="text" name ="pw_submit"/><br/>
                    <input class="postButton" type = "submit" value = "確認"/>
                    <input type="hidden" name = "number" value="<?php echo $_POST['edit_number']?>">
                    <input type="hidden" name = "function" value ="<?php echo $_POST['edit']?>">
                </form>
            <?php endif;?>

            
            <input type = "hidden" name = "pw_request" />
        </form>

        <h2>過去の投稿</h2>
            <?php 
                /* $contents = file('data.txt', FILE_IGNORE_NEW_LINES);
                foreach($contents as $contents => $content) {
                    $outputs = explode('<>', $content);
                    
                    $line = $outputs[0];
                    array_shift($outputs);

                    foreach($outputs as $outputs => $output) {
                        $line = $line.", ".$output;
                    }
                    echo $line."<br/>";
                } */
                $data = queryAll();
                foreach( $data as $key1 => $val1){
                    $output = $val1['id'];
                    foreach($val1 as $key2 => $val2) {
                        if ($key2 == 'id'){
                            continue;
                        }
                        $output = $output.", ".$val2;
                    }
                    echo $output."<br/>";
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
        $date = date("Y-m-d" ,time());
        $password = $_POST['password'];

        $row = $id."<>".$name."<>".$comment."<>".$date."<>".$password;

        //ファイルの追記
        $file = fopen('data.txt', 'a');
        fwrite($file, $row."\n");
    }    
?>

<?php 
    function connectDB(){
        $dsn = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
        $username = "co-19-356.99sv-c";
        $password = "Zv63jCKw";

        try {
            $db = new PDO($dsn, $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;

        } catch (PDOException $e){

        echo "接続失敗: " . $e->getMessage() ."\n";
        exit();
        }
    }

    function queryAll(){
        $db = connectDB();
        $stmt = $db->query("SELECT * FROM posts");
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $results;
    }

    function insert() {
        $db = connectDB();
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d" ,time());
        $password = $_POST['password'];
        $sql = "INSERT INTO posts (
            name, comment, update_datetime , pass
        ) VALUES (
            :name, :comment, :update_datetime, :pass
        )";

        //実行準備
        $stmt = $db -> prepare($sql);
        //クエリのパラメータごとに値を組み込む
        $stmt -> bindValue(':name', $name);
        $stmt -> bindValue(':comment', $comment);
        $stmt -> bindValue(':update_datetime', $date);
        $stmt -> bindValue(':pass', $password);
        //組み込んだ後にSQL文を実行
        $stmt -> execute(); 
    }

    function update( $id ) {
        $db = connectDB();
        $date = date("Y-m-d" ,time());
        $sql = "UPDATE posts SET name = :name, comment = :comment, update_datetime = :update_datetime
            WHERE id = :id";
        $stmt = $db -> prepare($sql);
        $stmt -> execute(array(
            ':id' => $id,
            ':name' => $_POST['name'],
            ':comment' => $_POST['comment'],
            ':update_datetime' => $date
        ));
        $count = $stmt -> rowCount();
        if($count == 0){
            print("更新に失敗しました");
        }

    }

    function delete($id) {
        $db = connectDB();
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $db -> prepare($sql);
        $stmt -> bindParam(':id', $id);

        $stmt -> execute();
        $count = $stmt -> rowCount();

        if ($count == 0){
            print("データの削除に失敗しました");
        }
    }

    function passCheck($id, $pw) {
        $db = connectDB();
        $stmt = $db -> prepare("SELECT pass FROM posts WHERE pass = :pass");
        $stmt -> bindParam(':pass', $pw);
        $stmt -> execute();
        $count = $stmt -> rowCount();
        if($count == 0){
            print('dame');
        } else {
            print("aruyo");
        }
        
    }

?>


<style>
    ul.error_message {
        color : red;
    }
    textarea.commentbox {
    text-align: top;
    margin-bottom: 10px;
    width: 200px;
    height: 150px;
    align-items: center;
    text-align: left;
    justify-content: center;
    }
    input.passwordform{
        margin-bottom: 20px
    }

</style>