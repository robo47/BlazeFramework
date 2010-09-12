<?php

namespace blaze\web\component\event;

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
class CustomEffect extends \blaze\web\component\UIEffect{

    private $effectCode;


    public static function create() {
        return new CustomEffect();
    }

    public function getComponentFamily() {
        return 'blaze.event';
    }

    public function getRendererId() {
        return 'CustomEffectRenderer';
    }
}
?>
