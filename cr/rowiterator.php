<?php


class jr_cr_rowiterator extends jr_cr_rangeiterator implements PHPCR_Query_RowIteratorInterface {

    protected $session = null;

    function __construct($jrrowiterator,$session) {
        parent::__construct($jrrowiterator);
        $this->session = $session;
    }

    protected function createElement($r) {
        return new jr_cr_row($r);
    }

    /**
     *
     * @return object A {@link Row} object
     * @throws {@link NoSuchElementException} If iteration has no more {@link Row}s.
     * @see PHPCR_Query_RowIteratorInterface::nextRow()
     */
    public function nextRow() {
        $this->next();
        if ($this->valid()) {
            return $this->current();
        } else {
            throw new OutOfBoundsException('nextRow called after end of iterator');
        }
    }
    
    
    /**
     * Returns true if the iteration has more elements.
     *
     * This is an alias of valid().
     *
     * @return boolean
     */
    public function hasNext() {
        //TODO: Insert Code
    }
    
    /**
     * Removes from the underlying collection the last element returned by the iterator.
     * This method can be called only once per call to next. The behavior of an iterator
     * is unspecified if the underlying collection is modified while the iteration is in
     * progress in any way other than by calling this method.
     *
     * @return void
     * @throws IllegalStateException if the next method has not yet been called, or the remove method has already been called after the last call to the next method.
     */
    public function remove() {
        //TODO: Insert Code
    }
    
    /**
     * Append a new element to the iteration
     *
     * @param mixed $element
     * @return void
     */
    public function append($element) {
        //TODO: Insert Code
    }
}
