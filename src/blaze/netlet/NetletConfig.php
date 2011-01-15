<?php

namespace blaze\netlet;

/**
 * Description of NetletConfig
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface NetletConfig {

    public function getNetletName();

    public function getInitParameter(\blaze\lang\String $name);

    public function getInitParameterMap();

    /**
     * @return blaze\netlet\NetletContext
     */
    public function getNetletContext();
}

?>
