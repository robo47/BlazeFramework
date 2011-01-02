<?php
namespace blaze\web\event;

/**
 * Description of ActionListener
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ExpressionValueChangeListener extends \blaze\lang\Object implements ValueChangeListener{
    private $expression;
    
    public function __construct(\blaze\web\el\Expression $expression){
        $this->expression = $expression;
    }

    public function processValueChange(ValueChangeEvent $event){
        $this->expression->invoke(\blaze\web\application\BlazeContext::getCurrentInstance(),array($event));
    }
}

?>
