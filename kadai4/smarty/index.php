<?php

require("setup.php");
$smarty = new Smarty();

$smarty->assign("name", "NAKAJIMA");
$smarty->display("body.tpl");

?>