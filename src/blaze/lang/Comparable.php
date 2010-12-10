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
 */

interface Comparable{
    public function compareTo(Object $obj);
}
?>