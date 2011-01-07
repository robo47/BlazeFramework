<?php

namespace blaze\persistence\hydration;

use blaze\lang\Object;

/**
 * Description of ObjectHydrator
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ObjectHydrator extends Object implements \blaze\persistence\Hydrator {

    private $rs;
    private $rsd;
    private $iterator;

    /**
     *
     * @param \blaze\ds\ResultSet $rs
     * @param \blaze\persistence\meta\ResultSetDescriptor $rsd
     */
    public function __construct(\blaze\ds\ResultSet $rs, \blaze\persistence\meta\ResultSetDescriptor $rsd) {
        $this->rs = $rs;
        $this->rsd = $rsd;
    }

    /**
     *
     * @return array[\blaze\lang\Object]
     */
    public function hydrateAll() {
        if ($this->iterator === null)
            $this->iterator = $this->getIterator();
        $return = array();

        while ($this->iterator->hasNext()) {
            $return[] = $this->iterator->next();
        }

        return $return;
    }

    /**
     *
     * @return \blaze\collections\Iterator
     */
    public function getIterator() {
        return new ObjectHydratorIterator($this->rs, $this->rsd);
    }

}

?>
