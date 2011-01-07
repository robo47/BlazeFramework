<?php

namespace blaze\persistence\meta\driver;

use blaze\lang\Object;

/**
 * Description of ClassMetaInfo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class AttributeUtil extends Object {

    public static function set(\DOMElement $node, $key, $value) {
        if ($value != null && $value != '')
            $node->setAttribute($key, $value);
    }

}

?>
