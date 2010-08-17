<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\ColumnMetaData;

/**
 * Description of AbstractColumnMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractColumnMetaData extends Object implements ColumnMetaData {
    /**
     *
     * @var blaze\lang\String
     */
    protected $columnName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $columnTypeName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $columnClassName;
    /**
     *
     * @var int
     */
    protected $columnLength;
    /**
     *
     * @var int
     */
    protected $columnPrecision;
    /**
     *
     * @var blaze\lang\String
     */
    protected $columnDefault;
    /**
     *
     * @var blaze\lang\String
     */
    protected $columnComment;
    /**
     *
     * @var boolean
     */
    protected $nullable;
    /**
     *
     * @var boolean
     */
    protected $autoIncrement;
    /**
     *
     * @var boolean
     */
    protected $signed;
    /**
     *
     * @var boolean
     */
    protected $primaryKey;
    /**
     *
     * @var boolean
     */
    protected $foreignKey;
    /**
     *
     * @var boolean
     */
    protected $uniqueKey;
    /**
     *
     * @var blaze\ds\meta\TableMetaData
     */
    protected $table;

}

?>
