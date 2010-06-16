<?php
namespace blaze\sql\driver\pdobase\meta;
use blaze\sql\meta\ViewMetaData;

/**
 * Description of AbstractViewMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractViewMetaData implements ViewMetaData {
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
