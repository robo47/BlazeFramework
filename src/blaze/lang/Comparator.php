<?php
namespace blaze\lang;
/**
 * Description of Comparable
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Documentation.
 */

interface Comparator{
    public function compare(Object $o1, Object $o2);
}
?>