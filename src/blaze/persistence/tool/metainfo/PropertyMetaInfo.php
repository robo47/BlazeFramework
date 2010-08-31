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
class PropertyMetaInfo extends Object implements MetaInfo{

    protected $name;
    protected $type;
    protected $column;

    public function __construct() {

    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getColumn() {
        return $this->column;
    }

    public function setColumn($column) {
        $this->column = $column;
    }

    public function fromXml(\DOMNode $xmlNode){
        $this->name = $xmlNode->getAttribute('name');
        $this->type = $xmlNode->getAttribute('type');

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
        $node = $doc->createElement('property');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'name', $this->name);
        AttributeUtil::set($node,'type', $this->type);
        if($this->column != null)
            $this->column->toXml($node, $doc);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @var '.$this->type.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'private $');
        $buffer->append($this->name);
        $buffer->append(';'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @return '.$this->type.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function get'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'(){'.PHP_EOL);
        $buffer->append("\t"."\t".' return $this->'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @param '.$this->type.' $'.$this->name.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function set'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'($'.$this->name.'){'.PHP_EOL);
        $buffer->append("\t"."\t".' $this->'.$this->name.' = $'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
    }

}

?>
