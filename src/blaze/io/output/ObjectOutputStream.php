<?php

namespace blaze\io\output;

use blaze\lang\Object;

/**
 * Description of BufferedOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class ObjectOutputStream extends \blaze\io\OutputStream implements \blaze\io\DataOutput {

    /**
     * @var blaze\io\OutputStream The OutputStream we are buffering output to.
     */
    private $out;
    private $current;

    public function __construct(\blaze\io\OutputStream $stream) {
        $this->out = $stream;
    }

    public function write($str, $off = 0, $len = -1) {
        $str = \blaze\lang\String::asNative($str);

        if ($off > 0) {
            if ($len > 0)
                $str = substr($str, $off, $len);
            else
                $str = substr($str, $off);
        }

        return $this->out->write(serialize($str));
    }

    public function writeBoolean($boolean) {
        $boolean = \blaze\lang\Boolean::asNative($boolean);
        return $this->out->write(serialize($boolean));
    }

    public function writeInt($int) {
        $int = \blaze\lang\Integer::asNative($int);
        return $this->out->write(serialize($int));
    }

    public function writeFloat($float) {
        $float = \blaze\lang\Float::asNative($float);
        return $this->out->write(serialize($float));
    }

    public function writeLong($long) {
        $long = \blaze\lang\Long::asNative($long);
        return $this->out->write(serialize($long));
    }

    public function writeDouble($double) {
        $double = \blaze\lang\Double::asNative($double);
        return $this->out->write(serialize($double));
    }

    public function writeShort($short) {
        $short = \blaze\lang\Short::asNative($short);
        return $this->out->write(serialize($short));
    }

    public function writeByte($byte) {
        $byte = \blaze\lang\Byte::asNative($byte);
        return $this->out->write(serialize($byte));
    }

    public function writeObject(Object $object) {
        if (!$object instanceof \blaze\io\Serializable)
            throw new \blaze\io\NotSerializableException();
        return $this->out->write(serialize($object));
    }

    /**
     *
     * @param Object $object
     * @todo implement a working version(recursive writeObjectOverride!)
     */
    public function writeObjectOverride(Object $object) {
        if (!$object instanceof \blaze\io\Serializable)
            throw new \blaze\io\NotSerializableException();
        $class = $object->getClass();
        $method = $class->getMethod('writeObject');

        if ($method != null) {
            $className = $class->getName();
            $ser = 'O:'.$className->length().':"'.$className->toNative().'":';
            $this->current = $object;
            $method->invoke($object, $this);
            $this->current = null;
        } else {
            $this->out->write(serialize($object));
        }
    }

    public function defaultWriteObject() {
        if ($this->current == null)
            throw new \blaze\io\NotActiveException ();
        $this->out->write(serialize($this->current));
    }

    public function flush() {
        $this->out->flush();
    }

    public function close() {
        return $this->out->close();
    }

    public function isClosed() {
        return $this->out->isClosed();
    }

}

?>
