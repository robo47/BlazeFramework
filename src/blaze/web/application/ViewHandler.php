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
    private $viewDir;
    private $mapping;

    public function __construct(\blaze\io\File $viewDir, $mapping) {
        $this->mapping = $mapping;
        $this->viewDir = $viewDir;

        $this->recursiveDirIteration($viewDir);
    }

    private function recursiveDirIteration(\blaze\io\File $dir) {
        foreach ($dir->listFiles() as $file) {
            if (!$file->getName()->startsWith('.') && !$file->getName()->startsWith('..') && $file->isDirectory())
                $this->recursiveDirIteration($file);
            else if ($file->getName()->endsWith('.xhtml'))
                $this->parseAndCreateView($file);
        }
    }

    private function parseAndCreateView(\blaze\io\File $file) {
        $path = $file->getAbsolutePath();
        $viewId = $path->substring($this->viewDir->getAbsolutePath()->length())->replace(\blaze\io\File::$directorySeparator,'/')->trim('/');

        $root = new \blaze\web\component\UIViewRoot();
        $root->setViewId($viewId->toNative());

        $dom = new \DOMDocument();
        $dom->load($file->getAbsolutePath()->toNative());

        $this->handleChildren($root, $dom->documentElement->childNodes);
        $this->views[$root->getViewId()] = $root;
    }

    private function handleChildren($parent, $children) {
        foreach ($children as $node) {
            if ($node->nodeType == XML_ELEMENT_NODE) {
                if ($node->prefix == 'b') {
                    $class = ClassWrapper::forName('blaze\\web\\component\\html\\' . ucfirst($node->localName));
                    $component = $class->newInstance();

                    if ($node->hasAttributes())
                        foreach ($node->attributes as $attribute)
                            if ($attribute->nodeType == XML_ATTRIBUTE_NODE)
                                $class->getMethod('set' . ucfirst($attribute->nodeName))->invoke($component, $attribute->nodeValue);

                    $parent->addChild($component);
                    if ($node->hasChildNodes())
                        $this->handleChildren($component, $node->childNodes);
                }else {
                    $tag = '<'.$node->nodeName;
                    
                    if ($node->hasAttributes())
                        foreach ($node->attributes as $attribute)
                            if ($attribute->nodeType == XML_ATTRIBUTE_NODE)
                                $tag .= ' '.$attribute->nodeName.'="'.$attribute->nodeValue.'"';

                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue($tag .'>'));

                    if ($node->hasChildNodes()) 
                        $this->handleChildren($parent, $node->childNodes);
                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue('</' . $node->nodeName . '>'));
                }
            } else if ($node->nodeType == XML_TEXT_NODE) {
                $content = trim($node->textContent);
                if (strlen($content) != 0)
                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue($content));
            }
        }
    }

    public function restoreOrCreateView(BlazeContext $context) {
        $session = $context->getRequest()->getSession();
        $lastView = null;

        if ($session != null) {
            $lastView = $session->getAttribute('blaze.view_restore');

            if ($lastView == null)
                $lastView = $this->getRequestView($context);
            if ($lastView == null)
                throw new \blaze\lang\Exception('No view found.');
        }else {
            $lastView = $this->getRequestView($context);
            if ($lastView == null)
                throw new \blaze\lang\Exception('No view found.');
        }
        $context->setViewRoot($lastView);
    }

    public function getRequestView(BlazeContext $context) {
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
                return $this->getView($context, $value['view']);
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
        return $this->views[$viewId];
    }

}

?>
