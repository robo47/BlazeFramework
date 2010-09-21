<?php

namespace blazeServer\source\netlet;

use blaze\lang\Object,
 blazeServer\source\netlet\http\HttpNetletRequestImpl,
 blazeServer\source\netlet\http\HttpNetletResponseImpl,
 blaze\lang\ClassWrapper;

/**
 * Description of NetletContainer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NetletContainer extends Object {
    const DEBUG = true;

    public function __construct() {

    }

    public static function main($args) {
//        // Caching performance test
//        $t = new \blaze\util\Timer();
//        $t->start();
        $container = new NetletContainer();
        $request = new HttpNetletRequestImpl();
        $response = new HttpNetletResponseImpl();
        $response->setHeader('X-Powered-By', 'BlazeServer');

        ob_start();

        $container->process($request, $response);
        if (self::DEBUG)
            $response->getWriter()->write(ob_get_clean());
        else
            ob_end_clean();
//        $response->getWriter()->write($t->stop());
        $container->finish($request, $response);
    }

    /**
     * This method wrapps the HTTP-Request and Response and executes the netlets
     * of a running web application or throws an error if the request does not
     * fit to any application.
     */
    public function process(\blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response) {

        try {
            $cacher = \blaze\cache\LocalCacher::getInstance();
            $cacheMgr = \blaze\cache\CacheManager::getInstance('blazeContainer', $cacher);

            $appName = NetletApplication::getApplicationName($request);
            $app = null;

            if ($appName == null) {
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no application for the request found.');
                return;
            }

            if ($cacheMgr->isCached($appName)) {
                $app = $cacheMgr->getCache($appName);
            } else {
                $app = NetletApplication::getApplicationByName($appName);
                //$cacheMgr->doCache($appName, $app);
            }

            if ($app == null) {
                $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no application for the request found.');
                return;
            }

            $context = $app->getNetletContext();

            $chain = new FilterChainImpl($this->getRequestedFilters($request, $context));
            $chain->doFilter($request, $response);

            if(!$response->isCommited()){
                $netlet = $this->getRequestedNetlet($request, $context);

                if ($netlet == null) {
                    $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND, 'There was no netlet for the request found.');
                    return;
                }
                $netlet->service($request, $response);

                $sess = $request->getSession();
                if ($sess != null) {
                    $cookie = null;
                    $sessHand = $request->getSessionHandler();

                    if (!$sess->isValid()) {
                        $cookie = new http\HttpCookieImpl('BLAZESESSION', '');
                        $cookie->setExpire(0);
                        $sessHand->removeSession();
                    } else {
                        $sessHand->saveSession();
                        $cookie = new http\HttpCookieImpl('BLAZESESSION', $sess->getId());
                        $cookie->setHttponly(true);
                        $cookie->setPath($app->getUrlPrefix());
                        //$cookie->setDomain($request->getServerName());
                    }

                    $response->addCookie($cookie);
                }
            }
        } catch (Exception $e) {
            // Error in the netlet which was not caught
            $response->sendError(\blaze\netlet\http\HttpNetletResponse::SC_NOT_FOUND);
        }
    }

    private function finish(\blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\http\HttpNetletResponse $response) {
        try {
            $responseWriter = $response->getWriter();

            if(!$responseWriter->isClosed())
                $responseWriter->close();
        } catch (Exception $e) {
            // Error of the NetletOutputStream
            var_dump('UNEXPECTED ERROR: ' . $e->getMessage());
        }
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

    private function getRequestedFilters(\blaze\netlet\http\HttpNetletRequest $request, \blaze\netlet\NetletContext $context) {
        $uri = $request->getRequestURI()->getPath();
        if (!$uri->endsWith('/'))
            $uri = $uri->concat('/');
        $filterArr = new \blaze\collections\lists\ArrayList();

        // Looking in the filter mapping for a filter that fits the url
        foreach ($context->getFilterMapping() as $key => $name) {
            // Make a regex placeholders of the wildcards
            $regex = '/' . strtolower(str_replace(array('/', '*'), array('\/', '.*'), $key)) . '/';

            // Check if the requested url fits a netlet mapping
            if ($uri->matches($regex)) {
                $filters = $context->getFilters();
                $filterArr->add($filters->get($name));
            }
        }

        return $filterArr;
    }

}

?>
