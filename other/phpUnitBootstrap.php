<?php
require_once '../src/blaze/lang/Reflectable.php';
require_once '../src/blaze/lang/Object.php';
require_once '../src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');