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

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
    public function getFilterName();

    public function getInitParameter($name);

    public function getInitParameterMap();

    public function getNetletContext();
}

?>
