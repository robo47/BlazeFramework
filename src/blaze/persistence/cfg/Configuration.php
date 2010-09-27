<?php
namespace blaze\persistence\cfg;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Configuration extends Object {

    private $properties;
    private $ressources;

    public function __construct(){
        $this->properties = new \blaze\collections\map\Properties();
        $this->ressources = new \blaze\collections\lists\ArrayList();
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\persistence\SessionFactory Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function buildSessionFactory(){
        return new \blaze\persistence\impl\SessionFactoryImpl($this->properties, $this->ressources);
     }

     /**
      *
      * @param string|blaze\lang\String|blaze\io\File $config
      * @return blaze\persistence\cfg\Configuration
      */
     public function configureFile($config){
        $file = null;

        if($config instanceof \blaze\io\File)
            $file = $config;
        else
            $file = new \blaze\io\File(\blaze\lang\String::asNative($config));

        $doc = new \DOMDocument();
        $doc->load($file->getAbsolutePath());

        if($doc->documentElement->localName != 'persistence-configuration')
                throw new \blaze\lang\IllegalArgumentException('The first node has to be of the type "persistence-configuration"');
        if($doc->documentElement->firstChild->localName != 'session-factory')
                throw new \blaze\lang\IllegalArgumentException('The first child node has to be of the type "session-factory"');

        foreach($doc->documentElement->firstChild->childNodes as $child){
            switch($child->localName){
                case 'property':
                    if($child->firstChild instanceof \DOMText)
                        $this->setProperty($child->getAttribute('name'),$child->firstChild->wholeText);
                    else
                        $this->setProperty($child->getAttribute('name'),'');
                    break;
                case 'mapping':
                    $this->addRessource(new \blaze\io\File($file->getParent(),$child->getAttribute('ressource')));
                    break;
            }
        }
         return $this;
     }

     public function addRessource(\blaze\io\File $file){
         $this->ressources->add($file);
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
