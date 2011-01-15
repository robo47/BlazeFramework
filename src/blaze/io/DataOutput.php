<?php

namespace blaze\io;

/**
 * DataInput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
interface DataOutput {

    /**
     * @param boolean $boolean
     */
    public function writeBoolean(\boolean $boolean);

    /**
     * @param int $int
     */
    public function writeInt(\int $int);

    /**
     * @param float $float
     */
    public function writeFloat(\float $float);

    /**
     * @param long $long
     */
    public function writeLong(\long $long);

    /**
     * @param double $double
     */
    public function writeDouble(\double $double);

    /**
     * @param short $short
     */
    public function writeShort(\short $short);

    /**
     * @param byte $byte
     */
    public function writeByte(\byte $byte);
}

?>
