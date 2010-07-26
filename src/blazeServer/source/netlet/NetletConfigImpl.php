<?php
namespace blazeServer\source\netlet;
use blaze\lang\Object;
use blaze\netlet\NetletConfig;

/**
 * Description of NetletConfigImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class NetletConfigImpl extends Object implements NetletConfig {

    private $netletName;
    private $netletContext;
    private $initParameters;

    public function __construct($netletName, $netletContext, $initParameters) {
        $this->netletName = $netletName;
        $this->netletContext = $netletContext;
        $this->initParameters = $initParameters;
    }

    public function getInitParameter($name) {
        if(!array_key_exists($name, $this->initParameters))
                return null;
        return $this->initParameters[$name];
    }

    public function getInitParameterMap() {
        return new \blaze\util\HashMap($this->initParameters);
    }

    public function getNetletContext() {
        return $this->netletContext;
    }

    public function getNetletName() {
        return $this->netletName;
    }

}

?>
