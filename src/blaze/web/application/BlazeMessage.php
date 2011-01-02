<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper;

/**
 * The BlazeMessage is a message to a view like a validation error message or other.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class BlazeMessage extends Object {

    const SEVERITY_ERROR = 0;
    const SEVERITY_FATAL = 1;
    const SEVERITY_INFO = 2;
    const SEVERITY_WARN = 3;

    private $summary;
    private $detail;
    private $severity;

    /**
     *
     * @param string|blaze\lang\String $summary
     * @param string|blaze\lang\String $detail
     * @param blaze\web\application\BlazeMessage $severity Constant in the BlazeMessage class
     */
    public function __construct($summary = null, $detail = null, $severity = -1) {
        $this->summary = $summary;
        $this->detail = $detail;

        if($severity == -1)
            $this->severity = self::SEVERITY_INFO;
        else
            $this->severity = $severity;
    }
    
    public function getSummary() {
        return $this->summary;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
    }

    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getSeverity() {
        return $this->severity;
    }

    public function setSeverity($severity) {
        $this->severity = $severity;
    }

}
?>
