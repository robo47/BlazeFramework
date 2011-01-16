<<<<<<< HEAD
<?php
require_once __DIR__.'/../src/blaze/lang/Reflectable.php';
require_once __DIR__.'/../src/blaze/lang/Object.php';
require_once __DIR__.'/../src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
=======
<?php
require_once __DIR__.'/../src/blaze/lang/Reflectable.php';
require_once __DIR__.'/../src/blaze/lang/Object.php';
require_once __DIR__.'/../src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
>>>>>>> 30908ff908011e6657fa44fbda73dc71056c40b0
\blaze\lang\ClassLoader::getSystemClassLoader();