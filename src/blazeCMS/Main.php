<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String,
    blazeCMS\component\Compressor,
    blazeCMS\component\Cache,
    blaze\web\BlazeContext,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of Main
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Main extends Object {

    const DEBUG = true;
    private $compressor;
    private $cache;
    /**
     * Description
     */
    public function __construct() {
        $this->compressor = new Compressor();
        $this->cache = new Cache();
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
    public static function main($args) {
        $main = new Main();
        $request = BlazeContext::getInstance()->getRequest();
        $response = BlazeContext::getInstance()->getResponse();
        $response->setHeader('X-Powered-By',null);

        ob_start();
        $main->handle($request, $response);

        if(self::DEBUG)
            $response->getWriter()->write(ob_get_clean());
        else
            ob_end_clean();

        $main->finish($request, $response);
    }

    public function handle(HttpNetletRequest $request, HttpNetletResponse $response) {
        $handler = null;
        $context = WebContext::getInstance();
        $navHandler = new NavigationHandler(array('mapping' => array('/admin/*' => '/admin', '/*' => '/general')));
        $context->setAttribute('navigationhandler', $navHandler);
        $this->doFilter($request, $response);
        
        switch($context->getParameter('site.action')->toLowerCase()) {
            case 'file':
                $handler = new requestHandler\FileRequestHandler();
                break;
            case 'login':
                $handler = new requestHandler\LoginRequestHandler();
                break;
            default:
                $handler = new requestHandler\ViewRequestHandler();
        }

        if($navHandler->getBasePath() == null)
            $navHandler->navigate($request->getRequestURI()->getPath());

        try {
            $handler->init(new requestHandler\RequestHandlerConfigImpl(array('mapper' => $navHandler)));
            $handler->handle($request, $response);
        }catch(\blaze\lang\Exception $e) {
            $response->sendError(HttpNetletResponse::SC_NOT_FOUND);
            throw $e;
        }
    }

    private function doFilter(HttpNetletRequest $request, HttpNetletResponse $response){
        $filters = array();
        $filterConf = new filter\FilterConfigImpl();
        $filter = new filter\UrlRewriteFilter();
        $filter->init($filterConf);
        $filters[] = $filter;
        $filter = new filter\HttpsFilter();
        $filter->init($filterConf);
        $filters[] = $filter;
        $filter = new filter\AdminFilter();
        $filter->init($filterConf);
        $filters[] = $filter;
        $chain = new filter\FilterChainImpl($filters);
        $chain->doFilter($request, $response);
    }

    public function finish(HttpNetletRequest $request, HttpNetletResponse $response) {
        $this->compressor->start();
        $response->getWriter()->close();
        $this->compressor->end();
    }
}

?>
