<?php
namespace blaze\xml;
use blaze\lang\Object;

/**
 * A XMLWriter has to implement a current element which is used to determine
 * wether a write action is valid or not. If it is not, a XMLWriterException has to be thrown.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0
 * @see     http://www.javacommerce.com/displaypage.jsp?name=intro.sql&id=18238

 */
interface XMLWriter extends \blaze\io\Closeable, \blaze\io\Flushable{

    /**
     * Returns the prefix for the given URI
     * @param string|blaze\lang\String $URI
     * @return string
     */
    public function getPrefix($URI);
    /**
     * Sets the prefix for the given URI
     * @param string|blaze\lang\String $prefix
     * @param string|blaze\lang\String $URI
     */
    public function setPrefix($prefix, $URI);
    /**
     * Sets the given URI as default namespace
     * @param string|blaze\lang\String $URI
     */
    public function setDefaultNamespace($URI);

    /**
     * Writes a processing instruction
     * @param string|blaze\lang\String $prefix
     * @param string|blaze\lang\String $URI
     */
    public function writeProcessingInstruction($target, $data = null);
    
    /**
     * Writes a DTD tag
     * @param string|blaze\lang\String $name The DTD name. 
     * @param string|blaze\lang\String $publicId The external subset public identifier. 
     * @param string|blaze\lang\String $systemId The external subset system identifier.  
     * @param string|blaze\lang\String $subset The content of the DTD. 
     */
    public function writeDTD($name, $publicId = null, $systemId = null, $subset = null);
    /**
     * Writes a DTD attribute list
     * @param string|blaze\lang\String $name The name of the DTD attribute list. 
     * @param string|blaze\lang\String $content The content of the DTD attribute list. 
     */
    public function writeDTDAttlist($name, $content);
    /**
     * Writes a DTD element
     * @param string|blaze\lang\String $name The name of the DTD element.
     * @param string|blaze\lang\String $content The content of the DTD element.
     */
    public function writeDTDElement($name, $content);
    /**
     * Writes a DTD entity
     * @param string|blaze\lang\String $name The name of the DTD entity. 
     * @param string|blaze\lang\String $content The content of the DTD entity. 
     * @param string|blaze\lang\String $publicId The public id for external entities. 
     * @param string|blaze\lang\String $systemId The system id for external entities. 
     * @param string|blaze\lang\String $nDataId The NDATA id for external entities. 
     */
    public function writeDTDEntity($name, $content, $publicId, $systemId, $nDataId);

    /**
     * Writes the start of a DTD
     * @param string|blaze\lang\String $name The name of the DTD.
     * @param string|blaze\lang\String $publicId The external subset public identifier.
     * @param string|blaze\lang\String $systemId The external subset system identifier.
     */
    public function writeStartDTD($name, $publicId = null, $systemId = null);
    /**
     * Writes the end of a DTD
     */
    public function writeEndDTD();

    /**
     * Writes an attribute.
     * @param string|blaze\lang\String $name The name of the attribute
     * @param string|blaze\lang\String $value The value of the attribute
     * @param string|blaze\lang\String $namespaceURI The URI to the namespace of the attribute
     * @param string|blaze\lang\String $prefix The namespace prefix.
     */
    public function writeAttribute($name, $value, $namespaceURI = null, $prefix = null);
    /**
     * Writes a CDATA section.
     * @param string|blaze\lang\String $data The data.
    */
    public function writeCData($data);
    /**
     * Writes normal text.
     * @param string|blaze\lang\String $text The text.
    */
    public function writeText($text);
    /**
     * Writes a comment section with the given comment.
     * @param string|blaze\lang\String $comment The comment.
    */
    public function writeComment($comment);

    /**
     * Write the start of a document with standard processing instruction.
     * @param string|blaze\lang\String $xmlVersion The xml version
     * @param string|blaze\lang\String $encoding The xml encoding
     * @param string|blaze\lang\String $standalone Defines if the xml document is standalone
     */
    public function writeStartDocument($xmlVersion = null, $encoding = null, $standalone = null);
    /**
     * Ends a document
     */
    public function writeEndDocument();

    /**
     * Writes the start of an element
     * @param string|blaze\lang\String $name The name of the element
     * @param string|blaze\lang\String $namespaceURI The namespace of the element
     * @param string|blaze\lang\String $prefix The prefix of the namespace
     */
    public function writeStartElement($name, $namespaceURI = null, $prefix = null);
    /**
     * Ends an element
     */
    public function writeEndElement();
    /**
     * Writes an empty element
     * @param string|blaze\lang\String $name The name of the element
     * @param string|blaze\lang\String $namespaceURI The namespace of the element
     * @param string|blaze\lang\String $prefix The prefix of the namespace
     */
    public function writeEmptyElement($name, $namespaceURI = null, $prefix = null);
}

?>
