<?php
namespace blaze\netlet\http;
use blaze\lang\Singleton;

/**
 * Description of HttpSessionHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface HttpSessionHandler extends Singleton {
    /**
     * @param boolean $create Indicates wether a session shall be created when no session is available or not.
     */
     public function getCurrentSession($create = false);
}

?>
