<?php
//namespace \;
include __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'blaze'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'Object.php';
include __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'blaze'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ClassLoader.php';

spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
//\blazeCMS\Main::main($argv != null ? array_shift($argv) : array());
//\blazeServer\Main::main($argv != null ? array_shift($argv) : array());
\blazeServer\source\netlet\NetletContainer::main($argv != null ? array_shift($argv) : array());
?>