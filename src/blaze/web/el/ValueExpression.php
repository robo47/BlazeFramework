<?php
namespace blaze\web\el;

/**
 * Description of ValueExpression
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
