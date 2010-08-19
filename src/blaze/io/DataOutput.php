<?php
namespace blaze\io;

/**
 * DataInput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface DataOutput {
    /**
     * @param boolean $boolean
     */
    public function writeBoolean($boolean);

    /**
     * @param int $int
     */
    public function writeInt($int);

    /**
     * @param float $float
     */
    public function writeFloat($float);

    /**
     * @param long $long
     */
    public function writeLong($long);

    /**
     * @param double $double
     */
    public function writeDouble($double);

    /**
     * @param short $short
     */
    public function writeShort($short);

    /**
     * @param byte $byte
     */
    public function writeByte($byte);
}

?>
