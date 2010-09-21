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
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NetletConfigImpl extends Object implements NetletConfig {

    private $netletName;
    private $netletContext;
    private $initParameters;

    public function __construct($netletName, \blaze\netlet\NetletContext $netletContext, \blaze\collections\Map $initParameters) {
        $this->netletName = $netletName;
        $this->netletContext = $netletContext;
        $this->initParameters = $initParameters;
    }

    public function getInitParameter($name) {
        return $this->initParameters->get($name);
    }

    public function getInitParameterMap() {
        return $this->initParameters;
    }

    public function getNetletContext() {
        return $this->netletContext;
    }

    public function getNetletName() {
        return $this->netletName;
    }

}

?>
