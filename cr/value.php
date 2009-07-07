<?php
class jr_cr_value implements phpCR_Value {
    protected $JRvalue;
    protected $isStream = null;

    public function __construct($JRvalue) {
        $this->JRvalue = $JRvalue;
    }

    /**
     * Checks if this is a stream or not. If it's not casted yet it will be set to the state.
     *
     * @throws {@link IllegalStateException}
     *    If {@link getStream()} has previously been called and it's a non stream Value.
     *    If {@link get*()} has previously been called and it's a stream Value.
     */
    protected function checkState($stream) {
        if (null === $this->isStream) {
            $this->isStream = $stream;
        } else {
            if ($this->isStream !== $stream) {
                if (true === $stream) {
                    $msg = 'A non stream get method has already been called on this Value instance.';
                } else {
                    $msg = 'A getStream has already been called on this Value instance.';
                }
                throw new phpCR_IllegalStateException($msg);
            }
        }
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
        $this->checkState(false);
        try {
            return $this->JRvalue->getString();
        } catch(JavaException $e) {
            $this->throwExceptionFromJava($e);
        }
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
        $this->checkState(true);
        //TODO: Insert code
    }

    /**
     * Returns a number of the value. Which format can be given as param.
     */
    public function getNumber($float = false) {
        $this->checkState(false);
        try {
            if (true === $float) {
                $num = $this->JRvalue->getDouble();
            } else {
                $num = $this->JRvalue->getLong();
            }
        } catch (JavaException $e) {
            $this->throwExceptionFromJava($e);
        }

        if (true === $float) {
            return (float) $num;
        } else {
            return (int)  $num;
        }
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
        return $this->getInt();
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
        return $this->getNumber();
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
        return $this->getFloat();
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
        return $this->getNumber(true);
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
        $this->checkState(false);
        try {
            $date = $this->JRvalue->getDate();
            $date = date_create($date->getTime()->toString());
        } catch (JavaException $e) {
            $this->throwExceptionFromJava($e);
        }

        if (! $date instanceOf DateTime) {
            throw new phpCR_ValueFormatException('Could not get Date');
        }

        return $date;
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
        $this->checkState(false);
        try {
            $bool = $this->JRvalue->getBoolean();
        } catch (JavaException $e) {
            $this->throwExceptionFromJava($e);
        }

        return $bool;
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
        $this->checkState(false);
        //TODO: Insert code
    }

    protected function throwExceptionFromJava($e) {
        $str = split("\n", $e->getMessage(), 2);
        if (false !== strpos($str[0], 'ValueFormatException')) {
            throw new phpCR_ValueFormatException($e->getMessage());
        } else {
            throw new phpCR_RepositoryException($e->getMessage());
        }
    }
}

