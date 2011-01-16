<?php

namespace blaze\web\converter;

use blaze\lang\Singleton;

/**
 * Description of Converter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Converter {
    public function toString(\blaze\web\application\BlazeContext $context, $obj);

    public function toObject(\blaze\web\application\BlazeContext $context, $string);
}

?>
