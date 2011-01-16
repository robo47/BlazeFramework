<?php
require_once __DIR__.'/../src/blaze/lang/Reflectable.php';
require_once __DIR__.'/../src/blaze/lang/Object.php';
require_once __DIR__.'/../src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
\blaze\lang\ClassLoader::getSystemClassLoader();

define('TESTS_PATH', __DIR__);
define('SRC_PATH', realpath(__DIR__ . '/../src/'));
define('TMP_PATH', __DIR__ . '/tmp/');

/**
 * Loading the users Test-Configuration or Fallback to default TestConfiguration
 */
if (file_exists(__DIR__ . '/TestConfiguration.php')) {
    require_once __DIR__ . '/TestConfiguration.php';
} elseif(file_exists(__DIR__ . '/TestConfiguration.php.dist')) {
    require_once __DIR__ . '/TestConfiguration.php.dist';
} else {
    echo 'No Configuration File found';
    exit();
}