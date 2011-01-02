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
class ViewHandler extends Object {

    /**
     *
     * @var array[blaze\web\component\UIViewRoot]
     */
    private $views;
    private $viewDir;
    private $mapping;

    public function __construct(\blaze\io\File $viewDir, $mapping) {
        $this->mapping = $mapping;
        $this->viewDir = $viewDir;
        $this->views = new \blaze\collections\map\HashMap();

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

    private function parseAndCreateView(\blaze\io\File $file, $compositionChildren = null) {
        $path = $file->getAbsolutePath();

        $dom = new \DOMDocument();
        $dom->load($file->getAbsolutePath()->toNative());

        $viewId = $path->substring($this->viewDir->getAbsolutePath()->length())->replace(\blaze\io\File::$directorySeparator,'/')->trim('/');
        $root = new \blaze\web\component\UIViewRoot();
        if($compositionChildren == null){
            $root->setViewId($viewId->toNative());
            $this->views->put($root->getViewId(), $root);
        }

        $this->handleChildren($root, $dom->documentElement->childNodes, $compositionChildren);
        if($compositionChildren != null)
            return $root;
    }

    private function handleChildren(\blaze\web\component\UIComponent $parent, $children, $compositionChildren) {
        $prefixComponents = array('b' => 'blaze\\web\\component\\html\\', 'e' => 'blaze\\web\\component\\event\\');
        foreach ($children as $node) {
            if ($node->nodeType == XML_ELEMENT_NODE) {
                if ($node->prefix == 'b' || $node->prefix == 'e') {
                    $class = ClassWrapper::forName($prefixComponents[$node->prefix] . ucfirst($node->localName));
                    $component = $class->newInstance();

                    if ($node->hasAttributes())
                        foreach ($node->attributes as $attribute)
                            if ($attribute->nodeType == XML_ATTRIBUTE_NODE)
                                $class->getMethod('set' . ucfirst($attribute->nodeName))->invoke($component, $attribute->nodeValue);

                    $parent->addChild($component);
                    if ($node->hasChildNodes())
                        $this->handleChildren($component, $node->childNodes, $compositionChildren);
                }else if($node->prefix == 'ui'){
                    if($node->localName == 'insert'){
                        if($compositionChildren != null){
                            $foundElem = $this->findCompositionDefinition($compositionChildren, $node->getAttribute('name'));
                            if($foundElem == null)
                                $this->handleChildren($parent, $node->childNodes, $compositionChildren);
                            else
                                $this->handleChildren($parent, $foundElem->childNodes, $compositionChildren);
                        }else
                            $this->handleChildren($parent, $node->childNodes, $compositionChildren);
                    }else if($node->localName == 'composite'){
                        $template = $node->getAttribute('template');

                        if($template == '')
                            throw new Exception('No template view given');
                        $f = new \blaze\io\File($this->viewDir, $template);

                        if(!$f->exists())
                                throw new \blaze\io\IOException('Template was not found');
                        $root = $this->getRoot($parent);
                        $newRoot = $this->parseAndCreateView($f, $node->childNodes);
                        $newRoot->setViewId($root->getViewId());
                        $this->views->put($newRoot->getViewId(), $newRoot);
                    }
                }else {
                    $tag = '<'.$node->nodeName;
                    
                    if ($node->hasAttributes())
                        foreach ($node->attributes as $attribute)
                            if ($attribute->nodeType == XML_ATTRIBUTE_NODE)
                                $tag .= ' '.$attribute->nodeName.'="'.$attribute->nodeValue.'"';

                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue($tag .'>'));

                    if ($node->hasChildNodes()) 
                        $this->handleChildren($parent, $node->childNodes, $compositionChildren);
                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue('</' . $node->nodeName . '>'));
                }
            } else if ($node->nodeType == XML_TEXT_NODE) {
                $content = trim($node->textContent);
                if (strlen($content) != 0)
                    $parent->addChild(\blaze\web\component\html\PlainText::create()->setValue($content));
            }
        }
    }
    
    private function findCompositionDefinition($children, $name){
        foreach ($children as $node) {
            if ($node->nodeType == XML_ELEMENT_NODE) {
                if ($node->prefix == 'ui' && $node->localName == 'define' && $node->getAttribute('name') == $name) {
                    return $node;
                }else if($node->hasChildNodes()){
                    $elem = $this->findCompositionDefinition($node->childNodes, $name);
                    if($elem != null)
                        return $elem;
                }
            }
        }
        return null;
    }

    private function getRoot(\blaze\web\component\UIComponent $component){
        $parent = $component->getParent();
        if($parent == null)
            return $component;
        else
            return $this->getRoot($parent);
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

        foreach ($this->mapping as $navigationRule) {
            $regex = '/^' . str_replace(array('/', '*'), array('\/', '.*'), $navigationRule->getMapping()) . '$/';
            if ($requestUri->matches($regex)) {
                return $this->getView($context, $navigationRule->getIndexView());
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
        return $this->views->get($viewId);
    }

}

?>
