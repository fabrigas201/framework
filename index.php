<?php

define('DS', DIRECTORY_SEPARATOR);

define('PATH', dirname(__FILE__) . DS);
define('APP', PATH . 'app' . DS);
define('SYS', PATH . 'system' . DS);
define('EXT', '.php');

require_once PATH.'vendor/autoload'.EXT;

new System\Alias();

require_once(APP.'route'.EXT);


