<?php

namespace blaze\ds\driver\pdobase\meta;

/**
 * This is a simple implementation which just holds the values of the ColumnIndexEntry.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractColumnIndexEntry extends \blaze\lang\Object implements \blaze\ds\meta\ColumnIndexEntry {

    /**
     *
     * @var \blaze\ds\meta\IndexMetaData
     */
    protected $index;
    /**
     *
     * @var \blaze\lang\String
     */
    protected $columnExpression;
    /**
     *
     * @var int
     */
    protected $prefixLength;
    /**
     *
     * @var boolean
     */
    protected $sorting;

    public function getIndex() {
        return $this->index;
    }

}

?>
