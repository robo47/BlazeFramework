<?php
namespace blaze\web\event;

/**
 * Description of ActionListener
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ValueChangeListener extends BlazeListener{
    public function processValueChange(ValueChangeEvent $event);
}

?>
