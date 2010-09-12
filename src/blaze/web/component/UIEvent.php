<?php
namespace blaze\web\component;
use blaze\lang\Object;

/**
 * Description of Address
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIEvent extends \blaze\web\component\UIComponentBase{

    private $effects = array();

    public function addChild(\blaze\web\component\UIComponent $child) {
        if($child instanceof UIEffect)
            $this->effects[] = $child;
        else
            ; // Impossible because of XSD
//        return parent::addChild($child);
    }

    public function getEffects() {
        return $this->effects;
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {

    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {

    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {

    }

}

?>
