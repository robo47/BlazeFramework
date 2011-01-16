<?php

namespace blaze\netlet;

/**
 * Description of FilterConfig
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface FilterConfig {

    public function getFilterName();

    public function getInitParameter(\blaze\lang\String $name);

    public function getInitParameterMap();

    public function getNetletContext();
}

?>
