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
 * Description of FilterChainImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class FilterChainImpl extends Object implements FilterChain {

    /**
     *
     * @var array[blaze\netlet\Filter]
     */
    private $filters;
    /**
     *
     * @var int
     */
    private $index = 0;
    /**
     *
     * @var int
     */
    private $count = 0;

    /**
     *
     * @param array[blaze\netlet\Filter] $filters 
     */
    public function __construct(\blaze\collections\ListI $filters = null){
        if($filters == null){
            $this->filters = null;
        }else{
            $this->filters = $filters;
            $this->count = $this->filters->count();
        }
    }

    public function doFilter(NetletRequest $request, NetletResponse $response) {
        if($this->index == $this->count || $response->isCommited())
                return;
        $this->filters->get($this->index++)->doFilter($request, $response, $this);
    }

}

?>
