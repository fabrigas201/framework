<?php
/**
 * MVC PHP Framework
 * 
 * @copyright Copyright (c) 2016, Gurev Valentin[Гурьев Валентин]
 * @author Гурьев Валентин
 * @link http://rm-make.ru
 * 
 */

//запускаю сессию
session_start();

//отображаю ошибки
error_reporting(E_ALL);
ini_set('display_errors', 1);

//проверяю версию php
if(version_compare(phpversion(), '5.6.0', '<') == true) {
    die('PHP >= 5.6.0 Only (Версия PHP должна быть >= 5.6.0)');
}




define('DS', '/'); // DIRECTORY_SEPARATOR

define('PATH', dirname(__FILE__) . DS);
define('APP', PATH . 'app' . DS);
define('SYS', PATH . 'system' . DS);
define('EXT', '.php');
define('ENVIRONMENT', 'DEVELOPER');

require_once PATH.'vendor/autoload'.EXT;

new System\Alias();

require_once(APP.'route'.EXT);



