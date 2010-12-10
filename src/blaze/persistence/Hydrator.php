<?php
namespace blaze\persistence;

/**
 * Description of Hydrator
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface Hydrator extends \blaze\collections\Iterable{
     public function hydrateAll();
}

?>
