<?php
/*require_once '../../vendor/autoload.php';
$captcha = new \Flywheel\Captcha\Math();
$captcha->show();*/

use Flywheel\Loader;
use Flywheel\Session\Session;

require_once '../../vendor/autoload.php';

define('ROOT_PATH', __DIR__);
$root = dirname(dirname(__DIR__));
define('LIBRARY_PATH', $root .DIRECTORY_SEPARATOR .'library');

Loader::register();
Loader::setPathOfAlias('root', $root);

Loader::addNamespace('BizWeb', LIBRARY_PATH);
\Flywheel\Config\ConfigHandler::import('root.config', true);
Session::getInstance()->start();
$captcha = new \Flywheel\Captcha\Math(['id' => @$_GET['id']]);
$captcha->show();