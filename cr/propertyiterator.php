<?php
/**
 * Allows easy iteration through a list of {@link Property}s
 * with {@link nextProperty()} as well as a {@link skip()} method.
 *
 * @package phpContentRepository
 */
class jr_cr_propertyiterator implements phpCR_PropertyIterator{
    protected $JRpropertyiterator;
    
    function __construct($JRpropertyiterator) {
        $this->JRpropertyiterator = $JRpropertyiterator;
    }
    
   /**
    * Returns the next {@link Property} in the iteration.
    *
    * @return the next {@link Property} in the iteration.
    * @throws {@link NoSuchElementException}
    *   If iteration has no more {@link Property}s.
    */
    public function nextProperty() {
        try {
            $p = $this->JRpropertyiterator->nextProperty();
        } catch (JavaException $e) {
            throw new phpCR_NoSuchElementException($e->getMessage());
        }
        return new jr_cr_property($p->getParent(), $p);
    }
    
    /**
     *
     * @return int
     * @see phpCR_RangeIterator::getPosition()
     */
    public function getPosition() {
        return $this->JRpropertyiterator->getPosition();
    }
    
    /**
     *
     * @return int
     * @see phpCR_RangeIterator::getSize()
     */
    public function getSize() {
        return $this->JRpropertyiterator->getSize();
    }
    
    /**
     *
     * @param int The non-negative number of elements to skip
     * @throws {@link NoSuchElementException} If skipped past the last element in the iterator.
     * @see phpCR_RangeIterator::skip()
     */
    public  function skip($skipNum) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @see Iterator::current()
     */
    public  function current() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @see Iterator::key()
     */
    public  function key() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @see Iterator::next()
     */
    public  function next() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @see Iterator::rewind()
     */
    public  function rewind() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @see Iterator::valid()
     */
    public  function valid() {
        //TODO - Insert your code here
    }
}
