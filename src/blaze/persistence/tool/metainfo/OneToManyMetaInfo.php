<?php

namespace blaze\persistence\tool\metainfo;

use blaze\lang\Object;

/**
 * Description of OneToManyMetaInfo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class OneToManyMetaInfo extends Object implements MetaInfo{

    private $className;
    
    public function getClassName() {
        return $this->className;
    }

    public function setClassName($className) {
        $this->className = $className;
    }

    
    public function fromXml(\DOMNode $xmlNode){
        $this->className = $xmlNode->getAttribute('class');
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('one-to-many');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'class', $this->className);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){

    }

}

?>
