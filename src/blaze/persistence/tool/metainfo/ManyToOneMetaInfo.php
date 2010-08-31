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
class ManyToOneMetaInfo extends Object implements MetaInfo{

    private $name;
    private $className;
    private $column;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getClassName() {
        return $this->className;
    }

    public function setClassName($className) {
        $this->className = $className;
    }

    public function getColumn() {
        return $this->column;
    }

    public function setColumn($column) {
        $this->column = $column;
    }

    
    public function fromXml(\DOMNode $xmlNode){
        $this->name = $xmlNode->getAttribute('name');
        $this->className = $xmlNode->getAttribute('class');

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
        $node = $doc->createElement('many-to-one');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'name', $this->name);
        AttributeUtil::set($node,'class', $this->className);
        if($this->column != null)
            $this->column->toXml($node, $doc);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @var '.$this->className.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'private $');
        $buffer->append($this->name);
        $buffer->append(';'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @return '.$this->className.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function get'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'(){'.PHP_EOL);
        $buffer->append("\t"."\t".' return $this->'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @param '.$this->className.' $'.$this->name.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function set'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'($'.$this->name.'){'.PHP_EOL);
        $buffer->append("\t"."\t".' $this->'.$this->name.' = $'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
    }

}

?>
