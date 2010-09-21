<?php

namespace blaze\web\filter;

use blaze\lang\Object;

/**
 * Description of BlazeEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class HttpsFilter extends Object implements \blaze\netlet\Filter {

    public function destroy() {

    }

    public function doFilter(\blaze\netlet\NetletRequest $request, \blaze\netlet\NetletResponse $response, \blaze\netlet\FilterChain $chain) {
        if(!$request->isSecure())
            $response->sendRedirect($request->getRequestPath()->replace('http', 'https'));
        else
            $chain->doFilter($request, $response);
    }

    public function init(\blaze\netlet\FilterConfig $config) {

    }

}

?>
