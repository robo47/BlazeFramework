<?php

namespace blaze\util;

use blaze\lang\Object;

/**
 * Description of Timer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class Timer extends Object {

    private $elapsedTime;

    public function start() {
        $this->elapsedTime = $this->getMicrotime();
    }

    public function stop() {
        $this->elapsedTime = round($this->getMicrotime() - $this->elapsedTime, 5);

        return $this->elapsedTime;
    }

    private function getMicrotime() {
        list($useg, $seg) = explode(' ', microtime());
        return ((float) $useg + (float) $seg);
    }

}

?>
