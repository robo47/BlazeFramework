<?php

namespace blaze\lang;

/**
 * To use static initialization this interface has to be implemented.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     blaze\lang\ClassLoader#loadClass
 * @since   1.0
 * @author  Christian Beikov
 */
interface StaticInitialization {

    /**
     * The method which shall be called directly after loading the class into the
     * class loader. This part can be used for pre initializations.
     *
     * @access private
     */
    public static function staticInit();
}

?>
