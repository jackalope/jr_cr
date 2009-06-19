<?php
class jr_cr_value implements phpCR_Value {
    protected $JRvalue;
    
    public function __construct($JRvalue) {
        $this->JRvalue = $JRvalue;
    }
    
    /**
     * Returns a string representation of this value.
     *
     * @return string
     *
     * @throws {@link ValueFormatException}
     *    If conversion to a string is not possible.
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called on this 
     *    {@link Value} instance.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getString() {
        //TODO: Insert code
    }
    
    
    /**
     * Returns the stream resource of this value.
     *
     * <b>PHP Note</b>: As of PHP 5.0.x, there is no standard OO PHP stream
     * interface, thus this method should be expected to return a valid file
     * handle that can be utilized via fopen()/fread()/fclose().
     *
     * A default memory stream handler is available in {@link ValueStream}.
     *
     * @return resource
     *     A valid PHP stream resource.
     *
     * @throws {@link IllegalStateException}
     *    If non stream <i>get*()</i> has been previous called on this
     *    {@link Value} object.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getStream() {
        //TODO: Insert code
    }
    
    
    /**
     * Returns the int representation of this value.
     *
     * This method should always return exactly what {@link getInt()} does.
     * It has been left as a requirement to satisfy JCR compliance.
     *
     * @return int
     * @see getInt()
     */
    public function getLong() {
        //TODO: Insert code
    }
    
    /**
     * Returns the int representation of this value.
     *
     * @return int
     *
     * @throws {@link ValueFormatException}
     *    If conversion to a int is not possible.
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called on this 
     *    {@link Value} instance.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getInt() {
        //TODO: Insert code
    }
    

    /**
     * Returns the float/double representation of this value.
     *
     * This method should always return exactly what {@link getFloat()} does.
     * It has been left as a requirement to satisfy JCR compliance.
     *
     * @see getFloat()
     * @return float
     */
    public function getDouble() {
        //TODO: Insert code
    }
    
    /**
     * Returns the float/double representation of this value.
     *
     * This method should always be an alias of {@link getFloat()}.
     *
     * @see getFloat()
     * @return float
     *
     * @throws {@link ValueFormatException}
     *    If conversion to a float is not possible.
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called on this 
     *    {@link Value} instance.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getFloat() {
        //TODO: Insert code
    }
    
    
    /**
     * Returns the timestamp string of this value.
     *
     * <b>PHP Note</b>: PHP does not have a default Calendar object.  This 
     * method has been adjusted to return a string representing a valid
     * timestamp.
     *
     * Future version of phpCR may implement a simple date/time object to
     * handle returning a mock of Java's Calendar object.
     *
     * Given the fluid nature of this method, it is advisable to throw a
     * {@link ValidFormatException} on all {@link Value}s except those which
     * must be returned as dates until a definitive return value is determined.
     *
     * @return string
     *
     * @throws {@link ValueFormatException}
     *    If conversion to a timestamp/date is not possible.
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called on this 
     *    {@link Value} instance.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getDate() {
        //TODO: Insert code
    }
    
    
    /**
     * Returns the boolean representation of this value.
     *
     * @return bool
     *
     * @throws {@link ValueFormatException}
     *    If conversion to a boolean is not possible.
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called on this 
     *    {@link Value} instance.
     * @throws {@link RepositoryException}
     *    If another error occurs.
     */
    public function getBoolean() {
        //TODO: Insert code
    }
    
    
    /**
     * Returns the type of this Value.
     * One of:
     * <ul>
     *    <li>{@link PropertyType::STRING}</li>
     *    <li>{@link PropertyType::DATE}</li>
     *    <li>{@link PropertyType::BINARY}</li>
     *    <li>{@link PropertyType::DOUBLE}</li>
     *    <li>{@link PropertyType::LONG}</li>
     *    <li>{@link PropertyType::BOOLEAN}</li>
     *    <li>{@link PropertyType::NAME}</li>
     *    <li>{@link PropertyType::PATH}</li>
     *    <li>{@link PropertyType::REFERENCE}</li>
     * </ul>
     *
     * The type returned is that which was set at property creation.
     *
     * @see PropertyType
     * @return int
     */
    public function getType() {
        //TODO: Insert code
    }
}

