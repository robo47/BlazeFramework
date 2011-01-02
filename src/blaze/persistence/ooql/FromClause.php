<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class FromClause extends Object{

    private $fromables = array();

    public function __construct() {
    }

    public function getFromables() {
        return $this->fromables;
    }

    public function addFromable(Fromable $fromable) {
        $this->fromables[] = $fromable;
    }



}

?>
