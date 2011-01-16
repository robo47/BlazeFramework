<?php
require_once __DIR__.'/../src/blaze/lang/Reflectable.php';
require_once __DIR__.'/../src/blaze/lang/Object.php';
require_once __DIR__.'/../src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
\blaze\lang\ClassLoader::getSystemClassLoader();