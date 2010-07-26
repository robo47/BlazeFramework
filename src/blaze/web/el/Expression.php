<?php
namespace blaze\web\el;
use blaze\lang\Object;

/**
 * Description of Expression
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Expression extends Object{
    protected $expressionString;

    public function __construct($expressionString) {
        $this->expressionString = \blaze\lang\String::asWrapper($expressionString);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getExpressionString() {
        return $this->expressionString;
    }


}

?>
