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
class ViewHandler extends Object {

    /**
     *
     * @var array[blaze\web\component\UIViewRoot]
     */
    private $views = array();
    private $viewIds;
    private $mapping;
    
    public function __construct($viewIds, $mapping) {
        $this->mapping = $mapping;
        $this->viewIds = $viewIds;

        foreach($viewIds as $viewId => $viewClass){
            $this->views[$viewId] = ClassWrapper::forName($viewClass)->newInstance()->getViewRoot();
        }
    }

    public function restoreOrCreateView(BlazeContext $context){
        $session = $context->getRequest()->getSession();
        $lastView = null;

        if($session != null){
            $lastViewId = $session->getAttribute('blaze.view_restore');

            if($lastViewId != null)
                $lastView = $this->getView($context, $lastViewId);
            if($lastView == null)
                $lastView = $this->getRequestView($context);
            if($lastView == null)
                throw new \blaze\lang\Exception('No view found.');
        }else{
            $lastView = $this->getRequestView($context);
            if($lastView == null)
                throw new \blaze\lang\Exception('No view found.');
        }
        
        $context->setViewRoot($lastView);
    }

    public function getRequestView(BlazeContext $ctx){
        $requestUri = $ctx->getRequest()->getRequestUri()->getPath();

        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if (!$requestUri->endsWith('/'))
            $requestUri = $requestUri->concat('/');

        $requestUri = $requestUri->substring($ctx->getApplication()->getUrlPrefix()->replace('*', '')->length());

        // Requesturl has always to start with a '/'
        if ($requestUri->length() == 0 || $requestUri->charAt(0) != '/')
            $requestUri = new String('/' . $requestUri->toNative());

        foreach ($this->mapping as $key => $value) {
            if ($requestUri->startsWith($key)) {
                return $this->getView($ctx, $value['view']);
            }
        }
        
        return null;
    }

    /**
     *
     * @param BlazeContext $context
     * @param string|blaze\lang\String $viewId
     * @return blaze\web\component\UIViewRoot
     */
    public function getView(BlazeContext $context, $viewId) {
        if(!array_key_exists($viewId, $this->views))
                $this->views[$viewId] = $this->createView($context, $viewId);
        return $this->views[$viewId];
    }
/**
 *
 * @param BlazeContext $context
 * @param string|blaze\lang\String $viewId
 * @return blaze\web\component\UIViewRoot
     */
    public function createView(BlazeContext $context, $viewId) {
        return ClassWrapper::forName($this->viewIds[$viewId])->newInstance()->getViewRoot();
    }

}
?>
