<?php

namespace blaze\util;

use blaze\lang\Object,
 blaze\lang\Integer;

/**
 * Description of Logger
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Logger extends Object {

    private static $instance;
    private $out;

    public function __construct() {
        $this->out = new \blaze\io\output\BufferedWriter(new \blaze\io\output\FileWriter('D:\\xampp\\tmp\\blaze.log', true));
    }

    public function finalize() {
        try {
            if ($this->out != null)
                $this->out->close();
        } catch (\blaze\lang\Exception $e) {

        }
        parent::finalize();
    }

    /**
     *
     * @return Logger
     */
    public static function get() {
        if (self::$instance == null)
            self::$instance = new Logger();
        return self::$instance;
    }

    public function log($str) {
        $this->out->writeLine($str);
        $this->out->flush();
    }

}

?>
