<?php

class jr_cr_nodeiterator extends jr_cr_rangeiterator implements phpCR_NodeIterator {

    protected $session = null;

    function __construct($jrnodeiterator,$session) {
        parent::__construct($jrnodeiterator);
        $this->session = $session;
    }

    protected function createElement($n) {
        return new jr_cr_node($this->session,$n);
    }

    /**
     * @return object
     * @throws {@link NoSuchElementException} If iteration has no more {@link Node}s.
     * @see phpCR_NodeIterator::nextNode()
     */
    public function nextNode() {
        $this->next();
        if ($this->valid()) {
            return $this->current();
        } else {
            throw new phpCR_NoSuchElementException('nextNode called after end of iterator');
        }
    }
}

