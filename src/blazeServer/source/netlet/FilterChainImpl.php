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


 * @since   1.0

 */
class FilterChainImpl extends Object implements FilterChain {

    /**
     * @var \blaze\collections\ListI[blaze\netlet\Filter]
     */
    private $filters;
    /**
     * @var \blaze\netlet\NetletContext
     */
    private $context;
    /**
     * @var int
     */
    private $index = 0;
    /**
     * @var int
     */
    private $count = 0;

    /**
     * Creates a new Filter chain.
     *
     * @param \blaze\collections\ListI[blaze\netlet\Filter] $filters
     */
    public function __construct(\blaze\netlet\NetletContext $context, \blaze\collections\ListI $filters = null){
        $this->context = $context;

        if($filters == null){
            $this->filters = null;
        }else{
            $this->filters = $filters;
            $this->count = $this->filters->count();
        }
    }

    public function doFilter(NetletRequest $request, NetletResponse $response) {
        if($response->isCommited())
            return;
        if($this->index == $this->count){
            $this->processNetlet($request, $response);
            return;
        }

        $this->filters->get($this->index++)->doFilter($request, $response, $this);
    }

    private function processNetlet(NetletRequest $request, NetletResponse $response){
        $netlet = $this->getRequestedNetlet($request, $this->context);

        if ($netlet == null) {
            $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the request found.');
            return;
        }
        $netlet->service($request, $response);
    }

    private function getRequestedNetlet(\blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\NetletContext $context) {
        // Making sure that the Url ends with a '/'
        $uri = $request->getRequestURI()->getPath();
        if (!$uri->endsWith('/'))
            $uri = $uri->concat('/');

        foreach ($context->getNetletMapping() as $key => $name) {
            // Make a regex placeholders of the wildcards
            $regex = '/' . strtolower(str_replace(array('/', '*'), array('\/', '.*'), $key)) . '/';

            // Check if the requested url fits a netlet mapping
            if ($uri->matches($regex)) {
                $netlets = $context->getNetlets();
                return $netlets->get($name);
            }
        }

        return null;
    }

}

?>
