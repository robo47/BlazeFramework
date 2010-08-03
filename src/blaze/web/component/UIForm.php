<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of UIForm
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIForm extends \blaze\web\component\UIComponentBase {

    private $submitted = false;

    public function getSubmitted() {
        return $this->submitted;
    }

    public function setSubmitted($submitted) {
        $this->submitted = $submitted;
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        $renderer = $this->getRenderer($context);
        $renderer->decode($context, $this);

        if(!$this->submitted) return;

        foreach($this->getChildren() as $child)
            $child->processDecodes($context);
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        if(!$this->submitted) return;
        parent::processUpdates($context);
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        if(!$this->submitted) return;
        parent::processValidations($context);
    }


}
?>
