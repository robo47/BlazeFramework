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
abstract class UIPanel extends \blaze\web\component\UIComponentCore implements \blaze\web\component\NamingContainer{

    public function __construct(){
    }
    
    public static function create(){
        return new Panel();
    }

}

?>
