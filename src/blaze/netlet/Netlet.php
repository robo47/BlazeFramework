<?php

namespace blaze\netlet;

/**
 * Description of Netlet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Netlet {

    public function init(NetletConfig $config);

    public function destroy();

    public function service(NetletRequest $request, NetletResponse $response);
}

?>
