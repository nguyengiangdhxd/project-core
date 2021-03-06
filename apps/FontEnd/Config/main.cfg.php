<?php
defined('APP_PATH') or define('APP_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
\Flywheel\Loader::addNamespace('FontEnd', dirname(APP_PATH));

return array(
  'app_name'=>'FontEnd',
  'app_path'=> APP_PATH,
  'view_path'=> APP_PATH .DIRECTORY_SEPARATOR.'Template/',
  'import'=>array(
    'app.Library.*',
    'app.Controller.*',
    'root.model.*'
  ),
  'namespace'=> 'FontEnd',
  'timezone'=>'Asia/Ho_Chi_Minh',
  'template'=>'Pages'
);