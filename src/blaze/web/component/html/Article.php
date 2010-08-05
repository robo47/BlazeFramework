<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of Article
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Article extends \blaze\web\component\UIComponentCore{

    public function __construct(){
    }

    public static function create(){
        return new Article();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'DivRenderer';
    }

}

?>
