<?php

namespace blaze\web\render\event;

/**
 * Description of RenderKit
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class RenderKitImpl extends \blaze\lang\Object implements \blaze\web\render\RenderKit {

    private $renderer = array();

    public function __construct() {

    }

    public function getRenderer($rendererId) {
        if (!array_key_exists($rendererId, $this->renderer))
            $this->renderer[$rendererId] = \blaze\lang\ClassWrapper::forName('blaze\\web\\render\\event\\' . $rendererId)->newInstance();
        return $this->renderer[$rendererId];
    }

}

?>
