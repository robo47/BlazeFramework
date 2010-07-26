<?php
namespace blaze\web\el;

/**
 * Description of ValueExpression
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ValueExpression extends Expression{
    public function getValue(ELContext $context){
        return $context->getELResolver()->getValue($this);
    }

    public function setValue(ELContext $context){
        $context->getELResolver()->setValue($this);
    }
}

?>
