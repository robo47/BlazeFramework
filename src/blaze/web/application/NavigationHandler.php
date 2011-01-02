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


 * @since   1.0


 */
class NavigationHandler extends Object {

    /**
     *
     * @var \blaze\collections\ListI
     */
    private $mapping;

    public function __construct($mapping) {
        $this->mapping = $mapping;
    }

    public function navigate(BlazeContext $context, $action) {
        $actionString = String::asWrapper($action);
        $requestUri = $context->getRequest()->getRequestURI()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new String('/' . $requestUri->toNative());

        foreach ($this->mapping as $navigationRule) {
            $regex = '/^' . str_replace(array('/', '*'), array('\/', '.*'), $navigationRule->getMapping()) . '$/';
            if ($requestUri->matches($regex)) {
                if ($actionString != null) {
                    // Look for the action in the navigationMap
                    foreach ($navigationRule->getActions() as $action => $view) {
                        if (String::compare($actionString, $action) == 0) {
//                            \blaze\util\Logger::get()->log('Navigated from '.$context->getViewRoot()->getViewId().' to '. $context->getViewHandler()->getView($context, $action['view'])->getViewId());
                            $context->setViewRoot($context->getViewHandler()->getView($context, $view));
                            $context->setNavigated();
                            return;
                        }
                    }
                }
            }
        }

        $view = $context->getViewHandler()->getView($context, $actionString);
        
        if($view != null){
            $context->setViewRoot($view);
            $context->setNavigated();
        }
    }

    public function pushBindings(BlazeContext $context) {
        $requestUri = $context->getRequest()->getRequestURI()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($context->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new String('/' . $requestUri->toNative());

        foreach ($this->mapping as $navigationRule) {
            $regex = '/^' . str_replace(array('/', '*'), array('\/', '.*'), $navigationRule->getMapping()) . '$/';
            if ($requestUri->matches($regex)) {
                $bindingParts = $requestUri->substring(strlen($navigationRule->getMapping())-1)->split('/');
                $count = count($bindingParts);
                $newValue = null;

                // Look for the bindings
                $binds = $navigationRule->getBindings();
                for($i = 0; $i < $binds->count(); $i++) {
                    if($i < $count && $bindingParts[$i] != '')
                        $newValue = $bindingParts[$i];
                    else
                        $newValue = $binds->get($i)->getDefault();

                    if($newValue !== null){
                        $binds->get($i)->getReference()->setValue($context, $newValue);
                        $newValue = null;
                    }
                }
            }
        }
    }

}

?>
