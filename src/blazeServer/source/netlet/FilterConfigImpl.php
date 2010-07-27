<?php
namespace blazeServer\source\netlet;
use blaze\lang\Object,
    blaze\io\File,
    blaze\netlet\Filter,
    blaze\netlet\NetletRequest,
    blaze\netlet\NetletResponse,
    blaze\netlet\FilterChain,
    blaze\netlet\FilterConfig;

/**
 * Description of FilterConfigImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class FilterConfigImpl extends Object implements FilterConfig {
    private $initParams;
    private $filterName;
    private $netletContext;

    public function __construct($filterName, \blaze\netlet\NetletContext $netletContext, $initParams){
        $this->initParams = $initParams;
        $this->filterName = $filterName;
        $this->netletContext = $netletContext;
    }

    public function getFilterName() {
        return $this->filterName;
    }

    public function getInitParameter($name) {
        if(!array_key_exists($name, $this->initParams))
             return null;
        return $this->initParams[$name];
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function getNetletContext() {
        return $this->netletContext;
    }


}

?>
