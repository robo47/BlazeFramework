<?php

namespace blazeCMS\filter;

use blaze\lang\Object,
 blazeCMS\WebContext,
 blazeCMS\NavigationHandler,
 blaze\io\File,
 blaze\lang\String,
 blaze\netlet\Filter,
 blaze\netlet\NetletRequest,
 blaze\netlet\NetletResponse,
 blaze\netlet\FilterChain,
 blaze\netlet\FilterConfig,
 blaze\netlet\http\HttpSessionHandler;

/**
 * Description of AdminFilter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class AdminFilter extends Object implements Filter {

    public function destroy() {

    }

    public function doFilter(NetletRequest $request, NetletResponse $response, FilterChain $chain) {
        $path = $request->getRequestURI()->getPath();
        $context = WebContext::getInstance();

        if (!$path->startsWith($context->getParameter('url.prefix')->concat('/admin'))) {
            $chain->doFilter($request, $response);
        } else {
            //Admin area, check for authentification
            $session = $request->getSession();
            $user = $session->getAttribute('user');

            if ($user == null) {
                $cookies = $request->getCookies();
                $authCookie = null;

                foreach ($cookies as $cookie)
                    if ($cookie->getName()->compareTo('blazeAuth') == 0)
                        $authCookie = $cookie;

                if ($authCookie == null) {
                    //redirect to login
                    $context->setAttribute('site',new String('login'));
                    $context->getAttribute('navigationhandler')->navigate('/BlazeFrameworkServer/login');
                    return;
                } else {
                    $chain->doFilter($request, $response);
                }
            } else {
                $chain->doFilter($request, $response);
            }
        }
    }

    public function init(FilterConfig $config) {
        
    }

}
?>
