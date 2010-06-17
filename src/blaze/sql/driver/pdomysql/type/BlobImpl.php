<?php
namespace blaze\sql\driver\pdomysql\type;
use blaze\lang\Object,
    blaze\sql\type\Blob,
    blaze\io\InputStream,
    blaze\io\PipedInputStream,
    blaze\io\PipedOutputStream,
    blaze\sql\Statement;

/**
 * Description of BlobImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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
