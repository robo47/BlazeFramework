<?php
namespace blaze\lang;
/**
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  RedShadow
 * @todo    Documentation
 */
interface Singleton {
    /**
     * Returns a Singleton instance of the given class which exists only once
     *
     * @return Singleton A Singleton instance of the given class
     */
    public static function getInstance();
}
?>
