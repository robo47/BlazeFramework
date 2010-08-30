<?php
//namespace \;
include __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'blaze'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'Reflectable.php';
include __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'blaze'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'Object.php';
include __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'blaze'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ClassLoader.php';

spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
//set_error_handler(array(\blaze\util\Logger::get(),'logError'));
\blazeServer\source\netlet\NetletContainer::main(isset($argv) && $argv != null ? array_shift($argv) : array());
?>