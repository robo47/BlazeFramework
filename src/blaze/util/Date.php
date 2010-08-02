<?php
namespace blaze\util;
use blaze\lang\Object,
    blaze\lang\Integer;

/**
 * Description of Date
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Date extends Object {
    
    /**
     *
     * @var integer
     */
    private $year = 0;
    /**
     *
     * @var integer
     */
    private $month = 0;
    /**
     *
     * @var integer
     */
    private $day = 0;
    /**
     *
     * @var integer
     */
    private $hour = 0;
    /**
     *
     * @var integer
     */
    private $minute = 0;
    /**
     *
     * @var integer
     */
    private $second = 0;
    /**
     *
     * @var integer
     */
    private $millisecond = 0;
    /**
     *
     * @var integer
     */
    private $timestamp = 0;
    /**
     *
     * @var blaze\util\TimeZone
     */
    private $timeZone = null;
    /**
     *
     * @var boolean
     */
    private $newTime = false;

    public function __construct($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $millisecond = 0, TimeZone $timeZone = null) {
        $this->setYear($year);
        $this->setMonth($month);
        $this->setDay($day);
        $this->setHour($hour);
        $this->setMinute($minute);
        $this->setSecond($second);
        $this->setMillisecond($millisecond);
        $this->setTimeZone($timeZone);
    }

    /**
     * Generates a Date object with a timestamp and a timezone.
     * @param long $timestamp 
     */
    public static function fromTime($timestamp, TimeZone $timeZone = null){
        $d = new self();
        $d->setTimeZone($timeZone);
        $d->setTime(Long::asNative($timestamp));
        return $d;
    }

    /**
     * Generates a Date object with a timestamp and a timezone.
     * @param long $timestamp 
     */
    public static function fromUnixTime($timestamp, TimeZone $timeZone = null){
        return self::fromTime($timestamp * 1000, $timeZone);
    }

    /**
     * Calculates the date from the timestamp
     */
    private function calculateDate(){
        $info = getdate((int)($this->timestamp / 1000));
        $this->setYear($info['year']);
        $this->setMonth($info['mon']);
        $this->setDay($info['mday']);
        $this->setHour($info['hours']);
        $this->setMinute($info['minutes']);
        $this->setSecond($info['seconds']);
        $this->setMillisecond(Integer::asWrapper($this->timestamp)->subNumber(0,3));
    }

    /**
     * Calculates the timestamp from the date
     */
    private function calculateTimestamp(){
        $this->timestamp = mktime($this->hour, $this->minute, $this->second, $this->month, $this->day, $this->year) * 1000 + $this->millisecond;
        $this->newTime = false;
    }

    /**
     *
     * @param Date $when
     * @return boolean
     */
    public function before(Date $when) {
        return $when->after($this);
    }

    /**
     *
     * @param Date $when
     * @return boolean
     */
    public function after(Date $when) {
        return $this->getTime() > $when->getTime();
    }

    /**
     *
     * @return integer
     */
    public function getYear() {
        return $this->year;
    }

    /**
     *
     * @param integer $year
     * @return blaze\util\Date
     */
    public function setYear($year) {
        $this->year = Integer::asNative($year);
        if($this->year < 0)
            $this->year = 0;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     *
     * @param integer $month
     * @return blaze\util\Date
     */
    public function setMonth($month) {
        $this->month = Integer::asNative($month);
        if($this->month < 1)
            $this->month = 1;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getDay() {
        return $this->day;
    }

    /**
     *
     * @param integer $day
     * @return blaze\util\Date
     */
    public function setDay($day) {
        $this->day = Integer::asNative($day);
        if($this->day < 1)
            $this->day = 1;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     *
     * @param integer $hour
     * @return blaze\util\Date
     */
    public function setHour($hour) {
        $this->hour = Integer::asNative($hour);
        if($this->hour < 0)
            $this->hour = 0;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getMinute() {
        return $this->minute;
    }

    /**
     *
     * @param integer $minute
     * @return blaze\util\Date
     */
    public function setMinute($minute) {
        $this->minute = Integer::asNative($minute);
        if($this->minute < 0)
            $this->minute = 0;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getSecond() {
        return $this->second;
    }

    /**
     *
     * @param integer $second
     * @return blaze\util\Date
     */
    public function setSecond($second) {
        $this->second = Integer::asNative($second);
        if($this->second < 0)
            $this->second = 0;
        $this->newTime = true;
        return $this;
    }
    
    /**
     *
     * @return integer
     */
    public function getMillisecond() {
        return $this->millisecond;
    }

    /**
     *
     * @param integer $millisecond
     * @return blaze\util\Date
     */
    public function setMillisecond($millisecond) {
        $this->millisecond = Integer::asNative($millisecond);
        if($this->millisecond < 0)
            $this->millisecond = 0;
        $this->newTime = true;
        return $this;
    }

    /**
     *
     * @return long
     */
    public function getTime() {
        if($this->newTime)
            $this->calculateTimestamp();
        return $this->timestamp;
    }

    /**
     * @param long $timestamp
     * @return blaze\util\Date
     */
    public function setTime($timestamp) {
        $this->timestamp = Long::asNative($timestamp);
        $this->calculateDate();
        return $this;
    }

    /**
     *
     * @return long
     */
    public function getUnixTime() {
        return (int)($this->getTime() / 1000);
    }

    /**
     * @param long $timestamp
     * @return blaze\util\Date
     */
    public function setUnixTime($timestamp) {
        return $this->setTime(Long::asNative($timestamp) * 1000);
    }

    /**
     *
     * @return blaze\util\TimeZone
     */
    public function getTimeZone() {
        return $this->timeZone;
    }

    /**
     *
     * @param blaze\util\TimeZone $timezone
     * @return blaze\util\Date
     */
    public function setTimeZone($timeZone) {
        if($timeZone == null)
            $this->timeZone = TimeZone::getDefault();
        else
            $this->timeZone = $timeZone;
        return $this;
    }

    public function __toString(){
        return $this->day.'.'.$this->month.'.'.$this->year.' '.$this->hour.':'.$this->minute.':'.$this->second.','.$this->millisecond;
    }
}

?>
