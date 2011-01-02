<?php
namespace blaze\collections;

/**
 * This is just to provide a framework specific interface in the case that
 * php will use a different namespace for the SPL stuff in further versions.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0
 */
interface ArrayAccess extends \ArrayAccess{}

?>
