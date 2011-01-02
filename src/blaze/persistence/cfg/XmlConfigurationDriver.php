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
class XmlConfigurationDriver extends Object implements ConfigurationDriver {


    /**
     *
     * @param \DOMDocument $doc
     * @return XmlConfigurationDriver
     */
     private function parseDom(\blaze\persistence\cfg\Configuration $config, \DOMDocument $doc, \blaze\lang\String $name, \blaze\io\File $file = null){
        if($doc->documentElement->localName != 'persistence-configuration')
                throw new \blaze\lang\IllegalArgumentException($name.': The first node has to be of the type "persistence-configuration"');
        if($doc->documentElement->firstChild->localName != 'persistence-factory')
                throw new \blaze\lang\IllegalArgumentException($name.': The first child node has to be of the type "persistence-factory"');

        foreach($doc->documentElement->firstChild->childNodes as $child){
            switch($child->localName){
                case 'property':
                    if($child->firstChild instanceof \DOMText)
                        $config->setProperty($child->getAttribute('name'),$child->firstChild->wholeText);
                    else
                        $config->setProperty($child->getAttribute('name'),'');
                    break;
                case 'mapping':
                    if($file === null)
                        throw new \blaze\lang\Exception('The mapping-tag can only be used if a file or a base path is given.');
                    $config->addRessource(new \blaze\io\File($file->getParent(),$child->getAttribute('ressource')));
                    break;
            }
        }
     }

    public function parse(\blaze\persistence\cfg\Configuration $config, $content, $basePath = null) {
        $doc = new \DOMDocument();
        $doc->loadXML($content);
        if($basePath !== null)
            $this->parseDom($config, $doc, 'Content', new File($basePath));
        else
            $this->parseDom($config, $doc, 'Content');
    }

    public function parseFile(\blaze\persistence\cfg\Configuration $config, $file) {
        $f = null;

        if($file instanceof \blaze\io\File)
            $f = $file;
        else
            $f = new \blaze\io\File(\blaze\lang\String::asNative($file));
        $doc = new \DOMDocument();
        $doc->load($f->getAbsolutePath());
        $this->parseDom($config, $doc, $f->getName(), $f);
    }

    public function save(\blaze\persistence\cfg\Configuration $config, $file) {
        $f = null;

        if($file instanceof \blaze\io\File)
            $f = $file;
        else
            $f = new \blaze\io\File(\blaze\lang\String::asNative($file));


    }

}

?>
