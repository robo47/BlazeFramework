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


 * @since   1.0


 */
class ELResolver extends Object {

    /**
     *
     * @var blaze\web\el\ELContext
     */
    protected $context;

    public function __construct(ELContext $context) {
        $this->context = $context;
    }

    private function getValueFromContext($key) {
        $ctx = \blaze\web\application\BlazeContext::getCurrentInstance();
        $key = \blaze\lang\String::asNative($key);

        $val = $this->context->getContext(ELContext::SCOPE_REQUEST)->get($ctx, $key);
        if ($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_VIEW)->get($ctx, $key);
        if ($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_SESSION)->get($ctx, $key);
        if ($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_APPLICATION)->get($ctx, $key);
        if ($val != null)
            return $val;
        return null;
    }

    public function getValue($expr) {
        $parts = \blaze\lang\String::asWrapper($expr)->split('.', null, true);
        $partsCount = count($parts);

        if ($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->getValueFromContext($parts[0]);

        if ($obj == null)
            throw new ELException($parts[0] . ' is not a valid expression object');

        for ($i = 1; $i < $partsCount; $i++) {
            if ($obj == null)
                throw new NullPointerException($parts[$i - 1] . ' is null');
            $method = $obj->getClass()->getMethod('get' . $parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        return $obj;
    }

    public function setValue($expr, $value) {
        $parts = \blaze\lang\String::asWrapper($expr)->split('.', null, true);
        $partsCount = count($parts);

        if ($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->getValueFromContext($parts[0]);

        if ($obj == null)
            throw new ELException($parts[0] . ' is not a valid expression object');

        for ($i = 1; $i < $partsCount - 1; $i++) {
            $method = $obj->getClass()->getMethod('get' . $parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod('set' . $parts[$partsCount - 1]->toUpperCase(true));
        $method->invoke($obj, $value);
    }

    /**
     *
     * @param Expression $expr
     * @param array $values 
     */
    public function invoke($expr, $values) {
        $parts = \blaze\lang\String::asWrapper($expr)->split('.', null, true);
        $partsCount = count($parts);

        if ($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->getValueFromContext($parts[0]);

        if ($obj == null)
            throw new ELException($parts[0] . ' is not a valid expression object');

        for ($i = 1; $i < $partsCount - 1; $i++) {
            $method = $obj->getClass()->getMethod('get' . $parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod($parts[$partsCount - 1]->toUpperCase(true));
        return $method->invokeArgs($obj, $values);
    }

}

?>
