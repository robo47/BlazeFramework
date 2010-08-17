<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\TableMetaData;

/**
 * Description of AbstractTableMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractTableMetaData extends Object implements TableMetaData{
    /**
     * @return blaze\lang\String
     */
    protected $tableName;
    /**
     * @return blaze\lang\String
     */
    protected $tableComment;
    /**
     * @return blaze\lang\String
     */
    protected $tableCharset;
    /**
     * @return blaze\lang\String
     */
    protected $tableCollation;
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    protected $schema;

}

?>
