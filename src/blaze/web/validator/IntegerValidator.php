<?php
namespace blaze\web\validator;
use blaze\lang\Object,
    blaze\lang\Integer,
    blaze\lang\String,
    blaze\util\Map;

/**
 * Description of IntegerValidator
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class IntegerValidator implements Validator{
    public function validate(\blaze\web\application\BlazeContext $context, $obj) {
        if(!Integer::isNativeType($obj))
            throw new ValidatorException('No valid integer.');
    }

}

?>
