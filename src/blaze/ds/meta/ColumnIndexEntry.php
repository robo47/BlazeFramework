<?php

namespace blaze\ds\meta;

/**
 * Description of ColumnIndexEntry
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


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
