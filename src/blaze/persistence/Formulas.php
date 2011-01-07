<?php

namespace blaze\persistence;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Formulas {

    private function __construct() {

    }

    /**
     * @return blaze\persistence\ooql\Formula
     */
    public static function count($property, $entityAlias = null, $propertyAlias = null) {
        $formula = new ooql\Formula('COUNT', false);
        $formula->addArgument(new \blaze\persistence\ooql\Property($entityAlias, $property, $propertyAlias));
        return $formula;
    }

    /**
     * @return blaze\persistence\ooql\Formula
     */
    public static function avg($property, $entityAlias = null, $propertyAlias = null) {
        $formula = new ooql\Formula('AVG', false);
        $formula->addArgument(new \blaze\persistence\ooql\Property($entityAlias, $property, $propertyAlias));
        return $formula;
    }

    /**
     * @return blaze\persistence\ooql\Formula
     */
    public static function sum($property, $entityAlias = null, $propertyAlias = null) {
        $formula = new ooql\Formula('SUM', false);
        $formula->addArgument(new \blaze\persistence\ooql\Property($entityAlias, $property, $propertyAlias));
        return $formula;
    }

}

?>
