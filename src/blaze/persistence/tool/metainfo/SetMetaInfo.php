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
class SetMetaInfo extends Object implements MetaInfo{

    private $name;
    private $schema;
    private $table;
    private $cascade;
    private $inverse;
    private $key;
    private $association;

    public function __construct() {

    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSchema() {
        return $this->schema;
    }

    public function setSchema($schema) {
        $this->schema = $schema;
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function getCascade() {
        return $this->cascade;
    }

    public function setCascade($cascade) {
        $this->cascade = $cascade;
    }

    public function getInverse() {
        return $this->inverse;
    }

    public function setInverse($inverse) {
        $this->inverse = $inverse;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getAssociation() {
        return $this->association;
    }

    public function setAssociation($association) {
        $this->association = $association;
    }

    public function fromXml(\DOMNode $xmlNode){
        $this->name = $xmlNode->getAttribute('name');
        $this->schema = $xmlNode->getAttribute('schema');
        $this->table = $xmlNode->getAttribute('table');
        $this->cascade = $xmlNode->getAttribute('cascade');
        $this->inverse = $xmlNode->getAttribute('inverse');

        foreach($xmlNode->childNodes as $child){
            switch ($child->localName) {
                case 'key':
                    $member = new KeyMetaInfo();
                    $member->fromXml($child);
                    $this->key = $member;
                    break;
                case 'one-to-many':
                    $member = new OneToManyMetaInfo();
                    $member->fromXml($child);
                    $this->association = $member;
                    break;
                case 'many-to-many':
                    $member = new ManyToManyMetaInfo();
                    $member->fromXml($child);
                    $this->association = $member;
                    break;
                default: //Exception
                    break;
            }
        }
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('set');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'name', $this->name);
        AttributeUtil::set($node,'schema', $this->schema);
        AttributeUtil::set($node,'table', $this->table);
        AttributeUtil::set($node,'cascade', $this->cascade);
        AttributeUtil::set($node,'inverse', $this->inverse);
        if($this->key != null)
            $this->key->toXml($node, $doc);
        if($this->association != null)
            $this->association->toXml($node, $doc);
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer){
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @var blaze\\collections\\Set['.$this->association->getClass().']'.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'private $');
        $buffer->append($this->name);
        $buffer->append(';'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @return blaze\\collections\\Set['.$this->association->getClass().']'.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function get'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'(){'.PHP_EOL);
        $buffer->append("\t"."\t".' return $this->'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @param blaze\\collections\\Set['.$this->association->getClass().'] $'.$this->name.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function set'.\blaze\lang\String::asWrapper($this->name)->toUpperCase(true)->toNative().'($'.$this->name.'){'.PHP_EOL);
        $buffer->append("\t"."\t".' $this->'.$this->name.' = $'.$this->name.';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
    }

}

?>
