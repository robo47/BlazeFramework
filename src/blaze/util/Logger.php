<?php

namespace blaze\util;

use blaze\lang\Object,
 blaze\lang\Integer;

/**
 * Description of Logger
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class Logger extends Object {

    private static $instance;
    private $out;
    private $err;

    public function __construct($logpath = null) {
        if ($logpath === null) {
            $logpath = sys_get_temp_dir();
        }
        $this->out = new \blaze\io\output\BufferedWriter(new \blaze\io\output\FileWriter($logpath . 'blaze.log', true));
        $this->err = new \blaze\io\output\BufferedWriter(new \blaze\io\output\FileWriter($logpath . 'blazeError.log', true));
    }

    public function finalize() {
        parent::finalize();
        try {
            if ($this->out != null)
                $this->out->close();
        } catch (\blaze\lang\Exception $e) {

        }
        try {
            if ($this->err != null)
                $this->err->close();
        } catch (\blaze\lang\Exception $e) {

        }
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
