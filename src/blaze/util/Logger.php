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
 */
class Logger extends Object {

    private static $instance;
    private $out;
    private $err;

    public function __construct() {
        $this->out = new \blaze\io\output\BufferedWriter(new \blaze\io\output\FileWriter('D:\\xampp\\tmp\\blaze.log', true));
        $this->err = new \blaze\io\output\BufferedWriter(new \blaze\io\output\FileWriter('D:\\xampp\\tmp\\blazeError.log', true));
    }

    public function finalize() {
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

    public function logError($errno, $errstr, $errfile , $errline, $errcontext ) {
        $this->err->writeLine($errno.' - '.$errstr.' in file '.$errfile.' on line '.$errline.' with context '.var_export($errcontext));
        $this->err->flush();
    }

}

?>
