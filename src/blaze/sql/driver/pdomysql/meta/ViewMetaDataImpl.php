<?php
namespace blaze\sql\driver\pdomysql\meta;
use blaze\sql\driver\pdobase\meta\AbstractViewMetaData;

/**
 * Description of ViewMetaDataImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ViewMetaDataImpl extends AbstractViewMetaData {
    /**
     * @return blaze\sql\meta\SchemaMetaData
     */
    public function getSchema();
    /**
     * @return blaze\lang\String
     */
     public function getViewName();
    /**
     * @return blaze\lang\String
     */
     public function getViewDefinition();
    /**
     * @return boolean
     */
     public function isUpdateable();
}

?>
