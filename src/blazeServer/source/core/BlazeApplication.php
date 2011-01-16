<?php

namespace blazeServer\source\core;

use blaze\lang\Object,
 blaze\lang\System,
 blaze\lang\StaticInitialization,
 blaze\io\File,
 blaze\lang\String,
 blaze\lang\ClassWrapper,
 blaze\lang\ClassLoader,
 blaze\web\application\Application,
 blaze\web\application\BlazeContext;

/**
 * Description of BlazeApplication
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\lang\ClassWrapper
 * @since   1.0

 * @author Christian Beikov
 */
class BlazeApplication extends Object implements Application {

    private $netletApplication;
    private $lifeCycle;
    private $elContext;
    private $viewHandler;
    private $sessionHandler;
    private $navigationHandler;
    private $defaultLocale;
    private $navigationRules;
    private $decorators;
    private $converter;
    private $validator;
    private $renderKitFactories;
    private $applicationPath;

    /**
     *
     * @param blaze\io\File $dir
     * @param boolean $running
     */
    public function __construct(\blazeServer\source\netlet\NetletApplication $netletApplication, \blaze\web\lifecycle\Lifecycle $lifeCycle) {
        $this->netletApplication = $netletApplication;
        $this->lifeCycle = $lifeCycle;
        $this->applicationPath = new File($netletApplication->getApplicationPath(), 'view');

        $this->navigationRules = new \blaze\collections\lists\ArrayList();
        $this->converter = new \blaze\collections\map\HashMap();
        $this->validator = new \blaze\collections\map\HashMap();
        $this->renderKitFactories = new \blaze\collections\map\HashMap();
        $this->decorators = new \blaze\collections\map\HashMap();
        $this->elContext = new \blaze\web\el\ELContext();

        $requestScope = new \blaze\collections\map\HashMap();
        $viewScope = new \blaze\collections\map\HashMap();
        $sessionScope = new \blaze\collections\map\HashMap();
        $applicationScope = new \blaze\collections\map\HashMap();
        $this->setELScopes($requestScope, $viewScope, $sessionScope, $applicationScope);

        $this->init();
    }

    private function init() {
        $doc = $this->getConfig();

        foreach ($doc->documentElement->childNodes as $node) {
            if ($node->nodeType == XML_ELEMENT_NODE && $node->localName == 'blazeApplication') {
                foreach ($node->childNodes as $child) {
                    switch ($child->localName) {
                        case 'taglibs':
                            self::handleTaglibs($child);
                            break;
                        case 'nuts':
                            self::handleNuts($child);
                            break;
                        case 'phaseListeners':
                            self::handlePhaseListeners($child);
                            break;
                        case 'tagDecorators':
                            self::handleTagDecorators($child);
                            break;
                        case 'sessionHandler':
                            $this->sessionHandler = ClassWrapper::forName($child->getAttribute('class'));
                            break;
                        case 'navigation':
                            self::handleNavigation($child);
                            break;
                    }
                }
            }
        }

        $this->navigationHandler = new \blaze\web\application\NavigationHandler($this->navigationRules);
        $this->viewHandler = new \blaze\web\application\ViewHandler($this->applicationPath, $this->navigationRules);
    }

