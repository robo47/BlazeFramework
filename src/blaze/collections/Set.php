<?php
namespace blaze\collections;

/**
 * Implementations of Set have to provide, that they only store unique elements.
 * This means that if the same object is added twice or more to a set, it may
 * only appear once in it, same thing with null.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface Set extends Collection{

}

?>
