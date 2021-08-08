<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=co_19_356_99sv_coco_com", "co-19-356.99sv-c", "Zv63jCKw");

    //ユーザ取得
    $stmt = $db->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    unset($db);

} catch(PDOException $e){
    print($e);
    unset($db);
    die();
}

require_once('/home/co-19-356.99sv-coco.com/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = '/home/co-19-356.99sv-coco.com/public_html/kadai4/smarty/templates/';
$smarty->compile_dir  = '/home/co-19-356.99sv-coco.com/public_html/kadai4/smarty/templates_c/';
$smarty->config_dir   = '/home/co-19-356.99sv-coco.com/public_html/kadai4/smarty/configs/';
$smarty->cache_dir    = '/home/co-19-356.99sv-coco.com/public_html/kadai4/smarty/cache/';


$smarty->assign("title", "ログイン");

$smarty->assign("users", $users);

$smarty->display("login.tpl");

?>