<?php

namespace blaze\netlet;

/**
 * Description of NetletResponse
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface NetletResponse {
    public function flush();

    public function isCommited();

    public function reset();

    public function getContentLength();

    public function setContentLength(\int $len);

    public function getCharacterEncoding();

    public function setCharacterEncoding(\blaze\lang\String $charset);

    public function getLocale();

    public function setLocale(\blaze\util\Locale $locale);

    public function getContentType();

    public function setContentType(\blaze\lang\String $type);

    /**
     * @return blaze\io\OutputStream
     */
    public function getOutputStream();

    /**
     * @return blaze\io\Writer
     */
    public function getWriter();
}

?>
