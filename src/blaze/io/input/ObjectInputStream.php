<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of ObjectInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class ObjectInputStream extends \blaze\io\InputStream implements \blaze\io\DataInput {

    /**
     * @var blaze\io\InputStream
     */
    private $in;
    private $tokenizer;
    private $tokens = array();
    private $tokensSize = 0;
    private $tokensCurser = 0;
    private $buffer = '';
    private $bufferSize = 0;
    private $bufferCursor = 0;
    private $current;

    /**
     *
     * @param blaze\io\InputStream $reader The reader
     * @param int $buffsize The size of the buffer which should be used for reading.
     */
    public function __construct(\blaze\io\InputStream $stream) {
        $this->in = $stream;
        $this->tokenizer = new \blaze\io\SerializationTokenizer('{', '}');
    }

    private function fillBuffer(){
        $add = $this->in->read();
        $this->bufferSize += strlen($add);
        $this->buffer .= $add;
    }

    private function fillTokens(){
        $this->fillBuffer();
        if($this->bufferCursor < $this->bufferSize){
            $result = $this->tokenizer->tokenize(substr($this->buffer, $this->bufferCursor, $this->bufferSize - $this->bufferCursor));
            foreach($result[0] as $token){
                $this->tokens[] = $token;
                $this->tokensSize++;
            }
            $this->bufferCursor += $result[1];
        }
    }

    private function getNext(){
        while($this->tokensCurser == $this->tokensSize)
                $this->fillTokens();
        return $this->tokens[$this->tokensCurser++];
    }

    /**
     * Reads and returns data from the reader.
     * @param int $len Number of bytes to read, uses buffer size if not given.
     * @return string .
     */
    public function read($len = -1) {
        $result = unserialize($this->getNext());
        $read = strlen($result);

        if($len != -1 && $read != $len)
            throw new \blaze\io\StreamCorruptedException('Tried to read '.$len.' chars for the next token but the token has '.$read.' characters.');
        return $result;
    }

    public function readInto(\blaze\lang\StringBuffer $buffer, $off = -1, $len = -1) {
        $result = unserialize($this->getNext());
        $read = strlen($str);

        if($len != -1 && $read != $len)
            throw new \blaze\io\StreamCorruptedException('Tried to read '.$len.' chars for the next token but the token has '.$read.' characters.');

         if($off < 0)
             $buffer->append($result);
         else
            $buffer->insert($result, $off);

         return $read;
    }

    public function readBoolean() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Boolean::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a boolean');
        return $result;
    }

    public function readInt() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Integer::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a integer');
        return $result;
    }

    public function readFloat() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Float::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a float');
        return $result;
    }

    public function readLong() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Long::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a long');
        return $result;
    }

    public function readDouble() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Double::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a double');
        return $result;
    }

    public function readShort() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Short::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a short');
        return $result;
    }

    public function readByte() {
        $result = unserialize($this->getNext());
        if(!\blaze\lang\Byte::isType($result))
            throw new \blaze\lang\ClassCastException('The next token is not a byte');
        return $result;
    }

    public function readObject() {
        $result = unserialize($this->getNext());
        if (!$result instanceof \blaze\io\Serializable || !$result instanceof \blaze\lang\Reflectable)
            throw new \blaze\io\NotSerializableException();
        return $result;
    }

    public function readObjectOverride() {
        $ser = $this->getNext();
        if($ser[0] != 'O')
            throw new \blaze\lang\ClassCastException('The next token is not a object');
        $start = strpos($ser, '"') + 1;
        $end = strpos($ser, '"', $start);
        $class = \blaze\lang\ClassWrapper::forName(substr($ser, $start, $end - $start));
        $object = $class->newInstance();

        if (!$object instanceof \blaze\io\Serializable)
            throw new \blaze\io\NotSerializableException();
        $method = $class->getMethod('readObject');

        if ($method != null) {
            $this->current = substr($ser,strpos($ser, '{', $end) + 1, -1);
            $method->invoke($object, $this);
            $this->current = null;
        } else {
            $object = unserialize($ser);
        }
        return $object;
    }

    public function defaultReadObject() {
        if ($this->current == null)
            throw new \blaze\io\NotActiveException();
        $this->out->read(serialize($this->current));
    }

    public function skip($n) {
        return $this->in->skip($n);
    }

    public function reset() {
        return $this->in->reset();
    }

    public function close() {
        return $this->in->close();
    }

    public function isClosed() {
        return $this->in->isClosed();
    }

    public function available() {
        return $this->bufferSize - $this->bufferCursor;
    }


}
?>
