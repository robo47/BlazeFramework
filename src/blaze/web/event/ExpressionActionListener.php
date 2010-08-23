<?php
namespace blaze\web\event;

/**
 * Description of ActionListener
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ExpressionActionListener extends \blaze\lang\Object implements ActionListener{
    private $expression;
    
    public function __construct(\blaze\web\el\Expression $expression){
        $this->expression = $expression;
    }

    public function processAction(ActionEvent $obj) {
        $this->expression->invoke(\blaze\web\application\BlazeContext::getCurrentInstance(),array($event));
    }
}

?>
