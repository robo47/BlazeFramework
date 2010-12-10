<?php

namespace blaze\xml;

use blaze\lang\Object;

/**
 * The XMLReader's getElementType has to be START_DOCUMENT before the first nextElement call and END_DOCUMENT if nextElement returns false for the first time.
 * If an undefined index of an attribute is requested with the getAttribute* method, a XMLReaderException should be thrown.
 * The current element may be null if the nextElement method returned false for the first time.
 * The current attribute may be null if the nextElement method returned false for the first time or if an element has no attributes.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class XMLDocument extends XMLNode {

    private $doc;

    public function __construct($version ='1.0', $encoding = 'utf-8') {
        $this->doc = new \DOMDocument($version, $encoding);
    }

    public function createAttribute($name) {
        return $this->doc->createAttribute($name);
    }

    public function createAttributeNS($namespaceURL, $qualifiedName) {
        return $this->doc->createAttributeNS($namespaceURL, $qualifiedName);
    }

    public function createCDATASection($data) {
        return $this->doc->createCDATASection($data);
    }

    public function createComment($data) {
        return $this->doc->createComment($data);
    }

    public function createDocumentFragment() {
        return $this->doc->createDocumentFragment();
    }

    public function createElement($name, $value = null) {
        return $this->doc->createElement($name, $value);
    }

    public function createElementNS($namespaceURL, $qualifiedName, $value = null) {
            return $this->doc->createElementNS($namespaceURL, $qualifiedName, $value);
    }

    public function createEntityReference($name) {
        return $this->doc->createEntityReference($name);
    }

    public function createProcessingInstruction($target, $data = null) {
        return $this->doc->createProcessingInstruction($target, $data);
    }

    public function createTextNode($content) {
        return $this->doc->createTextNode($content);
    }

    public function getElementById($elementId) {
        return $this->doc->getElementById($elementId);
    }

    public function getElementsByTagName($name) {
        return $this->doc->getElementsByTagName($name);
    }

    public function getElementsByTagNameNS($namespaceURL, $localName) {
        return $this->doc->getElementsByTagNameNS($namespaceURL, $localName);
    }

    public function importNode(XMLNode $importedNode, $deep = null) {
        return $this->doc->importNode($importedNodeDOMNode, $deep);
    }

    public function load($filename, $options = null) {
        return $this->doc->load($filename, $options);
    }

    public function loadHTML($source) {
        return $this->doc->loadHTML($source);
    }

    public function loadHTMLFile($filename) {
        return $this->doc->loadHTMLFile($filename);
    }

    public function loadXML($source, $options = null) {
        return $this->doc->loadXML($source, $options);
    }

    public function normalizeDocument() {
        return $this->doc->normalizeDocument();
    }

    public function registerNodeClass($baseclass, $extendedclass) {
        return $this->doc->registerNodeClass($baseclass, $extendedclass);
    }

    public function relaxNGValidate($filename) {
        return $this->doc->relaxNGValidate($filename);
    }

    public function relaxNGValidateSource($source) {
        return $this->doc->relaxNGValidateSource($source);
    }

    public function save($filename, $options = null) {
        return $this->doc->save($filename, $options);
    }

    public function saveHTML() {
        return $this->doc->saveHTML();
    }

    public function saveHTMLFile($filename) {
        return $this->doc->saveHTMLFile($filename);
    }

    public function saveXML(XMLNode $node = null, $options = null) {
        return $this->doc->saveXML($node, $options);
    }

    public function schemaValidate($filename) {
        return $this->doc->schemaValidate($filename);
    }

    public function schemaValidateSource($source) {
        return $this->doc->schemaValidateSource($source);
    }

    public function validate() {
        return $this->doc->validate();
    }

    public function xinclude($options = null) {
        return $this->doc->xinclude($options);
    }

}

?>
