<?php
namespace blaze\ds\meta;

/**
 * Description of ColumnIndexEntry
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ColumnIndexEntry {

    private $columnName;
    private $prefix;
    private $sorting;

    public function __construct($columnName, $prefix = null, $sorting = 'ASC') {
        $this->columnName = $columnName;
        $this->prefix = $prefix;
        $this->sorting = $sorting;
    }

    public function getColumn() {
        return $this->columnName;
    }

    public function setColumn($columnName) {
        $this->columnName = $columnName;
    }

    public function getPrefix() {
        return $this->prefix;
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    public function getSorting() {
        return $this->sorting;
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
    }

}

?>
