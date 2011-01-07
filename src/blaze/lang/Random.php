<?php

namespace blaze\lang;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Random
 *
 * @author  Oliver Kotzina
 * @todo    Extend, http://commons.apache.org/lang/api-2.4/org/apache/commons/lang/RandomStringUtils.html
 */
class Random {

    public function __construct() {
        
    }

    // Generates the next pseudorandom number.
    protected function next() {
        return mt_rand();
    }

    //Returns the next pseudorandom, uniformly distributed boolean value from this random number generator's sequence.
    public function nextBoolean() {
        return ($this->next() % 2) == 0;
    }

    // Generates random bytes and places them into a user-supplied byte array.
    public function nextBytes() {
        $value = '';
        for ($i = 0; $i < 8; $i++) {
            if ($this->nextBoolean()) {
                $value = $value . '1';
            } else {
                $value = $value . '0';
            }
        }
        return new \blaze\lang\Byte($value);
    }

    /// Returns the next pseudorandom, uniformly distributed double value between 0.0 and 1.0 from this random number generator's sequence.
    public function nextDouble() {
        $double = ((double) $this->next() . '.' . $this->next());
        return new Double($double);
    }

// Returns the next pseudorandom, uniformly distributed float value between 0.0 and 1.0 from this random number generator's sequence.
    public function nextFloat() {
        $double = ((double) $this->next() . '.' . $this->next());
        return new Float($double);
    }

    // Returns the next pseudorandom, Gaussian ("normally") distributed double value with mean 0.0 and standard deviation 1.0 from this random number generator's sequence.
    public function nextGaussian() {
        throw new \blaze\lang\NotYetImplenetedException('Gaussian');
    }

    //Returns the next pseudorandom, uniformly distributed int value from this random number generator's sequence.
    public function nextInt($n = null) {
        if ($n != null) {
            return new Integer(mt_rand(0, $n));
        }
        return new Integer($this->next());
    }

    // Returns a pseudorandom, uniformly distributed int value between 0 (inclusive) and the specified value (exclusive), drawn from this random number generator's sequence.
    // Returns the next pseudorandom, uniformly distributed long value from this random number generator's sequence.
    public function nextLong() {
        return new \blaze\lang\Long($this->next());
    }

}

?>
