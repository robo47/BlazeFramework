<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class SelectClause extends Object{

    const TYPE_NONE = 0;
    const TYPE_ALL = 1;
    const TYPE_DISTINCT = 2;

    private $selectType;
    private $selectables = array();

    public function __construct($selectType = self::TYPE_NONE) {
        $this->selectType = $selectType;
    }

    public function getSelectType() {
        return $this->selectType;
    }

    public function setSelectType($selectType) {
        $this->selectType = $selectType;
    }

    public function getSelectables() {
        return $this->selectables;
    }

    public function addSelectable(Selectable $selectable) {
        if($this->selectType === self::TYPE_ALL)
                throw new \blaze\lang\Exception('A select clause of the type ALL may not take any selectables.');
        $this->selectables[] = $selectable;
    }



}

?>
