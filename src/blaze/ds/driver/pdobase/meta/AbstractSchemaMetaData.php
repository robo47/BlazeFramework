<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\SchemaMetaData;

/**
 * Description of AbstractSchemaMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractSchemaMetaData extends Object implements SchemaMetaData {
    /**
     * @return blaze\ds\meta\DatabaseMetaData
     */
    protected $databaseMetaData;
    /**
     * @return blaze\lang\String
     */
    protected $schemaName;
    /**
     * @return blaze\lang\String
     */
    protected $schemaCharset;
    /**
     * @return blaze\lang\String
     */
    protected $schemaCollation;

}

?>
