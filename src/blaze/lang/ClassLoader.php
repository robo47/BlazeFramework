<?php

namespace blaze\lang;

/**
 * This class sets up the classpath and can load classes. It includes
 * the autoloader which is necessary to be able to use the namespaces.
 * The class Object is already included in the index.php,
 * so ClassLoader can extend it.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author  Christian Beikov
 */
class ClassLoader extends Object {

    /**
     * The singleton instance of the ClassLoader
     * @var blaze\lang\ClassLoader The singleton instance
     */
    private static $instance;
    /**
     * The path to the classes, also to generated classes.
     * @var blaze\lang\String The path to the classes.
     */
    protected $classPath;
    /**
     *
     * @var blaze\lang\ClassLoader
     */
    protected $parent;

    private $classes = array();

    /**
     * Constructs a new ClassLoader
     */
    public function __construct($parent = null) {
        // Split up the path to get the classpath
        // Implode the pathArray to an absolute path which represents the classpath
        $this->classPath = implode(DIRECTORY_SEPARATOR, explode(DIRECTORY_SEPARATOR, __DIR__, -2));
        $this->parent = $parent;
        $this->classes['blaze\\lang\\Reflectable'] = null;
        $this->classes['blaze\\lang\\Object'] = null;
        $this->classes['blaze\\lang\\ClassLoader'] = null;
    }

    /**
     * Returns the singleton instance or creates the first one.
     * @return \blaze\lang\ClassLoader Returns a ClassLoader instance
     */
    public static final function getSystemClassLoader() {
        if (self::$instance == null)
            self::$instance = new ClassLoader();
        return self::$instance;
    }

    protected function isLoadedClass($className){
        return array_key_exists($className, $this->classes);
    }

    public final function isInitializedClass($className){
        $className = trim((string)$className, '\\');
        return $this->isLoadedClass($className) && $this->classes[$className] != null;
    }

    public function findLoadedClass($className){
        $className = trim((string)$className, '\\');
        if (!$this->isLoadedClass($className)) {
            return null;
        }else if(!$this->isInitializedClass($className)){
            $this->classes[$className] = ClassWrapper::forName($className, true, $this);
        }

        return $this->classes[$className];
    }

    public function findClass($className){
        $className = trim((string)$className, '\\');
        $this->loadClass($className);
        return $this->findLoadedClass($className);
    }

    /**
     * Loads a class by classname.
     * @param blaze\lang\String|string $name The full name of the class which shall be loaded.
     */
    public function loadClass($className) {
        $className = trim((string)$className, '\\');
        
        // Check if class was already loaded
        if ($this->isLoadedClass($className))
                return;

        // Try to load the class with the parent
        if($this->parent != null && $this->parent->loadClass($className))
                return true;

        // Setup the full path to the class within the classpath
        $fullName = $this->classPath . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        // Check if the file exists, otherwise throw exception
        if (!file_exists($fullName))
            throw new ClassNotFoundException($className);

        // Include the class which shall be loaded
        require($fullName);

        // Check for static init
        //$class = ClassWrapper::forName($className);
        //if(in_array('blaze\lang\StaticInitialization',$class->getInterfaces()))
        //$class->getMethod('staticInit', null)->invoke(null, null);
        // More native because via Reflection it does not work?
        $arr = class_implements($className, true);


        if (is_array($arr) && in_array('blaze\lang\StaticInitialization', $arr)) {
            // Execute the static initializer
            $className::staticInit(); // maybe faster?
        }

        $this->classes[$className] = null;
        return true;
    }

    /**
     * The autoloader which will be registered with spl_autoload_register().
     * @param blaze\lang\String|string $className The full name of the class which shall be loaded.
     */
    public static function autoLoad($className) {
        self::getSystemClassLoader()->loadClass($className);
    }

    /**
     * Returns the classpath of the current ClassLoader
     * @return blaze\lang\String The absolute path to the classpath as string.
     */
    public function getClassPath() {
        return new String($this->classPath);
    }

    /**
     *
     * @return
     */
    public function getRessourceAsStream($className) {
        $uri = $this->getResource($className);
        try {
            return $uri != null ? $uri->openStream() : null;
        } catch (IOException $e) {
            return null;
        }
    }

    /**
     * @return blaze\net\URI
     */
    public function getRessource($className) {
        throw new Exception('Not yet implemented');
    }

}

?>
