<?php
namespace blaze\web\validator;
use blaze\lang\Exception;

/**
 * Description of ValidatorException
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ValidatorException extends \blaze\web\application\BlazeException {
    private $blazeMessage;
    
    public function __construct(\blaze\web\application\BlazeMessage $blazeMessage, \Exception $previous = null){
        parent::__construct($blazeMessage->getSummary(), 0, $previous);
        $this->blazeMessage = $blazeMessage;
    }
    
    public function getBlazeMessage(){
        return $this->blazeMessage;
    }
}

?>
