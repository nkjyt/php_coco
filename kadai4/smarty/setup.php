<?php

// Smartyライブラリを読み込みます
require("/home/co-19-356.99sv-coco.com/Smarty/libs/Smarty.class.php");

// setup.phpはアプリケーションに必要なライブラリファイルを
// 読み込むのに適した場所です。それをここで行うことができます。例:
// require('coco/coco.lib.php');

class Smarty_coco extends Smarty {

   function Smarty_coco()
   {

        // クラスのコンストラクタ。
        // これらは新しいインスタンスで自動的にセットされます。

        $this->Smarty();

        $this->template_dir = '/home/co-19-356.99sv-coco.com/public_html/coco/templates/';
        $this->compile_dir  = '/home/co-19-356.99sv-coco.com/public_html/coco/templates_c/';
        $this->config_dir   = '/home/co-19-356.99sv-coco.com/public_html/coco/configs/';
        $this->cache_dir    = '/home/co-19-356.99sv-coco.com/public_html/coco/cache/';

        $this->caching = true;
        $this->assign('app_name', 'coco');
   }

}
?>