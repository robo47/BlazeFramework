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


 * @since   1.0

 */
class FilterConfigImpl extends Object implements FilterConfig {
    private $initParams;
    private $filterName;
    private $netletContext;

    public function __construct($filterName, \blaze\netlet\NetletContext $netletContext, \blaze\collections\Map $initParams){
        $this->initParams = $initParams;
        $this->filterName = $filterName;
        $this->netletContext = $netletContext;
    }

    public function getFilterName() {
        return $this->filterName;
    }

    public function getInitParameter(\blaze\lang\String $name) {
        return $this->initParams->get($name);
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function getNetletContext() {
        return $this->netletContext;
    }


}

?>
