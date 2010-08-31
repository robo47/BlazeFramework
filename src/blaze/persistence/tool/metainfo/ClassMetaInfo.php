<?php

namespace blaze\persistence\tool\metainfo;

use blaze\lang\Object;

/**
 * Description of ClassMetaInfo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class ClassMetaInfo extends Object implements MetaInfo {

    private $name;
    private $package;
    private $schema;
    private $table;
    private $members = array();

    public function __construct() {

    }

    public function addMember($member) {
        $this->members[] = $member;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPackage() {
        return $this->package;
    }

    public function setPackage($package) {
        $this->package = $package;
    }

    public function getMembers() {
        return $this->members;
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

    public function fromXml(\DOMNode $xmlNode) {
        if ($xmlNode->localName != 'class')
            throw new \blaze\lang\Exception('First element must be of the typ class');
        $this->name = $xmlNode->getAttribute('name');
        $this->package = $xmlNode->getAttribute('package');
        $this->schema = $xmlNode->getAttribute('schema');
        $this->table = $xmlNode->getAttribute('table');

        foreach ($xmlNode->childNodes as $node) {
            switch ($node->localName) {
                case 'id':
                    $member = new IdMetaInfo();
                    break;
                case 'property':
                    $member = new PropertyMetaInfo();
                    break;
                case 'many-to-one':
                    $member = new ManyToOneMetaInfo();
                    break;
                case 'set':
                    $member = new SetMetaInfo();
                    break;
                default: //Exception
                    break;
            }
            $member->fromXml($node);
            $this->members[] = $member;
        }
    }

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc) {
        $node = $doc->createElement('class');
        $parentNode->appendChild($node);
        AttributeUtil::set($node, 'name', $this->name);
        AttributeUtil::set($node, 'schema', $this->schema);
        AttributeUtil::set($node, 'package', $this->package);
        AttributeUtil::set($node, 'table', $this->table);

        foreach ($this->members as $member) {
            $member->toXml($node, $doc);
        }
    }

    public function toPhp(\blaze\lang\StringBuffer $buffer) {
        if ($this->package != null) {
            $packageName = $this->packageName;
            $className = $this->className;
        } else {
            $className = \blaze\lang\String::asWrapper($this->name);
            $idx = $className->lastIndexOf('\\');
            $packageName = $className->substring(0, $idx)->toNative();
            $className = $className->substring($idx + 1)->toNative();
        }

        $buffer->append('<?php '.PHP_EOL.PHP_EOL);
        $buffer->append('namespace ');
        $buffer->append($packageName);
        $buffer->append(';' . PHP_EOL.PHP_EOL);
        $buffer->append('class ');
        $buffer->append($className);
        $buffer->append(' extends \\blaze\\lang\\Object {' . PHP_EOL.PHP_EOL);

        foreach ($this->members as $member) {
            $member->toPhp($buffer);
        }

        $buffer->append('}');
    }

}

?>
