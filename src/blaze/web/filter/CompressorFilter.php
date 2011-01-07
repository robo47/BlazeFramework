<?php

namespace blaze\web\filter;

use blaze\lang\Object;

/**
 * Description of CompressorFilter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class CompressorFilter extends Object implements \blaze\netlet\Filter {

    public function destroy() {

    }

    public function doFilter(\blaze\netlet\NetletRequest $request, \blaze\netlet\NetletResponse $response, \blaze\netlet\FilterChain $chain) {
        if ($request instanceof \blaze\netlet\http\HttpNetletRequest) {
            $ae = $request->getHeader('Accept-Encoding');

            if ($ae != null) {
                if ($ae->indexOf('deflate') !== -1) {
                    $response = new CompressedHttpNetletResponse($response, false); //gzcompress
                    $chain->doFilter($request, $response);
                    $response->flush();
                    return;
                }
                if ($ae->indexOf('gzip') !== -1 || $ae->indexOf('x-gzip') !== -1) {
                    $response = new CompressedHttpNetletResponse($response, true); //gzencode
                    $chain->doFilter($request, $response);
                    $response->flush();
                    return;
                }
            }
        }
        $chain->doFilter($request, $response);
    }

    public function init(\blaze\netlet\FilterConfig $config) {

    }

}

class CompressedHttpNetletResponse extends \blaze\netlet\http\HttpNetletResponseWrapper {

    /**
     *
     * @var \blaze\io\OutputStream
     */
    private $compressedStream;
    /**
     *
     * @var \blaze\io\Writer
     */
    private $compressedWriter;
    private $gzip;

    public function __construct(\blaze\netlet\http\HttpNetletResponse $response, $gzip) {
        parent::__construct($response);
        $this->gzip = $gzip;
        $this->setHeader('Content-Encoding', $gzip ? 'gzip' : 'deflate');
    }

    public function getOutputStream() {
        if ($this->compressedStream === null) {
            if ($this->gzip)
                $this->compressedStream = new GZIPOutputStream($this->response->getOutputStream());
            else
                $this->compressedStream = new DeflaterOutputStream($this->response->getOutputStream());
        }
        return $this->compressedStream;
    }

    public function getWriter() {
        if ($this->compressedWriter === null)
            $this->compressedWriter = new \blaze\io\OutputStreamWriter($this->getOutputStream());
        return $this->compressedWriter;
    }

}

?>
