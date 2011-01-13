<?php
$dir = __DIR__.'/src/blaze/lang/';
include $dir.'Reflectable.php';
include $dir.'Object.php';
include $dir.'ClassLoader.php';

spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
\blazeServer\source\netlet\NetletContainer::main(isset($argv) && $argv != null ? array_shift($argv) : array());
?>