    private function getMappings($node) {
        $mappings = new \blaze\collections\lists\ArrayList();

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE && $child->localName == 'mapping') {
                $mappings->add($child->getAttribute('pattern'));
            }
        }

        return $mappings;
    }

    private function handleTaglibs($node) {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $componentFamily = $child->getAttribute('componentFamily');
                $renderKitFactory = $child->getAttribute('renderKitFactory');
                $renderKitFactoryInst = ClassWrapper::forName($renderKitFactory)->getMethod('getInstance')->invoke(null, null);

                $renderKits = $this->getRenderKits($child);
                foreach ($renderKits as $renderKitId => $renderKit) {
                    $renderKitFactoryInst->addRenderKit($componentFamily, $renderKitId, ClassWrapper::forName($renderKit)->newInstance());
                }

                $this->renderKitFactories->put($componentFamily, $renderKitFactoryInst);
            }
        }
    }

    private function getRenderKits($node) {
        $renderKits = new \blaze\collections\map\HashMap();

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $renderKits->put($child->getAttribute('id'), $child->getAttribute('class'));
            }
        }

        return $renderKits;
    }

    private function handleNuts($node) {
        $requestScope = new \blaze\collections\map\HashMap();
        $viewScope = new \blaze\collections\map\HashMap();
        $sessionScope = new \blaze\collections\map\HashMap();
        $applicationScope = new \blaze\collections\map\HashMap();

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $name = $child->getAttribute('name');
                $class = $child->getAttribute('class');
                $scope = $child->getAttribute('scope');

                switch ($scope) {
                    case 'request':
                        $requestScope->put($name, $class);
                    case 'view':
                        $viewScope->put($name, $class);
                    case 'session':
                        $sessionScope->put($name, $class);
                    case 'application':
                        $applicationScope->put($name, $class);
                }
            }
        }

        $this->setELScopes($requestScope, $viewScope, $sessionScope, $applicationScope);
    }

    private function setELScopes(\blaze\collections\Map $requestScope, \blaze\collections\Map $viewScope, \blaze\collections\Map $sessionScope, \blaze\collections\Map $applicationScope){
        $this->elContext->setContext(\blaze\web\el\ELContext::SCOPE_REQUEST, new \blaze\web\el\scope\ELRequestScopeContext($requestScope));
        $this->elContext->setContext(\blaze\web\el\ELContext::SCOPE_VIEW, new \blaze\web\el\scope\ELViewScopeContext($viewScope));
        $this->elContext->setContext(\blaze\web\el\ELContext::SCOPE_SESSION, new \blaze\web\el\scope\ELSessionScopeContext($sessionScope));
        $this->elContext->setContext(\blaze\web\el\ELContext::SCOPE_APPLICATION, new \blaze\web\el\scope\ELApplicationScopeContext($applicationScope));
    }

    private function handlePhaseListeners($node) {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $class = $child->getAttribute('class');
                $inst = ClassWrapper::forName($class)->newInstance();
                $mappings = $this->getMappings($child);

                if ($mappings->count() != 0) {
                    foreach ($mappings as $mapping) {
                        $this->lifeCycle->addPhaseListener($inst, $mapping);
                    }
                } else {
                    $this->lifeCycle->addPhaseListener($inst);
                }
            }
        }
    }

    private function handleTagDecorators($node) {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $name = $child->getAttribute('name');
                $class = $child->getAttribute('class');
                $this->decorators->put($name, ClassWrapper::forName($class)->newInstance());
            }
        }
    }

    private function handleNavigation($node) {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                $indexView = $child->getAttribute('indexView');
                $mappings = $this->getMappings($child);
                $bindings = $this->getBindings($child);
                $actions = $this->getActions($child);
                $this->navigationRules->add(new \blaze\web\application\NavigationRule($indexView, $mappings->get(0), $actions, $bindings));
            }
        }
    }

    private function getBindings($node) {
        $bindings = new \blaze\collections\lists\ArrayList();

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE && $child->localName == 'bindings') {
                foreach($child as $binding){
                    $name = $binding->getAttribute('name');
                    $reference = $binding->getAttribute('reference');
                    $default = $binding->getAttribute('default');

                    $bindings->add(new \blaze\web\application\Binding($name, $reference, $default));
                }
            }
        }

        return $bindings;
    }

    private function getActions($node) {
        $actions = new \blaze\collections\map\HashMap();

        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE && $child->localName == 'navigationAction') {
                $action = $child->getAttribute('action');
                $view = $child->getAttribute('view');

                $actions->put($action, $view);
            }
        }

        return $actions;
    }

    public function addConverter($name, $class) {
        $this->converter->put($name, $class);
    }

    public function addValidator($name, $class) {
        $this->validator->put($name, $class);
    }

    public function addNavigationRule(\blaze\web\application\NavigationRule $rule) {
        $this->navigationRules->add($rule);
    }

    public function getDecorator($decoratorName) {
        return $this->decorators->get($decoratorName);
    }

    public function getRenderKitFactory($componentFamily) {
        return $this->renderKitFactories->get($componentFamily);
    }

    public function getSessionHandler() {
        return $this->sessionHandler;
    }

    /**
     *
     * @return blaze\util\Locale
     */
    public function getDefaultLocale() {
        return $this->defaultLocale;
    }

    public function setDefaultLocale(\blaze\util\Locale $locale) {
        $this->defaultLocale = $locale;
    }

    /**
     *
     * @return blaze\web\el\ELContext
     */
    public function getELContext() {
        return $this->elContext;
    }

    /**
     *
     * @return \blaze\web\application\ViewHandler
     */
    public function getViewHandler() {
        return $this->viewHandler;
    }

    /**
     * @return blaze\web\application\NavigationHandler
     */
    public function getNavigationHandler() {
        return $this->navigationHandler;
    }

    public function setNavigationHandler(\blaze\web\application\NavigationHandler $handler) {
        $this->navigationHandler = $handler;
    }

    public function getApplicationPath() {
        return $this->applicationPath;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->netletApplication->getName();
    }

    /**
     *
     * @return \DOMDocument
     */
    public function getConfig() {
        return $this->netletApplication->getConfig();
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPackage() {
        return $this->netletApplication->getPackage();
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getUrlPrefix() {
        return $this->netletApplication->getUrlPrefix();
    }

}

?>
