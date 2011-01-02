<?php
namespace blaze\persistence\ooql;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Selectable {
    const PROPERTY = 1;
    const FORMULA = 2;
    
    public function getPrefix();
    public function getType();
    public function getAlias();
}

?>
