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
class XMLNode extends Object {

    public function appendChild(XMLNode $newnode) {

    }

    public function cloneNode($deep = null) {

    }

    public function getLineNo() {

    }

    public function hasAttributes() {

    }

    public function hasChildNodes() {

    }

    public function insertBefore(XMLNode $newnode, XMLNode $refnode = null) {

    }

    public function isDefaultNamespace( $namespaceURL) {

    }

    public function isSameNode(XMLNode $node) {

    }

    public function isSupported( $feature,  $version) {

    }

    public function lookupNamespaceURL( $prefix) {

    }

    public function lookupPrefix( $namespaceURL) {

    }

    public function normalize() {

    }

    public function removeChild(XMLNode $oldnode) {

    }

    public function replaceChild(XMLNode $newnode, XMLNode $oldnode) {

    }

}

?>
