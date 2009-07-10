<?php
// $Id$
/**
 * This file contains {@link NodeDef} which is part of the PHP Content Repository
 * (PHPCR), a derivative of the Java Content Repository JSR-170,  and is
 * licensed under the Apache License, Version 2.0.
 *
 * This file is based on the code created for
 * {@link http://www.jcp.org/en/jsr/detail?id=170 JSR-170}
 *
 * @author Travis Swicegood <development@domain51.com>
 * @copyright PHP Code Copyright &copy; 2004-2005, Domain51, United States
 * @copyright Original Java and Documentation
 *    Copyright &copy; 2002-2004, Day Management AG, Switerland
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *    Version 2.0
 * @package phpContentRepository
 * @package NodeTypes
 */

/**
 * An iterator for {@link NodeType} objects.
 *
 * @package phpContentRepository
 * @package NodeTypes
 */
class jr_cr_nodetypeiterator extends jr_cr_rangeiterator implements PHPCR_NodeTypeIteratorInterface {

    public function __construct($JRnodetypeiterator) {
        parent::__construct($JRnodetypeiterator);
    }

    protected function createElement($t) {
        return new jr_cr_nodetype($t);
    }

    /**
     * Returns the next {@link NodeType} in the iteration.
     *
     * @return object A {@link NodeType} object.
     * @throws {@link NoSuchElementException} If iteration has no more {@link NodeType}s.
     */
    public function nextNodeType() {
        $this->next();
        if ($this->valid()) {
            return $this->current();
        } else {
            throw new PHPCR_NoSuchElementException('nextNodeType called after end of iterator');
        }
    }
}
