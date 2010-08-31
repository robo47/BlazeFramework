<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\ClassWrapper;

/**
 * Description of NavigationHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NavigationHandler extends Object {

    /**
     *
     * @var array
     */
    private $mapping;
    private $bindings;

    public function __construct($mapping) {
        $this->mapping = $mapping;
        $this->bindings = array();

        // Bindings
        foreach ($mapping as $pattern => $arr) {
            if (isset($arr['binding'])) {
                foreach ($arr['binding'] as $binding) {
                    $this->bindings[$pattern][] = array('name' => $binding['name'],
                                                        'reference' => new \blaze\web\el\Expression('{' . $binding['reference'] . '}'),
                                                        'default' => array_key_exists('default', $binding) ? $binding['default'] : null);
                }
            }
        }
    }

    public function navigate(BlazeContext $context, $action) {
        $actionString = String::asWrapper($action);
        $requestUri = $context->getRequest()->getRequestUri()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new String('/' . $requestUri->toNative());

        foreach ($this->mapping as $key => $value) {
            $regex = '/^' . str_replace(array('/', '*'), array('\/', '.*'), $key) . '$/';
            if ($requestUri->matches($regex)) {
                if ($actionString != null) {
                    // Look for the action in the navigationMap
                    foreach ($value['action'] as $action) {
                        if ($actionString->compareTo($action['action']) == 0) {
//                            \blaze\util\Logger::get()->log('Navigated from '.$context->getViewRoot()->getViewId().' to '. $context->getViewHandler()->getView($context, $action['view'])->getViewId());
                            $context->setViewRoot($context->getViewHandler()->getView($context, $action['view']));
                            $context->setNavigated();
                            return;
                        }
                    }
                }
            }
        }
    }

    public function pushBindings(BlazeContext $context, \blaze\netlet\http\HttpNetletRequest $request) {
        $requestUri = $context->getRequest()->getRequestUri()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new String('/' . $requestUri->toNative());

        foreach ($this->bindings as $pattern => $binds) {
            $regex = '/^' . str_replace(array('/', '*'), array('\/', '.*'), $pattern) . '$/';
            if ($requestUri->matches($regex)) {
                $bindingParts = $requestUri->substring(strlen($pattern)-1)->split('/');
                $count = count($bindingParts);
                $newValue = null;

                // Look for the bindings
                for($i = 0; $i < count($binds); $i++) {
                    if($i < $count && $bindingParts[$i] != '')
                        $newValue = $bindingParts[$i];
                    else
                        $newValue = $binds[$i]['default'];

                    if($newValue != null){
                        $binds[$i]['reference']->setValue($context, $newValue);
                        $newValue = null;
                    }
                }
            }
        }
    }

}

?>
