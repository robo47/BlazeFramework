<?php

namespace blaze\persistence\tool\metainfo;

use blaze\lang\Object;

/**
 * Description of ManyToOneMetaInfo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class ManyToManyMetaInfo extends Object implements MetaInfo{

    private $column;
    private $className;
    
    public function getColumn() {
        return $this->column;
    }

    public function setColumn($column) {
        $this->column = $column;
    }

    public function getClassName() {
        return $this->className;
    }

    public function setClassName($className) {
        $this->className = $className;
    }

    
    public function fromXml(\DOMNode $xmlNode){
        $this->column = $xmlNode->getAttribute('column');
        $this->className = $xmlNode->getAttribute('class');
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('many-to-many');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'column', $this->column);
        AttributeUtil::set($node,'class', $this->className);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){

    }

}

?>
