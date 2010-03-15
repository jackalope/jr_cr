<?php
class jr_cr_query implements PHPCR_Query_QueryInterface {
    protected $JRquery = null;
    /**
     *
     */
    function __construct($jrquery,$session) {
        $this->session = $session;
        $this->JRquery = $jrquery;
    }

    /**
     *
     * @return jr_cr_queryresult
     * A {@link QueryResult} object
     * @throws {@link RepositoryException}
     * If an error occurs
     * @see PHPCR_Query::execute()
     */
    public function execute() {
        try {
            return new jr_cr_queryresult($this->JRquery->execute(),$this->session);
        } catch(JavaException $e) {
            $str = split("\n", $e->getMessage(), 1);
            if (strstr($str[0], 'InvalidQueryException')) {
                throw new PHPCR_Query_InvalidQueryException($e->getMessage());
            } elseif (strstr($str[0], 'RepositoryException')) {
                throw new PHPCR_RepositoryException($e->getMessage());
            } else {
                throw $e;
            }
        }
    }

    /**
     *
     * @see QueryLanguage
     * @return int
     * @see PHPCR_Query::getLanguage()
     */
    public function getLanguage() {
        return $this->JRquery->getLanguage();
    }

    /*public function setLimit($limit) {
       $this->JRquery->setLimit($limit);
    }*/

    /**
     *
     * @return string
     * @see PHPCR_Query::getStatement()
     */
    public function getStatement() {
        return $this->JRquery->getStatement();
    }

    /**
     *
     * @return string
     * Path of the {@link Node} representing this query.
     * @throws {@link ItemNotFoundException}
     * If this query is not a stored query.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see PHPCR_Query::getStoredQueryPath()
     */
    public function getStoredQueryPath() {
        try {
            return $this->JRquery->getStoredQueryPath();
        } catch(JavaException $e) {
            $str = split("\n", $e->getMessage(), 1);
            if (strstr($str[0], 'ItemNotFoundException')) {
                throw new PHPCR_ItemNotFoundException($e->getMessage());
            } elseif (strstr($str[0], 'RepositoryException')) {
                throw new PHPCR_RepositoryException($e->getMessage());
            } else {
                throw $e;
            }
        }
    }

    /**
     *
     * @param string
     * The absolute path to store this at
     * @return object
     * A {@link Node} object
     * @throws {@link ItemExistsException}
     * If an item at the specified path already exists, same-name siblings
     * are not allowed and this implementation performs this validation
     * immediately instead of waiting until {@link Item::save()}.
     * @throws {@link PathNotFoundException}
     * If the specified path implies intermediary {@link Node}s that do not
     * exist or the last element of <i>$relPath</i> has an index, and
     * this implementation performs this validation immediately instead of
     * waiting until {@link Item::save()}.
     * @throws {@link ConstraintViolationException}
     * If a node type or implementation-specific constraint is violated or
     * if an attempt is made to add a node as the child of a property and
     * this implementation performs this validation immediately instead of
     * waiting until {@link Item::save()}.
     * @throws {@link VersionException}
     * If the node to which the new child is being added is versionable and
     * checked-in or is non-versionable but its nearest versionable ancestor
     * is checked-in and this implementation performs this validation
     * immediately instead of waiting until {@link Item::save()}.
     * @throws {@link LockException}
     * If a lock prevents the addition of the node and this implementation
     * performs this validation immediately instead of waiting until
     * {@link Item::save()}.
     * @throws {@link UnsupportedRepositoryOperationException}
     * In a level 1 implementation.
     * @throws {@link RepositoryException}
     * If another error occurs or if the <i>$relPath</i> provided has
     * an index on its final element.
     * @see PHPCR_Query::storeAsNode()
     */
    public function storeAsNode($absPath) {
        try {
            return $this->JRquery->storeAsNode($absPath);
        } catch(JavaException $e) {
            $str = split("\n", $e->getMessage(), 1);
            if (strstr($str[0], 'ItemExistsException')) {
                throw new PHPCR_ItemExistsException($e->getMessage());
            } elseif (strstr($str[0], 'PathNotFoundException')) {
                throw new PHPCR_PathNotFoundException($e->getMessage());
            } elseif (strstr($str[0], 'ConstraintViolationException')) {
                throw new PHPCR_NodeType_ConstraintViolationException($e->getMessage());
            } elseif (strstr($str[0], 'VersionException')) {
                throw new PHPCR_VersionException($e->getMessage());
            } elseif (strstr($str[0], 'LockException')) {
                throw new PHPCR_LockException($e->getMessage());
            } elseif (strstr($str[0], 'UnsupportedRepositoryOperationException')) {
                throw new PHPCR_UnsupportedRepositoryOperationException($e->getMessage());
            } elseif (strstr($str[0], 'RepositoryException')) {
                throw new PHPCR_RepositoryException($e->getMessage());
            } else {
                throw $e;
            }
        }
    }

    public function bindValue($varName, PHPCR_ValueInterface $value) {
        $this->JRquery->bindValue($varName, $value->JRvalue);
    }

    public function getBindVariableNames() {
        return $this->JRquery->getBindVariableNames();
    }

    /**
     * Sets the maximum size of the result set to limit.
     *
     * @param integer $limit
     * @return void
     */
    public function setLimit($limit) {
        //TODO - Insert your code here
    }

    /**
     * Sets the start offset of the result set to offset.
     *
     * @param integer $offset
     * @return void
     */
    public function setOffset($offset) {
        //TODO - Insert your code here
    }
}
