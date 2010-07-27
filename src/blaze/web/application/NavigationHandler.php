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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class NavigationHandler extends Object {

    /**
     *
     * @var array
     */
    private $mapping;
    /**
     * @var string
     */
    private $requestUri;
    /**
     *
     * @var blaze\lang\String
     */
    private $action = null;

    /**
     * Beschreibung
     */
    public function __construct($mapping, $requestUri) {
        $this->mapping = $mapping;
        $this->requestUri = $requestUri;
    }

    public function navigate($action) {
        $this->action = String::asWrapper($action);
    }

    public function getViewClass() {
        $app = ApplicationContext::getCurrentInstance()->getApplication();
        // remove the prefix of the url e.g. BlazeFrameworkServer/
        if(!$this->requestUri->endsWith('/'))
                $this->requestUri = $this->requestUri->concat('/');

        $reqUrl = $this->requestUri->substring($app->getUrlPrefix()->replace('*', '')->length());
        
        // Requesturl has always to start with a '/'
        if ($reqUrl->length() == 0 || $reqUrl->charAt(0) != '/')
            $reqUrl = new String('/' . $reqUrl->toNative());
        
        foreach ($this->mapping as $key => $value) {
            if ($reqUrl->startsWith($key)) {
                if ($this->action == null) {
                    // Returns an instance of the requested view
                    return ClassWrapper::forName($value['view']);
                } else {
                    // Look for the action in the navigationMap
                    foreach ($value['action'] as $action) {
                        if ($this->action->compareTo($action['action']) == 0)
                            return ClassWrapper::forName($action['view']);
                    }
                    return ClassWrapper::forName($value['view']);
                }
            }
        }
        return null;
    }

}
?>
