<?php
namespace blaze\ds\type;

/**
 * Description of Blob
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Blob {

    /**
     *
     * @return blaze\io\OutputStream
     */
    public function getOutputStream();

    /**
     *
     * @return blaze\io\InputStream
     */
    public function getInputStream();
}

?>
