<?php

namespace blaze\persistence\meta\driver;

use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class XmlMetaDriver extends Object implements \blaze\persistence\meta\MetaDriver {

    /**
     *
     * @param string|blaze\lang\String $content
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function parse($content) {
        $doc = new \DOMDocument();
        $doc->loadXML($content);
        return $this->parseDom($doc, 'Content');
    }

    /**
     *
     * @param string|blaze\lang\String|blaze\io\File $config
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function parseFile($config) {
        $file = null;

        if ($config instanceof \blaze\io\File)
            $file = $config;
        else
            $file = new \blaze\io\File(\blaze\lang\String::asNative($config));
        $doc = new \DOMDocument();
        $doc->load($file->getAbsolutePath());
        return $this->parseDom($doc, $file->getName());
    }

    /**
     *
     * @param string|blaze\lang\String|blaze\io\File $dir
     * @param boolean $recursive
     * @return \blaze\collections\ListI[\blaze\persistence\meta\ClassDescriptor]
     */
    public function parseDirectory($dir, $recursive = false) {
        $file = null;

        if ($config instanceof \blaze\io\File)
            $file = $config;
        else
            $file = new \blaze\io\File(\blaze\lang\String::asNative($config));
        if (!$file->isDirectory())
            throw new \blaze\lang\IllegalArgumentException('The given file is not a directory.');
        return $this->parseDir($file, $recursive);
    }

    /**
     *
     * @param \blaze\io\File $dir
     * @param boolean $recursive
     * @return \blaze\collections\ListI
     */
    private function parseDir(\blaze\io\File $dir, $recursive) {
        $mappings = new \blaze\collections\lists\ArrayList();
        $files = $dir->listFiles();

        foreach ($files as $file) {
            if ($recursive && $file->isDirectory())
                $mappings->addAll($this->parseDir($file, $recursive));
            if ($file->getFileName()->endsWith('.xml'))
                $mappings->add($this->parseFile($file));
        }
        return $mappings;
    }

    /**
     *
     * @param \DOMDocument $doc
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    private function parseDom(\DOMDocument $doc, \blaze\lang\String $name) {
        if ($doc->documentElement->localName != 'persistence-mapping')
            throw new \blaze\lang\Exception($name . ': The first element must be of the type persistence-mapping');

        $xmlNode = $doc->documentElement->firstChild;
        if ($xmlNode->localName != 'class')
            throw new \blaze\lang\Exception($name . ': First element must be of the typ class');

        $class = new \blaze\persistence\meta\ClassDescriptor();
        $table = new \blaze\persistence\meta\TableDescriptor();

        $class->setName($xmlNode->getAttribute('name'));
        $class->setPackage($xmlNode->getAttribute('package'));

        $table->setName($xmlNode->getAttribute('table'));
        $table->setSchema($xmlNode->getAttribute('schema'));
        $class->setTableDescriptor($table);

        foreach ($xmlNode->childNodes as $node) {
            switch ($node->localName) {
                case 'id':
                    $class->addIdentifier($this->parseId($node));
                    break;
                case 'property':
                    $class->addSingleField($this->parseField($node));
                    break;
                case 'many-to-one':
                    $class->addSingleField($this->parseManyToOne($node));
                    break;
                case 'one-to-one':
//                    $class->addOneToOneRelation($this->parseOneToOne($node));
                    break;
                case 'set':
                    $class->addCollectionField($this->parseCollection($node));
                    break;
                default: //Exception
                    break;
            }
        }

        return $class;
    }

    /**
     *
     * @param \DOMNode $xmlNode
     * @return \blaze\persistence\meta\IdDescriptor 
     */
    private function parseId(\DOMNode $xmlNode) {
        $id = new \blaze\persistence\meta\IdDescriptor();
        $id->setSingleFieldDescriptor($this->parseField($xmlNode));
        return $id;
    }

    /**
     *
     * @param \DOMNode $xmlNode
     * @param string $type
     * @return \blaze\persistence\meta\PropertyDescriptor 
     */
    private function parseField(\DOMNode $xmlNode, $type = 'type') {
        $field = new \blaze\persistence\meta\SingleFieldDescriptor();
        $field->setName($xmlNode->getAttribute('name'));
        $field->setType($xmlNode->getAttribute($type));

        switch ($xmlNode->firstChild->localName) {
            case 'column':
                $field->setColumnDescriptor($this->parseColumn($xmlNode->firstChild));
                break;
            default: //Exception
                break;
        }
        return $field;
    }

    /**
     *
     * @param \DOMNode $xmlNode
     * @return \blaze\persistence\meta\OneToManyDescriptor 
     */
    private function parseManyToOne(\DOMNode $xmlNode) {
        $manyToOne = new \blaze\persistence\meta\SingleFieldDescriptor();
        $manyToOne->setName($xmlNode->getAttribute('name'));

        $manyToOne->setType(\blaze\persistence\meta\ClassDescriptor::getClassDescriptor($xmlNode->getAttribute('class'))->getName());

        $column = new \blaze\persistence\meta\ColumnDescriptor();
        $column->setName($xmlNode->getAttribute('column'));
        $manyToOne->setColumnDescriptor($column);

        return $manyToOne;
    }

    /**
     *
     * @param \DOMNode $xmlNode
     * @return \blaze\persistence\meta\OneToManyDescriptor
     */
    private function parseOneToOne(\DOMNode $xmlNode) {
//        $oneToMany = new \blaze\persistence\meta\OneToManyDescriptor();
//        $oneToMany->setFieldDescriptor($this->parseField($xmlNode, 'class'));
//        //set class descriptor
//        return $oneToMany;
    }

    /**
     *
     * @param \DOMNode $xmlNode 
     */
    private function parseCollection(\DOMNode $xmlNode) {
        $collection = new \blaze\persistence\meta\CollectionFieldDescriptor();
        $field = new \blaze\persistence\meta\SingleFieldDescriptor();
        $field->setName($xmlNode->getAttribute('name'));
        $field->setType(new \blaze\lang\String('blaze\\collections\\Set'));
        $collection->setFieldDescriptor($field);

        $tbl = $xmlNode->getAttribute('table');
        if ($tbl !== '') {
            // many-to-many
            $collection->setTableDescriptor(\blaze\persistence\meta\TableDescriptor::getTableDescriptor($tbl));
            $column = new \blaze\persistence\meta\ColumnDescriptor();
            $column->setName($xmlNode->getAttribute('column'));
            $collection->setColumnDescriptor($column);

            foreach ($xmlNode->childNodes as $node) {
                if ($node->localName === 'many-to-many') {
                    $collection->setClassDescriptor(\blaze\persistence\meta\ClassDescriptor::getClassDescriptor($node->getAttribute('class')));
                    $column = new \blaze\persistence\meta\ColumnDescriptor();
                    $column->setName($node->getAttribute('column'));
                    $collection->setJunctionColumnDescriptor($column);
                }
            }
        } else {
            // one-to-many
            $column = new \blaze\persistence\meta\ColumnDescriptor();
            $column->setName($xmlNode->getAttribute('column'));
            $collection->setColumnDescriptor($column);

            foreach ($xmlNode->childNodes as $node) {
                if ($node->localName === 'one-to-many') {
                    $collection->setClassDescriptor(\blaze\persistence\meta\ClassDescriptor::getClassDescriptor($node->getAttribute('class')));
                }
            }
        }
        return $collection;
    }

    /**
     *
     * @param \DOMNode $xmlNode
     * @return \blaze\persistence\meta\ColumnDescriptor 
     */
    private function parseColumn(\DOMNode $xmlNode) {
        $column = new \blaze\persistence\meta\ColumnDescriptor();
        $column->setName($xmlNode->getAttribute('name'));
        $column->setLength($xmlNode->getAttribute('length'));
        $column->setNullable($xmlNode->getAttribute('nullable'));
        return $column;
    }

    /**
     *
     * @param \blaze\persistence\meta\ClassDescriptor $config
     * @param File $file
     */
    public function save(\blaze\persistence\meta\ClassDescriptor $config, $file) {
        $f = null;

        if ($file instanceof \blaze\io\File)
            $f = $file;
        else
            $f = new \blaze\io\File(\blaze\lang\String::asNative($file));

        $doc = new \DOMDocument();
        $root = $doc->createElement('persistence-mapping');
        $doc->appendChild($root);
        $node = $doc->createElement('class');
        $root->appendChild($node);

        AttributeUtil::set($node, 'package', $config->getPackage());
        AttributeUtil::set($node, 'name', $config->getName());
        AttributeUtil::set($node, 'schema', $config->getTableDescriptor()->getSchema());
        AttributeUtil::set($node, 'table', $config->getTableDescriptor()->getName());

        foreach ($config->getIdentifiers() as $member) {
            $this->saveId($node, $doc, $member);
        }

        foreach ($config->getSingleFields() as $member) {
            $this->saveField($node, $doc, $member);
        }

        foreach ($config->getCollectionFields() as $member) {
            $this->saveCollection($node, $doc, $member);
        }

        $doc->save($f->getAbsolutePath());
    }

    /**
     *
     * @param \DOMNode $parentNode
     * @param \DOMDocument $doc
     * @param \blaze\persistence\meta\IdDescriptor $id 
     */
    private function saveId(\DOMNode $parentNode, \DOMDocument $doc, \blaze\persistence\meta\IdDescriptor $id) {
        $node = $doc->createElement('id');
        $parentNode->appendChild($node);
        AttributeUtil::set($node, 'name', $id->getFieldDescriptor()->getName());
        AttributeUtil::set($node, 'type', $id->getFieldDescriptor()->getType());

        if ($id->getFieldDescriptor()->getColumnDescriptor() != null)
            $this->saveColumn($node, $doc, $id->getFieldDescriptor()->getColumnDescriptor());
    }

    /**
     *
     * @param \DOMNode $parentNode
     * @param \DOMDocument $doc
     * @param \blaze\persistence\meta\PropertyDescriptor $property 
     */
    private function saveField(\DOMNode $parentNode, \DOMDocument $doc, \blaze\persistence\meta\SingleFieldDescriptor $field) {
        if ($field->getColumnDescriptor()->isForeignKey()) {
            $node = $doc->createElement('many-to-one');
            $parentNode->appendChild($node);
            AttributeUtil::set($node, 'name', $field->getName());
            AttributeUtil::set($node, 'class', $field->getType());

            if ($field->getColumnDescriptor() != null)
                AttributeUtil::set($node, 'column', $field->getColumnDescriptor()->getName());
        }else {
            $node = $doc->createElement('property');
            $parentNode->appendChild($node);
            AttributeUtil::set($node, 'name', $field->getName());
            AttributeUtil::set($node, 'type', $field->getType());

            if ($field->getColumnDescriptor() != null)
                $this->saveColumn($node, $doc, $field->getColumnDescriptor());
        }
    }

    /**
     *
     * @param \DOMNode $parentNode
     * @param \DOMDocument $doc
     * @param \blaze\persistence\meta\CollectionFieldDescriptor $collectionField
     */
    private function saveCollection(\DOMNode $parentNode, \DOMDocument $doc, \blaze\persistence\meta\CollectionFieldDescriptor $collectionField) {
        $node = $doc->createElement('set');
        $parentNode->appendChild($node);
        AttributeUtil::set($node, 'name', $collectionField->getFieldDescriptor()->getName());
        AttributeUtil::set($node, 'column', $collectionField->getColumnDescriptor()->getName());

        if ($collectionField->getJunctionColumnDescriptor() !== null) {
            // many-to-many
            AttributeUtil::set($node, 'table', $collectionField->getTableDescriptor()->getName());
            $node1 = $doc->createElement('many-to-many');
            AttributeUtil::set($node1, 'class', $collectionField->getClassDescriptor()->getName());
            AttributeUtil::set($node1, 'column', $collectionField->getJunctionColumnDescriptor()->getName());
            $node->appendChild($node1);
        } else {
            // one-to-many
            $node1 = $doc->createElement('one-to-many');
            AttributeUtil::set($node1, 'class', $collectionField->getClassDescriptor()->getName());
            $node->appendChild($node1);
        }
    }

    /**
     *
     * @param \DOMNode $parentNode
     * @param \DOMDocument $doc
     * @param \blaze\persistence\meta\ColumnDescriptor $column 
     */
    private function saveColumn(\DOMNode $parentNode, \DOMDocument $doc, \blaze\persistence\meta\ColumnDescriptor $column) {
        $node = $doc->createElement('column');
        $parentNode->appendChild($node);
        AttributeUtil::set($node, 'name', $column->getName());
        AttributeUtil::set($node, 'length', $column->getLength());
        AttributeUtil::set($node, 'nullable', $column->isNullable());
    }

}

?>
