<?php

namespace blaze\netlet;

/**
 * Description of Filter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Filter {

    public function init(FilterConfig $config);

    public function doFilter(NetletRequest $request, NetletResponse $response, FilterChain $chain);

    public function destroy();
}

?>
