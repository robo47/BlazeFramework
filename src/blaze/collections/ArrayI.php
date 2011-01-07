<?php

namespace blaze\collections;

use blaze\lang\Object;

/**
 * This is the OOP version of simple arrays in PHP. Subtypes of this interface
 * have a fixed size but every method which expects an ArrayI also has a fallback.
 * In other words, there is no type hint which forces the ArrayI type but the allowed types
 * can be found in the parameter comments. This types will be checked in the methods.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @property-read int $length Provide the java feeling, that every array has a final memeber which holds the length of the array
 * @author  Christian Beikov
 */
interface ArrayI extends Iterable, Countable, ArrayAccess {

}

?>