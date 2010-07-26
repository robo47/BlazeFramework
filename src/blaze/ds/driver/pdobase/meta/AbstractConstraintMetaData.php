<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ConstraintMetaData;

/**
 * Description of AbstractConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractConstraintMetaData extends Object implements ConstraintMetaData {

    /**
     *
     * @var blaze\lang\String
     */
    protected $constraintName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $constraintType;
    /**
     *
     * @var array[blaze\ds\meta\ColumnMetaData]
     */
    protected $columns;

    /**
     * @return blaze\lang\String
     */
    public function getConstraintName() {
        return $this->constraintName;
    }

    /**
     * @return blaze\lang\String
     */
    public function getConstraintType() {
        return $this->constraintType;
    }

    /**
     * @return array[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns() {
        return $this->columns;
    }

}
?>
