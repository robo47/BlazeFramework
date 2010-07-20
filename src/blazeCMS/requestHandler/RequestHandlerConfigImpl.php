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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class RequestHandlerConfigImpl extends Object implements RequestHandlerConfig {

    private $params;
    /**
     * Beschreibung
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
