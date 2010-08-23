<?php
namespace blaze\web\component;

/**
 * Description of ActionSource
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface NamingContainer {
     const CONTAINER_SEPARATOR = ':';
     const ID_SEPARATOR = '_';
     public function getContainerPrefix();
     public function createUniqueId();
}

?>
