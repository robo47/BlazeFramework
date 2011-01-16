BlazeFramework
=============

The BlazeFramework can be included in every project. There are just some simple Rules!

New Project
-----------

You need the following files to get it work.

* `.htaccess` file in the web root to forward requests to a single index.php
* `index.php` which makes the standard includes and the call of the main method.
* A main class with a `public static function main($args){}`

### .htaccess

Every request should go to the main class in which can be decided what to
do with the request. If you are developing with the web framework you will not have to bother with
this, but for standalone applications you need to specify the forward if the script is called through the browser.
When you will not call that application through the browser, you do not need that file.

A sample `.htaccess` file would look like this:

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^.*$ index.php [L]

This forwards requests to the `index.php`


### index.php

The `index.php` is the main entry point, which initializes the framework. The main part is to set the class loader
which can only be set, if the class and the interface it extends/implements are included too. Because of that
the relative paths in the index.php file depend on the directory in which that file is in the following example:

    <?php

    $dir = __DIR__.'/src/blaze/lang/';

    include $dir.'Reflectable.php';

    include $dir.'Object.php';

    include $dir.'ClassLoader.php';


    
    spl_autoload_register('blaze\lang\ClassLoader::autoLoad');

    \firstPackage\HelloWorld::main(isset($argv) && $argv != null ? array_shift($argv) : array());

    ?>

This file would be in the same directory as the source dir and of course this would probably be the web root. It is
not necessary to put these files in the web root, you can put the framework where ever you want to.
As you can see, in the last line, the static method main of the class HelloWorld, which is in the package/namespace `firstPackage`,
is called with the parameter of the global variable `$argv`. The expression to really get an array should always be used like
that to really get a value and not null.


### \firstPackage\HelloWorld.php

In this case the file would be in the directory `.../src/firstPackage/`. The file must have the same name as the class, so
the class `HelloWorld` has to be in `HelloWorld.php`. Namespaces are introduced in PHP 5.3 and if you don't know them yet,
just think of a logical class structure to see the point of `packages/namespaces`. The Hello World application will look like
that:

    <?php
    namespace firstPackage;
    use blaze\lang\Object;
    use blaze\lang\System;
    
    class HelloWorld extends Object {
      public static function main($args){
        System.out.println('Hello World');
      }
    }
    
    ?>

As you can see, the only heavy part is to set the path to the library and define the right entry point(`MainClass::main()`).


Project Integration
-------------------

### Projects without autoload implementations

The integration into projects which do not use a class loader yet is very simple. You will just need to include
the three files specified in the index.php example above and register the class loader. After doing that you
can write any code you want and you are able to use the classes of the framework.

Note that if you not use namespaces and imports(use) in your files, you will have to specify the whole path to the classes
every time you want to use them.

### Projects with autoload implementations

This is maybe a little problem, because the class loader of this framework throws exceptions if a class could not be found.
So if you want to use other libraries or use this framework in others, you will probably have to wrap around the autoloader
of the other one or of this one. There are a lot of other frameworks out there which make use of autoload, so there
will be no full implementation given, but an example with explanation.

The most important thing you need to know is, that if you use spl_autoload_register(), you add an autoloader to a queue.
This means, that the last autoloader you added will only be called, if the ones registered before(of course the standard
loader too) can not find the class and do not throw exceptions. By knowing that you can imagine that there will be 3
autoloader implementations:

* The native one
* The one of the framework you work in
* The BlazeFramework autoloader

The native one is transparent for you, so you only have to care about the last two. You could wrap around the second one
and define your own autoloader implementation which could look like this:

    function autoLoad($className){
        try{
           OtherFramework::autoLoad($className);
        }catch(Exception $e){}
    }

By registering this implementation instead of the one the framework says you to do, the BlazeFramework class loader
is invoked if no class with the given className could be found. Note that the class loader of the BlazeFramework will
throw a `\blaze\lang\ClassNotFoundException` if no class with the given name can be found. To wrap around the implementation
of the BlazeFramework you will have to make a call to the class loader. Do not forget that the 3 files must be included
before. The implementation could look like this:

    function autoLoad($className){
        try{
           \blaze\lang\ClassLoader::autoLoad($className);
        }catch(Exception $e){}
    }


Testing
-------

To use the framework in e.g. a PHPUnit test, you will need to define a `bootstrap.php` which includes the 3 files and
registers the class loader. PHPUnit does sometimes some strange things with the `System` class which is responsible
for the implicit type conversion and boxing. You will get then an error that the type `int` was expected but `integer` given
or so, then you should try to use the following command:

    \blaze\lang\ClassLoader::getSystemClassLoader();

This will initialize the `System` class too and set the `systemErrorHandler` which is responsible for the conversions.

The directory in which the tests are located is of course the dir `test`. The configuration for PHPUnit which is only the definition of the bootstrap at the
moment, can be found in `other/phpunit.xml`. By calling `phpunit --configuration PATH_TO_DIR/other/phpunit.xml PATH_TO_DIR/test` you can run all test cases.