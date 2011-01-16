<?php

namespace blaze\net;

use blaze\lang\Object;

/**
 * Description of URLConnection
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class URLConnection extends Object {

    /**
     *
     * @var blaze\net\URL
     */
    protected $url;
    protected $connected = false;

    /**
     *
     * @param URL $url
     */
    public function __construct(URL $url) {
        $this->url = $url;
    }

    /**
     * @return blaze\lang\Object
     */
    public function getContent() {

    }

    /**
     * @return blaze\lang\String
     */
    public function getContentEncoding() {

    }

    /**
     * @return int
     */
    public function getContentLength() {

    }

    /**
     * @return blaze\lang\String
     */
    public function getContentType() {
        
    }

}

?>
