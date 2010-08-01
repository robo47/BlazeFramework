<?php
namespace blaze\ds\meta;

/**
 * Description of DatabaseMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface DatabaseMetaData {
    /**
     * @return blaze\ds\Connection
     */
    public function getConnection();
    /**
     * @return blaze\lang\String
     */
    public function getHost();
    /**
     * @return blaze\lang\String
     */
    public function getDatabaseName();
    /**
     * @return blaze\lang\String
     */
    public function getUser();
    /**
     * @return integer
     */
    public function getPort();
    /**
     * @return array
     */
    public function getOptions();
    /**
     * @return blaze\net\URI
     */
    //public function getURI();

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductName();
    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductVersion();

    /**
     * @return blaze\lang\String
     */
    public function getDriverName();
    /**
     * @return blaze\lang\String
     */
    public function getDriverVersion();

    /**
     * @return blaze\util\ListI[blaze\ds\meta\SchemaMetaData]
     */
    public function getSchemas();
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema($schemaName);
    
}

?>
