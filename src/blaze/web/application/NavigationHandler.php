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


    public function __construct($mapping) {
        $this->mapping = $mapping;
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
            $regex = '/^'.str_replace(array('/','*'), array('\/','.*'), $key).'$/';
            if ($requestUri->matches($regex)) {
                if ($actionString != null) {
                    // Look for the action in the navigationMap
                    foreach ($value['action'] as $action) {
                        if ($actionString->compareTo($action['action']) == 0) {
                            $context->setViewRoot($context->getViewHandler()->getView($context, $action['view']));
                            $context->setNavigated();
                            return;
                        }
                    }
                }
            }
        }
    }

}
?>
