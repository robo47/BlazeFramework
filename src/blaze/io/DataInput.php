<?php

namespace blaze\io;

/**
 * DataInput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
interface DataInput {

    /**
     * @return boolean
     */
    public function readBoolean();

    /**
     * @return int
     */
    public function readInt();

    /**
     * @return float
     */
    public function readFloat();

    /**
     * @return long
     */
    public function readLong();

    /**
     * @return double
     */
    public function readDouble();

    /**
     * @return short
     */
    public function readShort();

    /**
     * @return byte
     */
    public function readByte();
}

?>
