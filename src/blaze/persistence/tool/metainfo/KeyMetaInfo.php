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
class KeyMetaInfo extends Object implements MetaInfo{

    private $column;

    public function __construct() {

    }

    public function getColumn() {
        return $this->column;
    }

    public function setColumn($column) {
        $this->column = $column;
    }

    public function fromXml(\DOMNode $xmlNode){
        switch ($xmlNode->firstChild->localName) {
            case 'column':
                $member = new ColumnMetaInfo();
                break;
            default: //Exception
                break;
        }
        $member->fromXml($xmlNode->firstChild);
        $this->column = $member;
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('key');
        $parentNode->appendChild($node);
        
        if($this->column != null)
            $this->column->toXml($node, $doc);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){
        
    }

}

?>
