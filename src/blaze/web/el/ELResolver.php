<?php
namespace blaze\web\el;
use blaze\lang\Object,
    blaze\util\Map,
    blaze\lang\NullPointerException;

/**
 * Description of ELResolver
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ELResolver extends Object{
    /**
     *
     * @var blaze\web\el\ELContext
     */
    protected $context;

    public function __construct(ELContext $context) {
        $this->context = $context;
    }

    public function getValue(Expression $expr){
        $str = $expr->getExpressionString();
        $parts = $str->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);
        
        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount; $i++){
            if($obj == null)
                throw new NullPointerException($parts[$i-1].' is null');
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        return $obj;
    }

    public function setValue(Expression $expr, $value){
        $str = $expr->getExpressionString();
        $parts = $str->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount - 1; $i++){
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod('set'.$parts[$partsCount - 1]->toUpperCase(true));
        $method->invoke($obj, $value);
    }
    /**
     *
     * @param Expression $expr
     * @param array $values 
     */
    public function invoke(Expression $expr, $values){
        $str = $expr->getExpressionString();
        $parts = $str->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount - 1; $i++){
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod($parts[$partsCount - 1]->toUpperCase(true));
        return $method->invoke($obj, $values);
    }
}

?>
