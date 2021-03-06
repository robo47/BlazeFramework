<?php

namespace blaze\text;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\util\Locale;

/**
 * Description of DateFormat
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DateFormat extends Object {

    /**
     *
     * @var blaze\lang\String
     */
    private $pattern;
    /**
     *
     * @var blaze\util\Locale
     */
    private $locale;

    public function __construct(\blaze\lang\String $pattern, Locale $locale = null) {
        $this->pattern = $pattern;
        if ($locale == null)
            $this->locale = Locale::getDefault();
        else
            $this->locale = $locale;
    }

    /**
     *
     * @param blaze\lang\String|string $string
     * @return blaze\util\Date
     */
    public function parseDate($string) {
        $info = date_parse_from_format($this->pattern, $string);
        if ($info['error_count'] !== 0)
            throw new ParseException($info['errors'][0]);
        $d = new \blaze\util\Date($info['year'], $info['month'], $info['day'], $info['hour'], $info['minute'], $info['second']);
        return $d;
    }

    public function format(\blaze\util\Date $date) {
        return date($this->pattern, $date->getUnixTime());
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     *
     * @param blaze\lang\String|string $pattern
     * @return blaze\text\DateFormat
     */
    public function setPattern(\blaze\lang\String $pattern) {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     *
     * @return blaze\util\Locale
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     *
     * @param blaze\util\Locale $locale
     * @return blaze\text\DateFormat
     */
    public function setLocale(Locale $locale) {
        if ($locale == null)
            $this->locale = Locale::getDefault();
        else
            $this->locale = $locale;
        return $this;
    }

}

?>
