<?php

namespace blaze\web\validator;

use blaze\lang\Singleton;

/**
 * Description of Validator
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Validator {
    public function validate(\blaze\web\application\BlazeContext $context, $obj);
}

?>
