<?php
namespace blazeServer\source\filter;
use blaze\lang\Object,
    blaze\io\File,
    blaze\netlet\Filter,
    blaze\netlet\NetletRequest,
    blaze\netlet\NetletResponse,
    blaze\netlet\FilterChain,
    blaze\netlet\FilterConfig;

/**
 * Description of FilterChainImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class FilterChainImpl extends Object implements FilterChain {

    /**
     *
     * @var array[blaze\netlet\Filter]
     */
    private $filters;
    /**
     *
     * @var integer
     */
    private $index = 0;
    /**
     *
     * @var integer
     */
    private $count = 0;

    /**
     *
     * @param array[blaze\netlet\Filter] $filters 
     */
    public function __construct($filters = null){
        if($filters == null)
            $this->filters = array();
        else
            $this->filters = $filters;
        $this->count = count($this->filters);
    }

    public function doFilter(NetletRequest $request, NetletResponse $response) {
        if($this->index == $this->count)
                return;
        $this->filters[$this->index++]->doFilter($request, $response, $this);
    }

}

?>
