<?php
namespace blaze\io;
use blaze\lang\StringBuffer;
/**
 * Description of Markable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Markable {
     
    /**
     * If marking is supported, a mark is placed at the current position.
     * If reset() is called on a reader which supports marks and mark() was called previously, then the current position moves to the mark.
    */    
    public function mark();
    /**
     * Returns whether marking is supported or not.
     * @return boolean
     */
    public function markSupported();
}

?>
