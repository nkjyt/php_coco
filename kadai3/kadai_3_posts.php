<?php 
    session_start();
    if(isset($_COOKIE["auto_login"])){
        
        $db = connectDB();
        $auto_login = $db->prepare(("SELECT * FROM auto_login WHERE auto_login_key=?"));
        $auto_login->execute(array($_SESSION["uid"]));
        $auto_login_info = $auto_login->fetch();
        $user = queryUser($_SESSION["uid"]);
    }
    $user = queryUser($_SESSION["uid"]);
    
?>

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

        if($_FILES['upfile']['error'] == UPLOAD_ERR_NO_FILE){
            $error_message[] = "ファイルが選択されていません";
        }

        //編集モード
        if($func == "編集" && !empty($_POST['editted'])){
            $index = str_replace("/", "",$_POST['editted']);
            update($index);
        }
        else {
            if (empty($_POST['password']) ){
                $error_message[] = 'パスワードを入力してください';
            }
    
            if (empty($error_message) && $func == "投稿") {
                insert();
            }
        }
}





?>

<script>
//確認フォーム
function confirm_form() {
    var select = confirm("本当に削除しますか？");
    return select;
}
</script>

<?php
    //パスワード関連
    if(!empty($_POST['pw_submit'])){
        $pw = $_POST['pw_submit'];
        $number = $_POST['number'];

        //編集の場合
        if( $_POST['function'] == "編集"){
            if (passCheck($number, $pw)){
                $edit_data = queryPost($number);
                print(var_dump($edit_data));
            } else {
                $pw_error_message = "パスワードが異なるか，投稿が存在しません";
            }

        } 
        //削除
        else {
            if (passCheck($number, $pw)){
                delete($number);
            } else {
                $pw_error_message = "パスワードが異なるか，投稿が存在しません";
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

        <?php if(!empty($pw_error_message)): ?>
                <ul class="error_message">
                     <li class="error"><?php echo $pw_error_message; ?> </li>
                </ul>
        <?php endif; ?>

        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" >
        <h3>名前</h3>
            <input type = "text" name = "name" value="<?php echo $user['name']; ?>"/><br/>
        <h3>コメント</h3>
            <div>
                <textarea class="commentbox" type = "text" name = "comment" ><?php if(!empty($_POST['pw_submit']) && !empty($edit_data)){ echo $edit_data['comment'];}?></textarea><br/>
            </div>
            <div>
                <input type="file" name="upfile">
                
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
            <input type="hidden" name="editted" value=<?php if(!empty($edit_data)){ echo $edit_data['id']; }?>/>
        </form>

        
        
        

        <h3>削除対象番号</h3>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type="text" name ="delete_number"/><br/>
            <input class="postButton" type = "submit" value = "削除" name ="delete" />
        
            <?php if(!empty($_POST['delete'])):?>
                    <form method ="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
                    <h3>削除するためのパスワードを入力</h3>
                        <input type="text" name ="pw_submit"/><br/>
 
                        <input class="postButton" type = "submit" value = "確認"  onclick="return confirm_form()"/>
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
                /* $data = queryAll();
                if (empty($data)){
                    print("現在投稿はありません");
                }
                foreach( $data as $key1 => $val1){
                    $output = $val1['id'];
                    foreach($val1 as $key2 => $val2) {
                        if ($key2 == 'id'){
                            continue;
                        }
                        $output = $output.", ".$val2;
                    }
                    echo $output."<br/>";
                } */
                //DBから取得して表示する．
                $db = connectDB();
                $sql = "SELECT * FROM posts3 ORDER BY id;";
                $stmt = $db->prepare($sql);
                $stmt -> execute();
                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                    echo ($row["id"]."<br/>");
                    //動画と画像で場合分け
                    $target = $row["fname"];
                    $raw_data = $row["raw_data"];
                    if($row["extension"] == "mp4"){
                        $enc_video = base64_encode($raw_data);
                        echo '<video width="600" height="400" controls="controls">
                            <scource src="data:video/mp4;base64,'.base64_encode($raw_data).'"/>
                        </video>';
                        echo ("<video src=\"kadai_3_import_media.php?target=$target\" width=\"426\" height=\"240\" controls></video>");
                    }
                    elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
                        $encimg = base64_encode($raw_data);
                        $imginfo = getimagesize('data:application/octet-stream;base64,' . $encimg);
                        echo $imginfo['mime'];
                        echo '<img src="data:'. $imginfo['mime'] . ';base64,' . $encimg . '" />';
                    }
                    echo ("<br/><br/>");
                }
            ?>
    </body>
</html>





<?php 

?>

<?php 
    function writefile() {
        $contents = file('data.txt', FILE_IGNORE_NEW_LINES);

        $id = count($contents) + 1;
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $date = date("Y-m-d H:i:s");
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

    function queryPost($id) {
        $db = connectDB();
        $stmt = $db -> prepare("SELECT * FROM posts3 WHERE id = :id");
        $stmt -> execute(array(
            ':id' => $id
        ));
        $results = $stmt -> fetchall(PDO::FETCH_ASSOC);
        $count = $stmt -> rowCount();
        if($count == 0){
            print("something wrong");
        }
        return $results[0];
    }

    function queryAll(){
        $db = connectDB();
        $stmt = $db->query("SELECT id, name, comment, update_datetime, password, fname, extension FROM posts3");
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $results;
    }

    function queryUser($uid) {
        $db = connectDB();
        $stmt = $db -> prepare("SELECT * FROM users WHERE uid = :uid");
        $stmt -> bindParam(':uid', $uid);
        $stmt -> execute();
        $result = $stmt -> fetchall(PDO::FETCH_ASSOC);
        return $result[0];
    }

    
    function insert() {
        $db = connectDB();
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $datetime = date("Y-m-d H:i:s");
        $password = $_POST['password'];

        //ファイル処理----------------------------------
        if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
            //エラーチェック
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_NO_FILE:   // 未選択
                    throw new RuntimeException('ファイルが選択されていません', 400);
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
                default:
                    throw new RuntimeException('その他のエラーが発生しました', 500);
            }
            //画像・動画をバイナリデータにする．
            $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);
        }
        //拡張子を見る
        $tmp = pathinfo($_FILES["upfile"]["name"]);
        $extension = $tmp["extension"];
        if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
            $extension = "jpeg";
        }
        elseif($extension === "png" || $extension === "PNG"){
            $extension = "png";
        }
        elseif($extension === "gif" || $extension === "GIF"){
            $extension = "gif";
        }
        elseif($extension === "mp4" || $extension === "MP4"){
            $extension = "mp4";
        }
        else{
            echo "非対応ファイルです．<br/>";
            //echo ("<a href=\"index.php\">戻る</a><br/>");
            //exit(1);
        }
        //DBに格納するファイルネーム設定
        //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
        $date = getdate();
        $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
        $fname = hash("sha256", $fname);

        //画像・動画をDBに格納．

        $sql = "INSERT INTO posts3 (
            name, comment, update_datetime , password, fname, extension, raw_data
        ) VALUES (
            :name, :comment, :update_datetime, :password, :fname, :extension, :raw_data
        )";

        //実行準備
        $stmt = $db -> prepare($sql);
        //クエリのパラメータごとに値を組み込む
        $stmt -> bindParam(':name', $name);
        $stmt -> bindParam(':comment', $comment);
        $stmt -> bindParam(':password', $password);
        $stmt -> bindParam(':update_datetime', $datetime);
        $stmt -> bindParam(':fname', $fname, PDO::PARAM_STR);
        $stmt -> bindParam(':extension', $extension, PDO::PARAM_STR);
        $stmt -> bindParam(':raw_data', $raw_data, PDO::PARAM_STR);

        $stmt -> execute();

    }

    function update( $id ) {
        $db = connectDB();
        $date = date("Y-m-d H:i:s");
        $sql = "UPDATE posts3 SET name = :name, comment = :comment, update_datetime = :update_datetime
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
            print($id);
        }

    }

    function delete($id) {
        $db = connectDB();
        $sql = "DELETE FROM posts3 WHERE id = :id";
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
        $stmt = $db -> prepare("SELECT pass FROM posts3 WHERE pass = :pass");
        $stmt -> bindParam(':pass', $pw);
        $stmt -> execute();
        $count = $stmt -> rowCount();
        if($count == 0){
            return False;
        } else {
            return True;
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