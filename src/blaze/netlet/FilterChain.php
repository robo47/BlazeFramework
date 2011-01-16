<?php

namespace blaze\netlet;

/**
 * Description of FilterChain
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface FilterChain {

    public function doFilter(NetletRequest $request, NetletResponse $response);
}

?>
