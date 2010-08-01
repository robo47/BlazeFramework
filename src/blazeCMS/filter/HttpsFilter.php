<?php
namespace blazeCMS\filter;
use blaze\lang\Object,
    blazeCMS\WebContext,
    blazeCMS\NavigationHandler,
    blaze\io\File,
    blaze\netlet\Filter,
    blaze\netlet\NetletRequest,
    blaze\netlet\NetletResponse,
    blaze\netlet\FilterChain,
    blaze\netlet\FilterConfig;

/**
 * Description of HttpsFilter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class HttpsFilter extends Object implements Filter {

    public function __construct(){}

    public function destroy() { }

    public function doFilter(NetletRequest $request, NetletResponse $response, FilterChain $chain) {
        $isAdmin = false;//$context->getParameter('site')->equalsIgnoreCase('admin');

        if($isAdmin && !$request->isSecure()) {
            $response->sendRedirect('https://'.$request->getHost().$request->getRequestURI());
            return;
        }else{
            $chain->doFilter($request, $response);
        }
    }

    public function init(FilterConfig $config) { }
}

?>
