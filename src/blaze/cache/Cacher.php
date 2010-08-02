<?php
namespace blaze\cache;

/**
 * Description of Cacher
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
interface Cacher {
    public function doCache($key, $value);
    public function isCached($key);
    public function getCache($key);
    public function invalidate($key);
    public function invalidateAll($keyPrefix);
}
?>
