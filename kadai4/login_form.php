<?php
require_once("DBhelper.php");
$helper = new DBhelper();

$error_message = null;

    //clearTable("users");

    if(!empty($_POST['login'])){
        $uid = $_POST['id'];
        $pass = $_POST['password'];

        if(!$helper->isRegistered($uid)){
            $error_message = "本登録されていません";
        }
        if(empty($_POST['id']) || empty($_POST['password'])){
            $error_message = "ユーザー名またはパスワードが入力されていません";
        }


        if(empty($error_message)){
            $user = $helper->queryUser($uid);
            if($user){
                $error_message = "IDまたはパスワードが一致しません";
                header("Location: http://co-19-356.99sv-coco.com/kadai4/login.php?error=".$error_message);
            }
            //一致するユーザデータがあった場合
            else {
                if(!empty($_POST['rb'])){
                    //オートログインにチェックあり
                    $auto_login_token = bin2hex(random_bytes(32));
                    //自動ログイントークンをクッキーに保存
                    setcookie("auto_login", $auto_login_token, time()+60*60*24*7);
                    
                    //ログインユーザの自動ログイントークンがDBにないか確認
                    $exist = $helper->get_login_token($user["uid"]);

                    //すでにトークンが存在する場合は、DBのトークンを更新
                    if($exist->fetch()){
                        $helper->update_login_token($auto_login_token, $user["uid"]);
                    }
                    //自動ログイントークンがない場合は、新規でレコードを追加
                    else {
                        $helper->insert_login_token($auto_login_token, $user["uid"]);
                    }
                }
                session_start();
                //ログインする際にはセッションidを更新する（セッションハイジャック対策）
                session_regenerate_id(true);
                $_SESSION["uid"]=$user["uid"];
                header("Location: http://co-19-356.99sv-coco.com/kadai3/kadai_3_posts.php");
                exit();
            }
        } else {
            header("Location: http://co-19-356.99sv-coco.com/kadai4/login.php?error=".$error_message);
        }
    }
?>