<?php
namespace blaze\util;
use blaze\lang\Object,
    blaze\lang\Integer;

/**
 * Description of Date
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class Date extends Object {
    
    /**
     *
     * @var int
     */
    private $year = 0;
    /**
     *
     * @var int
     */
    private $month = 0;
    /**
     *
     * @var int
     */
    private $day = 0;
    /**
     *
     * @var int
     */
    private $hour = 0;
    /**
     *
     * @var int
     */
    private $minute = 0;
    /**
     *
     * @var int
     */
    private $second = 0;
    /**
     *
     * @var int
     */
    private $millisecond = 0;
    /**
     *
     * @var int
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
     * @return blaze\util\Date
     */
    public static function now(){
        return self::fromUnixTime(time());
    }

    /**
     * Generates a Date object with a timestamp and a timezone.
     * @param long $timestamp 
     */
    public static function fromTime($timestamp, TimeZone $timeZone = null){
        $d = new self();
        $d->setTimeZone($timeZone);
        $d->setTime(\blaze\lang\Long::asNative($timestamp));
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
     * @return int
     */
    public function getYear() {
        return $this->year;
    }

    /**
     *
     * @param int $year
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
     * @return int
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     *
     * @param int $month
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
     * @return int
     */
    public function getDay() {
        return $this->day;
    }

    /**
     *
     * @param int $day
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
     * @return int
     */
    public function getHour() {
        return $this->hour;
    }

    /**
     *
     * @param int $hour
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
     * @return int
     */
    public function getMinute() {
        return $this->minute;
    }

    /**
     *
     * @param int $minute
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
     * @return int
     */
    public function getSecond() {
        return $this->second;
    }

    /**
     *
     * @param int $second
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
     * @return int
     */
    public function getMillisecond() {
        return $this->millisecond;
    }

    /**
     *
     * @param int $millisecond
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
        $this->timestamp = \blaze\lang\Long::asNative($timestamp);
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
        return $this->setTime(\blaze\lang\Long::asNative($timestamp) * 1000);
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

    public function toString(){
        return $this->day.'.'.$this->month.'.'.$this->year.' '.($this->hour < 10 ? '0'.$this->hour : $this->hour).':'.($this->minute < 10 ? '0'.$this->minute : $this->minute).':'.($this->second < 10 ? '0'.$this->second : $this->second);
    }
}

?>
