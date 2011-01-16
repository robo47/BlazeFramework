<?php

namespace blaze\io\output;

use blaze\lang\Object;

/**
 * Description of BufferedOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class ObjectOutputStream extends \blaze\io\output\FilterOutputStream implements \blaze\io\DataOutput {

    private $current;

    public function __construct(\blaze\io\OutputStream $stream) {
        parent::__construct($stream);
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

    public function writeBoolean(\boolean $boolean) {
        $boolean = \blaze\lang\Boolean::asNative($boolean);
        return $this->out->write(serialize($boolean));
    }

    public function writeInt(\int $int) {
        $int = \blaze\lang\Integer::asNative($int);
        return $this->out->write(serialize($int));
    }

    public function writeFloat(\float $float) {
        $float = \blaze\lang\Float::asNative($float);
        return $this->out->write(serialize($float));
    }

    public function writeLong(\long $long) {
        $long = \blaze\lang\Long::asNative($long);
        return $this->out->write(serialize($long));
    }

    public function writeDouble(\double $double) {
        $double = \blaze\lang\Double::asNative($double);
        return $this->out->write(serialize($double));
    }

    public function writeShort(\short $short) {
        $short = \blaze\lang\Short::asNative($short);
        return $this->out->write(serialize($short));
    }

    public function writeByte(\byte $byte) {
        $byte = \blaze\lang\Byte::asNative($byte);
        return $this->out->write(serialize($byte));
    }

    public function writeObject(\blaze\lang\Reflectable $object) {
        if (!$object instanceof \blaze\io\Serializable)
            throw new \blaze\io\NotSerializableException();
        return $this->out->write(serialize($object));
    }

    /**
     *
     * @param \blaze\lang\Reflectable $object
     * @todo implement a working version(recursive writeObjectOverride!)
     */
    public function writeObjectOverride(\blaze\lang\Reflectable $object) {
        if (!$object instanceof \blaze\io\Serializable)
            throw new \blaze\io\NotSerializableException();
        $class = $object->getClass();
        $method = $class->getMethod('writeObject');

        if ($method != null) {
            $className = $class->getName();
            $ser = 'O:' . $className->length() . ':"' . $className->toNative() . '":';
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

}

?>
