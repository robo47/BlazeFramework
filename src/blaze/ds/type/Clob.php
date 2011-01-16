<?php

namespace blaze\ds\type;

/**
 * The data type for the SQL specific type NCLOB.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Clob {

    /**
     *
     * @return blaze\io\OutputStream
     */
    public function getOutputStream();

    /**
     *
     * @return blaze\io\InputStream
     */
    public function getInputStream();
}

?>
