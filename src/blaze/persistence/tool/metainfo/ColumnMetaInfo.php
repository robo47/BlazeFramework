<?php

namespace blaze\persistence\tool\metainfo;

use blaze\lang\Object;

/**
 * Description of MemberMetaInfo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class ColumnMetaInfo extends Object implements MetaInfo{

    private $name;
    private $length;
    private $notNull;

    public function __construct() {

    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getNotNull() {
        return $this->notNull;
    }

    public function setNotNull($notNull) {
        $this->notNull = $notNull;
    }

    public function fromXml(\DOMNode $xmlNode){
        $this->name = $xmlNode->getAttribute('name');
        $this->length = $xmlNode->getAttribute('length');
        $this->notNull = $xmlNode->getAttribute('not-null');
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('column');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'name', $this->name);
        AttributeUtil::set($node,'length', $this->length);
        AttributeUtil::set($node,'not-null', $this->notNull);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){

    }

}

?>
