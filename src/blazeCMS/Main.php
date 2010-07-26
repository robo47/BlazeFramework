<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String,
    blazeCMS\component\Compressor,
    blazeCMS\component\Cache,
    blaze\web\ApplicationContext,
    blaze\netlet\http\HttpNetletRequest,
    blaze\netlet\http\HttpNetletResponse;

/**
 * Description of Main
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Main extends Object {

    const DEBUG = true;
    private $compressor;
    private $cache;
    /**
     * Beschreibung
     */
    public function __construct() {
        $this->compressor = new Compressor();
        $this->cache = new Cache();
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
    public static function main($args) {
        $main = new Main();
        $request = ApplicationContext::getInstance()->getRequest();
        $response = ApplicationContext::getInstance()->getResponse();
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
