<?php
namespace blaze\ds\driver\pdomysql\type;
use blaze\lang\Object,
    blaze\ds\type\Blob,
    blaze\io\InputStream,
    blaze\io\input\PipedInputStream,
    blaze\io\output\PipedOutputStream,
    blaze\ds\Statement;

/**
 * Description of BlobImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class BlobImpl extends Object implements Blob{

    private $is;
    private $os = null;
    private $pipedIn = null;

    public function __construct(InputStream $is) {
        $this->is = $is;
    }

    /**
     *
     * @return blaze\io\OutputStream
     */
    public function getOutputStream(){
        if($this->os === null){
            $this->os = new PipedOutputStream();
            $this->pipedIn = new PipedInputStream($this->os);
        }

        return $this->os;
    }

    /**
     *
     * @return blaze\io\InputStream
     */
    public function getInputStream(){
        return $this->is;
    }

    /**
     *
     * @return blaze\io\InputStream
     */
    public function getPipedInputStream(){
        return $this->pipedIn;
    }
}

?>
