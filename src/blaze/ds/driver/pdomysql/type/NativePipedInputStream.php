<?php

namespace blaze\ds\driver\pdomysql\type;

use blaze\lang\Object,
 blaze\ds\type\Blob,
 blaze\io\InputStream,
 blaze\io\input\PipedInputStream,
 blaze\io\output\PipedOutputStream;

/**
 * This is a extended PipedInputStream which uses a native stream to save bytes
 * and reads with the native functions of it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */

class NativePipedInputStream extends PipedInputStream {

    /**
     *
     * @var PipedOutputStream
     */
    private $pos = null;
    private $nativeStream;
    private static $MAX_SIZE = 52428800; // 5 MB

    public function connect(\blaze\io\output\PipedOutputStream $pos) {
        if ($this->pos == null) {
            $this->pos = $pos;
            $this->pos->connect($this);
            $this->nativeStream = fopen('php://temp/maxmemory:' . self::$MAX_SIZE, 'r+');

            if (!$this->nativeStream)
                throw new \blaze\ds\DataSourceException('Colud not create Blob!');
        }
    }

    public function isClosed() {
        return $this->pos === null;
    }

    public function close() {
        parent::close();
        fclose($this->nativeStream);
    }

    public function receive($data) {
        $this->checkClosed();
        fwrite($this->nativeStream, $data);
        $this->count += strlen($data);
    }

    public function read($len = -1) {
        $this->checkClosed();

        if ($len > 0 && $len + $this->position <= $this->count)
            $result = fread($handle, $len);
        else
            $result = fread($handle, $this->count);

        $read = strlen($result);
        $this->position += $read;
        return $result;
    }

    public function skip(\long $n) {
        $this->checkClosed();
        $this->position += $n;
        fseek($this->nativeStream, $n, SEEK_CUR);
    }

    public function reset() {
        $this->position = $this->mark;
        fseek($this->nativeStream, $this->position, SEEK_SET);
    }

    public function getNativeStream(){
        return $this->nativeStream;
    }

}

?>