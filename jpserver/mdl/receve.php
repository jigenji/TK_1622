<?php


require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';

//jsonファイルの受け取り
$json_string = file_get_contents('php://input');

error_log($json_string,"3","/var/log/php/php_error.log");
