<?php
class jr_cr_binary implements PHPCR_BinaryInterface {
    protected $JRbinary;
    protected $isStream = null;

    public function __construct($JRbinary) {
        $this->JRbinary = $JRbinary;
    }


    /**
    * Returns a stream representation of this value.
    * Each call to getStream() returns a new stream.
    * The API consumer is responsible for calling close() on the returned
    * stream.
    *
    * @return resource A stream representation of this value.
    * @throws BadMethodCallException if dispose() has already been called on this Binary
    * @throws PHPCR_RepositoryException if an error occurs.
    * @api
    */
    public function getStream() {
        //pull stream into local file and return handle to that file
        $s = $this->JRbinary->getStream();
        $bytes = '';
        while (($b = $s->read()) != -1) $bytes .= pack('c',$b);
        $f = tmpfile();
        fwrite($f, $bytes);
        fseek($f,0);
        return $f;
    }

    /**
    * Reads successive bytes from the specified position in this Binary into
    * the passed string until the end of the Binary is encountered.
    *
    * @param string $bytes the buffer into which the data is read.
    * @param integer $position the position in this Binary from which to start reading bytes.
    * @return integer the number of bytes read into the buffer
    * @throws RuntimeException if an I/O error occurs.
    * @throws InvalidArgumentException if offset is negative.
    * @throws BadMethodCallException if dispose() has already been called on this Binary
    * @throws PHPCR_RepositoryException if another error occurs.
    * @api
    */
    public function read(&$bytes, $position) {
        /* note: php array is mapped to java HashMap by the zend bridge.
         * found this hack at http://php-java-bridge.sourceforge.net/pjb/FAQ.html
         * (note this is not about zend javabridge, but the problem is the same)
         */

        $s = $this->JRbinary->getStream();
        $s->skip($position);
        $buffer = '';
        $c = 0;

        while (($b = $s->read()) != -1) {
            $buffer .= pack('c',$b);
            $c++; //FIXME: in java, the bytes array has a fixed size, telling how much to read.
        }

        $bytes = $buffer;
        return $c;
    }

    /**
    * Returns the size of this Binary value in bytes.
    *
    * @return integer the size of this value in bytes.
    * @throws BadMethodCallException if dispose() has already been called on this Binary
    * @throws PHPCR_RepositoryException if an error occurs.
    * @api
    */
    public function getSize() {
        return $this->JRbinary->getSize();
    }

    /**
    * Releases all resources associated with this Binary object and informs the
    * repository that these resources may now be reclaimed.
    * An application should call this method when it is finished with the
    * Binary object.
    *
    * @return void
    * @api
    */
    public function dispose() {
        $this->JRbinary->dispose();
    }

}
