<?php

namespace blaze\ds\meta;

/**
 * This class represents a sequence object which can be dropped, changed and data
 * can be retrieved.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface SequenceMetaData {

    /**
     * Returns the parent schema object.
     *
     * @return blaze\ds\meta\SchemaMetaData The schema object.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchema();

    /**
     * Drops the sequence.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of the sequence.
     *
     * @return blaze\lang\String The name of the sequence
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequenceName();

    /**
     * Sets the name of the sequence.
     *
     * @param string|\blaze\lang\String $sequenceName The name of the sequence
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSequenceName($sequenceName);

    /**
     * Returns the native data type of the sequence.
     *
     * @return blaze\lang\String The native data type.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequenceNativeType();

    /**
     * Sets the native data type of the sequence.
     *
     * @param string|\blaze\lang\String $nativeType The native data type.
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSequenceNativeType($nativeType);

    /**
     * Returns the class data type of the sequence.
     *
     * @return blaze\lang\String The class data type.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSequenceClassType();

    /**
     * Sets the class data type of the sequence.
     *
     * @param string|\blaze\lang\String $classType The class data type.
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setSequenceClassType($classType);

    /**
     * Returns the precision of the sequence.
     *
     * @return int The precision
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPrecision();

    /**
     * Sets the precision of the sequence.
     *
     * @param int $precision The precision
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setPrecision($precision);

    /**
     * Returns the current value of the sequence.
     *
     * @return int The current value of the sequence.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getCurrentValue();

    /**
     * Sets the current value of the sequence.
     *
     * @param int $currentValue The current value of the sequence.
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setCurrentValue($currentValue);

    /**
     * Returns the next value of the sequence.
     *
     * @return int The next value of the sequence.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function nextValue();

    /**
     * Returns the increment value of the sequence.
     *
     * @return int The increment value.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getIncrementValue();

    /**
     * Sets the increment value of the sequence.
     *
     * @param int $incrementValue The increment value.
     * @return \blaze\ds\meta\SequenceMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setIncrementValue($incrementValue);
}

?>
