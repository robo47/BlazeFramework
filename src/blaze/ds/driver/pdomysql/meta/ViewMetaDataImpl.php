<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractViewMetaData;

/**
 * Description of ViewMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ViewMetaDataImpl extends AbstractViewMetaData {

    private $schema;
    private $viewName;
    private $viewDefinition;
    private $updateable;

    public function __construct(\blaze\ds\meta\SchemaMetaData $schemaMetaData, $viewName, $viewDefinition, $updateable){
        $this->schema = $schemaMetaData;
        $this->viewName = $viewName;
        $this->viewDefinition = $viewDefinition;
        $this->updateable = $updateable;
    }
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema(){
        return $this->schema;
    }
    /**
     * @return blaze\lang\String
     */
     public function getViewName(){
         return $this->viewName;
     }
    /**
     * @return blaze\lang\String
     */
     public function getViewDefinition(){
         return $this->viewDefinition;
     }
    /**
     * @return boolean
     */
     public function isUpdateable(){
         return $this->updateable;
     }

     public function drop() {

     }

}

?>
