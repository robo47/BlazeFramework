<?php
namespace blaze\persistence\impl\queryBuilder;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractBuilder extends \blaze\lang\Object{

    protected $statement;

    /**
     * @return blaze\persistence\Statement
     */
    public function getStatement(){
        return $this->statement;
    }
}

?>
