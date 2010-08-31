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
class IdMetaInfo extends PropertyMetaInfo{

    public function toXml(\DOMNode $parentNode, \DOMDocument $doc){
        $node = $doc->createElement('id');
        $parentNode->appendChild($node);
        AttributeUtil::set($node,'name', $this->name);
        AttributeUtil::set($node,'type', $this->type);
        if($this->column != null)
            $this->column->toXml($node, $doc);
    }

}

?>
