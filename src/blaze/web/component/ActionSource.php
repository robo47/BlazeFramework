<?php

namespace blaze\web\component;

/**
 * Description of ActionSource
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ActionSource {
    public function getAction();

    public function setAction($action);

    public function getActionListeners();

    public function setActionListener($actionListener);

    public function addActionListener(\blaze\web\el\Expression $actionListener);

    // Immediate and more actionListeners?
}

?>
