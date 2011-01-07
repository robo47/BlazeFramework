<?php

namespace blaze\ds\driver\pdomysql\type;

use blaze\lang\Object,
 blaze\ds\type\Clob,
 blaze\io\InputStream,
 blaze\io\input\PipedInputStream,
 blaze\io\output\PipedOutputStream;

/**
 * Simple implementation which uses pipes for data writing and wraps the native
 * stream in an implementation of InputStream for reading.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class ClobImpl extends Object implements Clob {

    private $is;
    private $os = null;
    private $pipedIn = null;

    public function __construct(\blaze\io\InputStream $is = null) {
        $this->is = $is;
    }

    public function getOutputStream() {
        if ($this->os === null) {
            $this->os = new PipedOutputStream();
            $this->pipedIn = new NativePipedInputStream($this->os);
        }

        return $this->os;
    }

    public function getInputStream() {
        if($this->is === null)
            return $this->pipedIn;
        else
            return $this->is;
    }

}

?>
