<?php
namespace blazeCMS\requestHandler;
use blaze\lang\Object,
    blaze\lang\String;

/**
 * Description of RequestHandlerConfigImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class RequestHandlerConfigImpl extends Object implements RequestHandlerConfig {

    private $params;
    /**
     * Description
     */
    public function __construct($params){
        $this->params = $params;
    }

    /**
     *
     * @param string|blaze\lang\String $name
     * @return blaze\lang\Object
     */
    public function getInitParameter($name) {
        return isset($this->params[String::asNative($name)]) ? $this->params[String::asNative($name)] : null;
    }

    public function getInitParameterNames() {
        return array_keys($this->params);
    }

}

?>
