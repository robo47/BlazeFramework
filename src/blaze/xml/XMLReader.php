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
interface XMLReader extends \blaze\io\Closeable{
    const START_ELEMENT = 1;
    const END_ELEMENT = 2;
    const CDATA = 3;
    const COMMENT = 4;
    const START_DOCUMENT = 5;
    const END_DOCUMENT = 6;
    
    /**
     * Returns the count of attributes of the current element
     * @return integer
     */
    public function getAttributeCount();
    /**
     * Returns the name of wether the current attribute or the attribute defined by the index without the prefix by the attribute index
     * @param integer $index
     * @return string
     */
    public function getAttributeLocalName($index = null);
    /**
     * Returns the full qualified name of wether the current attribute or the attribute defined by the index if a prefix is available.
     * @param integer $index
     * @return string
     */
    public function getAttributeName($index = null);
    /**
     * Returns the namespace of wether the current attribute if $index is -1 or the attribute defined by the index.
     * @param string|blaze\lang\String|integer $index
     * @return blaze\net\URI
     */
    public function getAttributeNamespaceURI($index = null);
    /**
     * Returns the prefix which is defined for wether the current attribute in its namespace or the attribute defined by the index.
     * @param string|blaze\lang\String|integer $index
     * @return string
     */
    public function getAttributePrefix($index = null);
    /**
     * Returns the XML type of wether the current attribute or the attribute defined by the index.
     * @param string|blaze\lang\String|integer $index
     * @return string
     */
    public function getAttributeType($index = null);

    // Support for getting the value of an attribute by namespace and local name is not planned at the moment

    /**
     * Returns the value of wether the current attribute or the attribute defined by the index as string.
     * @param string|blaze\lang\String|integer $index
     * @return string
     */
    public function getAttributeValue($index = null);
    /**
     * Returns the character encoding declared on the XML declaration or null if none was declared
     * @return string
     */
    public function getCharacterEncodingScheme();
    /**
     * Return encoding if known otherwise null
     * @return string
     */
    public function getEncoding();
    /**
     * Returns the full qualified name of the current element if a prefix is available
     * @return string
     */
    public function getElementName();
    /**
     * Returns the element name without the prefix
     * @return string
     */
    public function getElementLocalName();
    /**
     * Returns the element type of the current element. See the constants in XMLReader
     * @return XMLReader a constant of the XMLReader
     */
    public function getElementType();
    /**
     * Returns the prefix of the current element if a prefix is available
     * @return string
     */
    public function getElementPrefix();
    /**
     * Returns the content of an element but throws an exception if the element contains tags
     * @return string
     */
    public function getElementText($start = 0, $end = -1);
    /**
     * Returns the length of the text within the current element but throws an exception if the element contains tags
     * @return string
     */
    public function getElementTextLength();
    /**
     * Returns the count of defined namespaces in the document
     * @return integer
     */
    public function getNamespaceCount();
    /**
     * Returns the prefix of a defined namespace in the document by the index
     * @param integer
     * @return string
     */
    public function getNamespacePrefix($index);
    /**
     * Returns the URI to the document definition by the integer index or the prefix
     * @param integer|string|blaze\lang\String $index
     * @return blaze\net\URI
     */
    public function getNamespaceURI($indexOrPrefix);
    /**
     * Returns the text within the current element and throws no exception if it contains tags
     * @return string
     */
    public function getText($start = 0, $end = -1);
    /**
     * Returns the length of the text within the current element
     * @return string
     */
    public function getTextLength();
    /**
     * Returns the XML version of the document
     * @return string
     */
    public function getVersion();
    /**
     * Moves the cursor to the next element
     * @return boolean
     */
    public function nextElement();
    /**
     * Moves the cursor to the next attribute of the current element
     * @return boolean
     */
    public function nextAttribute();
    /**
     * Moves the cursor to the previous element
     * @return boolean
     */
    public function previousElement();
    /**
     * Moves the cursor to the previous attribute of the current element
     * @return boolean
     */
    public function previousAttribute();

    /**
     * Sets the current attribute to the one defined by the index.
     * @param integer|string|blaze\lang\String $index
     * @return boolean wether true on succes or false
     */
    public function moveToAttribute($index = null);

}

?>
