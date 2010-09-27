<?php
namespace blaze\persistence;

/**
 * Description of Session
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Dialect {
    public function getNativeQuery(\blaze\persistence\ooql\Statement $stmt, \blaze\persistence\SessionFactory $fact);
}

?>
