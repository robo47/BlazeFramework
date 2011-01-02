<?php
namespace blaze\persistence\cfg;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Configuration extends Object {

    private $properties;
    private $ressources;

    public function __construct(){
        $this->properties = new \blaze\collections\map\Properties();
        $this->ressources = new \blaze\collections\lists\ArrayList();
    }

    /**
     * Creates a new EntityManager factory
     * @return 	blaze\persistence\EntityManagerFactory 
     */
     public function buildEntityManagerFactory(){
        return new \blaze\persistence\impl\EntityManagerFactoryImpl($this->properties, $this->ressources);
     }

     /**
      *
      * @param string|blaze\lang\String|blaze\io\File $config
      * @param string|blaze\lang\String|\blaze\lang\ClassWrapper $driver
      * @return blaze\persistence\cfg\Configuration
      */
     public function configureFile($config, $driver = 'blaze\\persistence\\cfg\\XmlConfigurationDriver'){
         $this->getConfigDriver($driver)->parseFile($this, $config);
         return $this;
     }

     /**
      *
      * @param string|blaze\lang\String $config
      * @param string|blaze\lang\String|\blaze\lang\ClassWrapper $driver
      * @return blaze\persistence\cfg\Configuration
      */
     public function configureText($config, $driver = 'blaze\\persistence\\cfg\\XmlConfigurationDriver'){
         $this->getConfigDriver($driver)->parse($this, $config);
         return $this;
     }

     /**
      *
      * @param string|blaze\lang\String|blaze\io\File $file
      * @param string|blaze\lang\String|\blaze\lang\ClassWrapper $driver
      * @return blaze\persistence\cfg\Configuration
      */
     public function save($file, $driver = 'blaze\\persistence\\cfg\\XmlConfigurationDriver'){
         $this->getConfigDriver($driver)->save($this, $file);
         return $this;
     }

     /**
      *
      * @param string|blaze\lang\String|\blaze\lang\ClassWrapper $driver
      * @return \blaze\persistence\cfg\ConfigurationDriver
      */
     private function getConfigDriver($driver){
         if(\blaze\lang\String::isType($driver)){
             $driver = \blaze\lang\ClassWrapper::forName($driver);
         }
         if(!$driver instanceof \blaze\lang\ClassWrapper)
             throw new \blaze\lang\IllegalArgumentException('Driver must be a ClassWrapper or the full class name as string.');

         $driver = $driver->newInstance();
         if(!$driver instanceof \blaze\persistence\cfg\ConfigurationDriver)
             throw new \blaze\lang\IllegalArgumentException('No ConfigurationDriver given');
         return $driver;
     }

     /**
      *
      * @param string|blaze\lang\String|\blaze\lang\ClassWrapper $driver
      * @return \blaze\persistence\meta\MetaDriver
      */
     private function getMetaDriver($driver){
         if(\blaze\lang\String::isType($driver)){
             $driver = \blaze\lang\ClassWrapper::forName($driver);
         }
         if(!$driver instanceof \blaze\lang\ClassWrapper)
             throw new \blaze\lang\IllegalArgumentException('Driver must be a ClassWrapper or the full class name as string.');

         $driver = $driver->newInstance();
         if(!$driver instanceof \blaze\persistence\meta\MetaDriver)
             throw new \blaze\lang\IllegalArgumentException('No MetaDriver given');
         return $driver;
     }

     /**
      * Adds the defined mappings of the file to the configuration
      * @param \blaze\io\File $file
      * @param string|blaze\lang\String|blaze\lang\ClassWrapper $driver
      * @return blaze\persistence\cfg\Configuration
      */
     public function addRessource(\blaze\io\File $file, \blaze\lang\ClassLoader $classLoader = null, $driver = 'blaze\\persistence\\meta\\driver\\XmlMetaDriver'){
         $this->ressources->add($this->getMetaDriver($driver)->parseFile($file));
         return $this;
     }

     /**
      * Reads the annotations of the class and adds it to the mappings of the configuration
      * @param string|blaze\lang\String|blaze\lang\ClassWrapper $class
      * @return blaze\persistence\cfg\Configuration
      */
     public function addClass($class){
        if(\blaze\lang\String::isType($class)){
             $class = \blaze\lang\ClassWrapper::forName($class);
         }
         if(!$class instanceof \blaze\lang\ClassWrapper)
             throw new \blaze\lang\IllegalArgumentException('The parameter class must be a ClassWrapper or the full class name as string.');

         $annotations = $class->getAnnotations();
         //Add mapping from the annotations
         return $this;
     }

     /**
      * Adds the defined mappings which are in the directory to the configuration.
      * The filename pattern is driver specific.
      * @param \blaze\io\File $file
      * @param string|blaze\lang\String|blaze\lang\ClassWrapper $driver
      * @return blaze\persistence\cfg\Configuration
      */
     public function addDirectory(\blaze\io\File $file, $recursive = false, $driver = 'blaze\\persistence\\meta\\driver\\XmlMetaDriver'){
         $ressources = $this->getMetaDriver($driver)->parseDirectory($file, $recursive);
         foreach($ressources as $ressource)
            $this->ressources->add($ressource);
         return $this;
     }

     /**
      *
      * @param \blaze\collections\map\Properties $properties
      * @return blaze\persistence\cfg\Configuration
      */
     public function addProperties(\blaze\collections\map\Properties $properties){
        foreach($properties as $key => $value){
            $this->properties->setProperty($key, $value);
        }
        return $this;
     }

     /**
      *
      * @param string $name
      * @param string $value
      * @return blaze\persistence\cfg\Configuration
      */
     public function setProperty($name, $value){
        $this->properties->setProperty($name, $value);
         return $this;
     }

     /**
      *
      * @param string|blaze\lang\String $name
      * @return blaze\lang\String
      */
     public function getProperty($name){
         return $this->properties->getProperty($name);
     }
}

?>
