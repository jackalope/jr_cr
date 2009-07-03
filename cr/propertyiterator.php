<?php
/**
 * Allows easy iteration through a list of {@link Property}s
 * with {@link nextProperty()} as well as a {@link skip()} method.
 *
 * @package phpContentRepository
 */
class jr_cr_propertyiterator extends jr_cr_rangeiterator implements phpCR_PropertyIterator{
    protected $parentNode = null;
    
    function __construct($JRpropertyiterator, $parentNode) {
        $this->parentNode = $parentNode;
        parent::__construct($JRpropertyiterator);
    }
    
    protected function createElement($property) {
        return new jr_cr_property($this->parentNode, $property);
    }
    
    /**
     * Returns the next {@link Property} in the iteration.
     *
     * @return the next {@link Property} in the iteration.
     * @throws {@link NoSuchElementException} If iteration has no more {@link Property}s.
     */
    public function nextProperty() {
        $this->next();
        if ($this->valid()) {
            return $this->current();
        } else {
            throw new phpCR_NoSuchElementException('nextVersion called after end of iterator');
        }
    }
}
