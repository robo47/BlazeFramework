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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class IntegerValidator implements Validator{
    public function validate($obj) {
        if(!Integer::isNativeType($obj))
            throw new ValidatorException('No valid integer.');
    }

}

?>
