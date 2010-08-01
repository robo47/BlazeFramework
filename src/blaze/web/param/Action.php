<?php
namespace blaze\web\param;
use blaze\lang\Object;

/**
 * Description of Action
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Action extends Object{
    protected $name;
    protected $actionListener;
    protected $action;

    function __construct($name = null, $actionListener = null, $action = null) {
        $this->name = $name;
        $this->actionListener = $actionListener;
        $this->action = $action;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getActionListener() {
        return $this->actionListener;
    }

    public function setActionListener($actionListener) {
        $this->actionListener = $actionListener;
        return $this;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }


}

?>
