<?php
class jr_cr_node implements phpCR_Node {
    protected $uuid = null;
    protected $name = '';
    protected $nodeType = null;
    protected $parentNode = null;
    protected $properties = array();
    protected $propertiesLoaded = false;
    /**
     * Enter description here...
     *
     * @var jr_cr_session
     */
    protected $session = null;
    public $JRnode = null; //querymanager needs access to the java instance
    protected $new = false;
    
    protected $modified = false;
    protected $path = '';
    /**
     *
     */
    function __construct($session, $JRnode) {
        $this->session = $session;
        $this->JRnode = $JRnode;
    }
    
    /**
     *
     * @param string
     * The mixin name
     * @throws {@link NoSuchNodeTypeException}
     * If the specified <i>mixinName</i> is not recognized and this
     * implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link ConstraintViolationException}
     * If the specified mixin node type is prevented from being assigned.
     * @throws {@link VersionException}
     * If this node is versionable and checked-in or is non-versionable but
     * its nearest versionable ancestor is checked-in and this
     * implementation performs this validation immediately instead of
     * waiting until {@link save()}..
     * @throws {@link LockException}
     * If a lock prevents the addition of the mixin and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::addMixin()
     */
    public function addMixin($mixinName) {
        $this->JRnode->addMixin($mixinName);
    }
    
    /**
     *
     * @param string
     * The path of the new {@link Node} to be created.
     * @param string|null
     * The name of the primary {@link NodeType} of the new {@link Node}.
     * (Optional)
     * @return jr_cr_node
     * A {@link Node} object
     * @throws {@link ItemExistsException}
     * If an item at the specified path already exists, same-name siblings
     * are not allowed and this implementation performs this validation
     * immediately instead of waiting until {@link save()}.
     * @throws {@link PathNotFoundException}
     * If the specified path implies intermediary {@link Node}s that do not
     * exist or the last element of <i>$relPath</i> has an index, and
     * this implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link NoSuchNodeTypeException}
     * If the specified node type is not recognized and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link ConstraintViolationException}
     * If a node type or implementation-specific constraint is violated or
     * if an attempt is made to add a node as the child of a property and
     * this implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link VersionException}
     * If the node to which the new child is being added is versionable and
     * checked-in or is non-versionable but its nearest versionable ancestor
     * is checked-in and this implementation performs this validation
     * immediately instead of waiting until {@link save()}.
     * @throws {@link LockException}
     * If a lock prevents the addition of the node and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link RepositoryException}
     * If the last element of <i>$relPath</i> has an index or if
     * another error occurs.
     * @see phpCR_Node::addNode()
     */
    public function addNode($relPath, $primaryNodeTypeName = null) {
        try {
            if ($node = $this->getNode($relPath)) {
                // FIXME, should throw an exception
                return $node;
            }
        } catch (Exception $e) {
            
        }
        if (substr($relPath, 0, 1) == '/') {
            $node = $this->session->getRootNode();
            $relPath = substr($relPath, 1);
        } else {
            if (! $relPath || $relPath == '') {
                $relPath = ".";
                $node = $this;
            } else {
                $node = $this;
            }
        }
        
        if (! $primaryNodeTypeName) {
            $jrnode = $node->JRnode->addNode($relPath);
        } else {
            $jrnode = $node->JRnode->addNode($relPath, $primaryNodeTypeName);
        }
        $node = new jr_cr_node($this->session, $jrnode);
        $node->setNew(true);
        $node->setModified(true);
        return $node;
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param $string
     * The name of the mixin to be tested.
     * @return boolean
     * @throws {@link NoSuchNodeTypeException}
     * If the specified mixin node type name is not recognized.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::canAddMixin()
     */
    public function canAddMixin($mixinName) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param version a version referred to by this node's
     * <i>jcr:mergeFailed</i> property.
     * @throws {@link VersionException}
     * If the version specified is not among those referenced in this node's
     * <i>jcr:mergeFailed</i> or if this node is currently checked-in.
     * @throws {@link InvalidItemStateException}
     * If there are unsaved changes pending on this node.
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::cancelMerge()
     */
    public function cancelMerge(phpCR_Version $version) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return object
     * A {@link Version} object
     * @throws {@link VersionException}
     * If jcr:predecessors does not contain at least one value or if
     * a child item of this node has an <i>OnParentVersion</i> status
     * of <i>ABORT</i>.  This includes the case where an unresolved
     * merge failure exists on this node, as indicated by the presence of a
     * <i>jcr:mergeFailed</i> property.
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link InvalidItemStateException}
     * If unsaved changes exist on this node.
     * @throws {@link LockException}
     * If a lock prevents the checkin.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::checkin()
     */
    public function checkin() {
        $this->JRnode->checkin();
    }
    
    /**
     *
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link LockException}
     * If a lock prevents the checkout.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::checkout()
     */
    public function checkout() {
        $this->JRnode->checkout();
    }
    
    /**
     *
     * @param object
     * A {@link Version} object
     * A version referred to by this node's <i>jcr:mergeFailed</i>
     * property.
     * @throws {@link VersionException}
     * If the version specifed is not among those referenced in this node's
     * <i>jcr:mergeFailed</i> or if this node is currently checked-in.
     * @throws {@link InvalidItemStateException}
     * If there are unsaved changes pending on this node.
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::doneMerge()
     */
    public function doneMerge(phpCR_Version $version) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return object
     * A {@link Version} object
     * @throws UnsupportedRepositoryOperationException
     * If this node is not versionable.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getBaseVersion()
     */
    public function getBaseVersion() {
        return new jr_cr_node($this->session,$this->JRnode->getBaseVersion());
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * @return string
     * @throws {@link ItemNotFoundException}
     * If no corresponding node is found.
     * @throws {@link NoSuchWorkspaceException}
     * If the workspace is unknown.
     * @throws {@link AccessDeniedException}
     * If the current <i>session</i> has insufficent rights to perform this operation.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getCorrespondingNodePath()
     */
    public function getCorrespondingNodePath($workspaceName) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return object
     * A {@link NodeDefinition} object.
     * @see NodeType::getChildNodeDefinitions()
     * @see phpCR_Node::getDefinition()
     */
    public function getDefinition() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return int
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Node::getIndex()
     */
    public function getIndex() {
        try {
            return $this->JRnode->getIndex();
        } catch (JavaException $e) {
            throw new phpCR_ReposiotryException($e->getMessage());
        }
    }
    
    /**
     *
     * @return object
     * A {@link Lock} object
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this implementation does not support locking.
     * @throws {@link LockException}
     * If no lock applies to this node.
     * @throws {@link AccessDeniedException}
     * If the curent session does not have pernmission to get the lock.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getLock()
     */
    public function getLock() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return array
     * An array of NodeType objects.
     * @see phpCR_Node::getMixinNodeTypes()
     */
    public function getMixinNodeTypes() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The relative path of the {@link Node} to retrieve.
     * @return jr_cr_node
     * The {@link Node} at $relPath.
     * @throws {@link PathNotFoundException}
     * If no {@link Node} exists at the  specified path.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getNode()
     */
    public function getNode($relPath) {
        if (substr($relPath, 0, 1) == '/') {
            $node = $this->session->getRootNode();
            $relPath = substr($relPath, 1);
        } else {
            if (! $relPath || $relPath == '') {
                $relPath = ".";
                $node = $this;
            } else {
                $node = $this;
            }
        }
        try {
            
            $jrnode = $node->JRnode->getNode($relPath);
            $node = $node->session->getNodeByPath($jrnode);
            if ($node instanceof jr_cr_node) {
                return $node;
            }
        } catch (Exception $e) {
            throw new phpCR_PathNotFoundException($relPath);
        }
        throw new phpCR_PathNotFoundException($relPath);
    }
    
    //FIXME selber erfunden, needed for query service later
    public function searchNodes($relPath) {
        $pps = $this->session->parsePath($relPath, $this);
        $nodes = array();
        foreach ($pps as $pp) {
            switch ($pp['name']) {
                case '..' :
                    $node = $this->getParent();
                break;
                case '' :
                case '.' :
                    $node = $this;
                break;
                default :
                    $uuid = $this->session->storage->getChildNodeUUID($pp['node'], $pp['name']);
                    $node = $this->session->getNodeByUUID($uuid);
                break;
            }
            $nodes[] = $node;
        }
        return $nodes;
    }
    
    /**
     *
     * @param string
     * A name pattern.
     * @return object
     * A {@link NodeIterator} over all child {@link Node}s of $this
     * {@link Node}.
     * @throws {@link RepositoryException}
     * If an unexpected error occurs.
     * @see phpCR_Node::getNodes()
     */
    public function getNodes($namePattern = null) {
        try {
            if ($namePattern) {
                $jrnodes = $this->JRnode->getNodes($namePattern);
            } else {
                $jrnodes = $this->JRnode->getNodes();
            }
        } catch (JavaException $e) {
            throw new phpCR_RepositoryException($e->getMessage());
        }

        return new jr_cr_nodeiterator($jrnodes, $this->session);
    }
    
    /**
     *
     * @return object
     * The deepest primary child {@link Item} accessible from $this
     * {@link Node} via a chain of primary child {@link Item}s.
     * @throws {@link ItemNotFoundException}
     * If $this {@link Node} does not have a primary child {@link Item}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getPrimaryItem()
     */
    public function getPrimaryItem() {
        try {
            $node = $this->JRnode->getPrimaryItem();
        } catch (JavaException $e) {
            $str = split("\n", $e->getMessage(), 1);
            if (strstr($str[0], 'ItemNotFound')) {
                throw new phpCR_ItemNotFoundException($e->getMessage());
            } elseif (strstr($str[0], 'RepositoryException')) {
                throw new phpCR_RepositoryException($e->getMessage());
            } else {
                throw $e;
            }
        }
        return new jr_cr_node($this->session, $node);
    }
    
    /**
     *
     * @return object
     * A {@link NodeType} object.
     * @see phpCR_Node::getPrimaryNodeType()
     */
    public function getPrimaryNodeType() {
        $md5path = md5($this->getPath());
        $cacheKey = md5("node::getPrimaryNodeType::".$md5path);
        if (!$p = $this->session->cache->load($cacheKey)) {
                $p = $this->JRnode->getPrimaryNodeType()->getName();
                $this->session->cache->save($p,$cacheKey,array($md5path));
        }
        return $p;
    }
    
    /**
     *
     * @return object
     * A {@link PropertyIterator} object
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Node::getProperties()
     */
    public function getProperties($namePattern = '') {
        try {
            if ($namePattern) {
                $jrproperties = $this->JRnode->getProperties($namePattern);
            } else {
                $jrproperties = $this->JRnode->getProperties();
            }
        } catch (JavaException $e) {
            throw new phpCR_RepositoryException($e->getMessage());
        }
        return new jr_cr_propertyiterator($jrproperties, $this);
    }
    
    /**
     *
     * @param string
     * The relative path of the {@link Property} to retrieve.
     * @return jr_cr_property
     * A {@link Property} object
     * @throws {@link PathNotFoundException}
     * If no {@link Property} exists at the specified path.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getProperty()
     */
    public function getProperty($relPath) {
        if (substr($relPath, 0, 1) == '/') {
            $node = $this->session->getRootNode();
            $relPath = substr($relPath, 1);
        } else {
            if (! $relPath || $relPath == '') {
                $relPath = ".";
                $node = $this;
            } else {
                $node = $this;
            }
        }
        
        try {
            $jrnode = $node->JRnode->getProperty($relPath);
        } catch (Exception $e) {
            throw new phpCR_PathNotFoundException($relPath);
        }
        
        $prop = $this->getPropertyFromList($jrnode);
        if ($prop instanceof jr_cr_property) {
            return clone($prop);
        }
        throw new phpCR_PathNotFoundException($relPath);
    }
    
    /**
     *
     * @return object
     * A {@link PropertyIterator} object
     * @throws {@link RepositoryException}
     * If an error occurs
     * @see phpCR_Node::getReferences()
     */
    public function getReferences() {
        $iterator = $this->JRnode->getReferences();
        return new jr_cr_propertyIterator($iterator, $this);
    }
    
    /**
     *
     * @return string
     * The UUID of $this {@link Node}
     * @throws {@link UnsupportedRepositoryOperationException}
     * If $this {@link Node} nonreferenceable.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getUUID()
     */
    public function getUUID() {
        if (empty($this->uuid)) {
            try {
                $this->uuid = $this->JRnode->getUUID();
            } catch (JavaException $e) {
                $str = split("\n", $e->getMessage(), 1);
                if (strstr($str[0], 'UnsupportedRepositoryOperationException')) {
                    throw new phpCR_UnsupportedRepositoryOperationException($e->getMessage());
                } elseif (strstr($str[0], 'RepositoryException')) {
                    throw new phpCR_RepositoryException($e->getMessage());
                } else {
                    throw $e;
                }
            }
        }
        return $this->uuid;
    }
    
    /**
     *
     * @return object
     * A {@link VersionHistory} object
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::getVersionHistory()
     */
    public function getVersionHistory() {
        return new jr_cr_versionhistory($this->JRnode->getVersionHistory(),$this->session);
    }
    
    /**
     *
     * @param string
     * The path of a possible {@link Node}.
     * @return bool
     * TRUE if a {@link Node} exists at relPath;
     * FALSE otherwise.
     * @throws {@link RepositoryException}
     * If an unspecified error occurs.
     * @see phpCR_Node::hasNode()
     */
    public function hasNode($relPath) {
        return $this->JRnode->hasNode($relPath);
    }
    
    /**
     *
     * @return bool
     * TRUE if $this {@link Node} has one or more child
     * {@link Node}s; FALSE otherwise.
     * @throws {@link RepositoryException}
     * If an unspecified error occurs.
     * @see phpCR_Node::hasNodes()
     */
    public function hasNodes() {
        return $this->JRnode->hasNodes();
    }
    
    /**
     *
     * @return bool
     * TRUE if $this {@link Node} has one or more
     * {@link Property}s; FALSE otherwise.
     * @throws {@link RepositoryException}
     * If an unspecified error occurs.
     * @see phpCR_Node::hasProperties()
     */
    public function hasProperties() {
        return $this->JRnode->hasProperties();
     }
     
    /**
     *
     * @param string
     * The path of a possible {@link Property}.
     * @return bool
     * TRUE if a {@link Property} exists at $relPath;
     * FALSE otherwise.
     * @throws {@link RepositoryException}
     * If an unspecified error occurs.
     * @see phpCR_Node::hasProperty()
     */
    public function hasProperty($relPath) {
        try {
            return (bool) $this->JRnode->hasProperty($relPath);
        } catch (JavaException $e) {
            throw new phpCR_RepositoryException($e->getMessage());
        }
    }
    
    /**
     *
     * @return boolean
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Node::holdsLock()
     */
    public function holdsLock() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return bool
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::isCheckedOut()
     */
    public function isCheckedOut() {
        return $this->JRnode->isCheckedOut();
    }
    
    /**
     *
     * @return boolean
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Node::isLocked()
     */
    public function isLocked() {
        //TODO - Insert your code here
    }

    /**
     *
     * @param string
     * The name of a {@link NodeType}.
     * @return bool
     * TRUE if $this {@link Node} is of the specified
     * {@link NodeType} or a subtype of the specified {@link NodeType}; returns
     * FALSE otherwise.
     * @throws {@link RepositoryException}
     * If an unspecified error occurs.
     * @see phpCR_Node::isNodeType()
     */
    public function isNodeType($nodeTypeName) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param boolean
     * @param boolean
     * @return object
     * A {@link Lock} object
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this implementation does not support locking.
     * @throws {@link LockException}
     * If this node is not <i>mix:lockable</i> or this node is already
     * locked or <i>isDeep</i> is <i>true</i> and a descendant
     * node of this node already holds a lock.
     * @throws {@link AccessDeniedException}
     * If this session does not have permission to lock this node.
     * @throws {@link InvalidItemStateException}
     * If this node has pending unsaved changes.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::lock()
     */
    public function lock($isDeep, $isSessionScoped) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The name of the source workspace.
     * @param boolean
     * @return object
     * A {@link NodeIterator} object
     * Iterator over all nodes that received a merge result of "fail" in the
     * course of this operation.
     * @throws {@link MergeException}
     * If <i>$bestEffort</i> is <i>false</i> and a failed merge
     * result is encountered.
     * @throws {@link InvalidItemStateException}
     * If this session (not necessarily this node) has pending unsaved changes.
     * @throws {@link NoSuchWorkspaceException}
     * If <i>srcWorkspace</i> does not exist.
     * @throws {@link AccessDeniedException}
     * If the current session does not have sufficient rights to perform the operation.
     * @throws {@link LockException}
     * If a lock prevents the merge.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::merge()
     */
    public function merge($srcWorkspace, $bestEffort) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The relative path to the child node (that is, name plus possible
     * index) to be moved in the ordering
     * @param string
     * The the relative path to the child node (that is, name plus possible
     * index) before which the node <i>$srcChildRelPath</i> will be
     * placed.
     * @throws {@link UnsupportedRepositoryOperationException}
     * If ordering is not supported.
     * @throws {@link ConstraintViolationException}
     * If an implementation-specific ordering restriction is violated and
     * this implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link ItemNotFoundException}
     * If either parameter is not the relative path of a child node of this
     * node.
     * @throws {@link VersionException}
     * If this node is versionable and checked-in or is non-versionable
     * but its nearest versionable ancestor is checked-in and this
     * implementation performs this validation immediately instead of
     * waiting until {@link save()}..
     * @throws {@link LockException}
     * If a lock prevents the re-ordering and this implementation performs
     * this validation immediately instead of waiting until {@link save()}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::orderBefore()
     */
    public function orderBefore($srcChildRelPath, $destChildRelPath) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The name of the mixin node type to be removed.
     * @throws {@link NoSuchNodeTypeException}
     * If the specified <i>$mixinName</i> is not currently assigned to
     * this node and this implementation performs this validation
     * immediately instead of waiting until {@link save()}.
     * @throws {@link ConstraintViolationException}
     * If the specified mixin node type is prevented from being removed and
     * this implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link VersionException}
     * If this node is versionable and checked-in or is non-versionable but
     * its nearest versionable ancestor is checked-in and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link LockException}
     * If a lock prevents the removal of the mixin and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::removeMixin()
     */
    public function removeMixin($mixinName) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string|{@link Version}
     * @param boolean
     * @param string
     * @todo Update docs to reflect full version...
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not versionable.
     * @throws {@link VersionException}
     * If the specified <i>version</i> is not part of this node's version history
     * or if an attempt is made to restore the root version (<i>jcr:rootVersion</i>).
     * @throws {@link ItemExistsException}
     * If <i>removeExisting</i> is <i>false</i> and a UUID collision occurs.
     * @throws {@link LockException}
     * If a lock prevents the restore.
     * @throws {@link InvalidItemStateException}
     * If this {@link Session} (not necessarily this {@link Node}) has pending unsaved changes.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::restore()
     */
    public function restore($versionName, $removeExisting, $relPath = '') {
        if ($relPath) {
            $this->JRnode->restore($versionName,$removeExisting,$relPath);
        } else {
           $this->JRnode->restore($versionName,$removeExisting);
        }
        $this->session->cache->clean(Zend_Cache::CLEANING_MODE_ALL);
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * @param boolean
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this node is not verisonable.
     * @throws {@link VersionException}
     * If the specified <i>versionLabel</i> does not exist in this
     * node's version history.
     * @throws {@link ItemExistsException}
     * If <i>removeExisting</i> is <i>false</i> and a UUID collision occurs.
     * @throws {@link LockException}
     * If a lock prevents the restore.
     * @throws {@link InvalidItemStateException}
     * If this {@link Session} (not necessarily this {@link Node}) has pending unsaved changes.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::restoreByLabel()
     */
    public function restoreByLabel($versionLabel, $removeExisting) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The name of a {@link Property} of $this {@link Node}
     * @param mixed
     * The value to be assigned
     * @param int|null
     * The type of the {@link Property} (Optional: NULL if not
     * specified).
     * @return object
     * A {@link Property} object
     * @throws {@link ValueFormatException}
     * If <i>$value</i> cannot be converted to the specified type or
     * if the property already exists and is multi-valued.
     * @throws {@link VersionException}
     * If this node is versionable and checked-in or is non-versionable but
     * its nearest versionable ancestor is checked-in and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link LockException}
     * If a lock prevents the setting of the property and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link ConstraintViolationException}
     * If the change would violate a node-type or other constraint and this
     * implementation performs this validation immediately instead of
     * waiting until {@link save()}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::setProperty()
     */
    public function setProperty($name, $value, $type = 1) {
        $isNew = true;
        if ($this->hasProperty($name)) {
            $isNew = false;
        }
        
        $filename = null;
        
        switch ($type) {
            case phpCR_PropertyType::BINARY :
                $pr = new Java("javax.jcr.PropertyType");
                $type = $pr->BINARY;
                
                $strlen = strlen($value);
                // keep it in memory, if small
                if ($strlen < 500) {
                    $out = new Java("java.io.ByteArrayOutputStream");
                    $arr = array();
                    
                    for ($i = 0; $i < $strlen; $i ++) {
                        $val = ord(substr($value, $i, 1));
                        if ($val >= 128) {
                            $val = ($val) - 256;
                        }
                        $arr[] = $val;
                    }
                    $out->write($arr);
                    $value = new Java("java.io.ByteArrayInputStream", $out->toByteArray());
                } else {
                    $filename = tempnam(sys_get_temp_dir(),"jrcr");
                    chmod($filename,0666);
                    file_put_contents($filename,$value);
                    $value = new Java("java.io.FileInputStream",$filename);
                }
            break;
            case phpCR_PropertyType::DATE :
                $pr = new Java("javax.jcr.PropertyType");
                $type = $pr->DATE;
                //$ValueFactory = new Java("javax.jcr.ValueFactory");
                $cal = new Java("java.util.Calendar");
                $val = $cal->getInstance();
                if ($value instanceof DateTime ) {
                    $val->setTimeInMillis($value->format('U') * 1000);
                } else {
                    $val->setTimeInMillis($value * 1000);
                }
                $value = $val;
                break;
            
            default :
                $type = null;
            }
            if (! is_object($value) && $type) {
                $jrprop = $this->JRnode->setProperty($name, $value, $type);
            } else {
                $jrprop = $this->JRnode->setProperty($name, $value);
            }
            
            if (null === $jrprop) {
                throw new phpCR_RepositoryException("Couldn't create new property");
            }
            
            if ($filename) {
                unlink($filename);
            }
            $property = new jr_cr_property($this, $jrprop);
            $this->addPropertyToList($property);
            if ($isNew) {
                $property->setNew(true);
            }
            $property->setModified(true);
            $this->setModified(true);
            if ($this->session->cache) {
                $this->session->cache->clean(Zend_Cache::CLEANING_MODE_ALL);
            }
    }
    
    /**
     *
     * @throws {@link UnsupportedRepositoryOperationException}
     * If this implementation does not support locking.
     * @throws {@link LockException}
     * If this node does not currently hold a lock or holds a lock for which this Session does not have the correct lock token
     * @throws {@link AccessDeniedException}
     * If the current session does not have permission to unlock this node.
     * @throws {@link InvalidItemStateException}
     * If this node has pending unsaved changes.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::unlock()
     */
    public function unlock() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param string
     * The name of the source workspace.
     * @throws {@link NoSuchWorkspaceException}
     * If <i>srcWorkspace</i> does not exist.
     * @throws {@link InvalidItemStateException}
     * If this {@link Session} (not necessarily this {@link Node}) has
     * pending unsaved changes.
     * @throws {@link AccessDeniedException}
     * If the current session does not have sufficient rights to perform
     * the operation.
     * @throws {@link LockException}
     * If a lock prevents the update.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Node::update()
     */
    public function update($scrWorkspaceName) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param object
     * A {@link ItemVisitor} object
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::accept()
     */
    public function accept(phpCR_ItemVisitor $visitor) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param int
     * An integer, 0 &lt;= $degree &lt;= n where
     * n is the depth of $this {@link Item} along the
     * path returned by {@link getPath()}.
     * @return object
     * The ancestor of the specified absolute degree of $this
     * {@link Item} along the path returned by{@link getPath()}.
     * @throws {@link ItemNotFoundException}
     * If $degree &lt; 0 or $degree &gt; n
     * where n is the is the depth of $this {@link Item}
     * along the path returned by {@link getPath()}.
     * @throws {@link AccessDeniedException}
     * If the current {@link Ticket} does not have sufficient access rights to
     * complete the operation.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Item::getAncestor()
     */
    public function getAncestor($degree) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @return int
     * The depth of this {@link Item} in the repository hierarchy.
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::getDepth()
     */
    public function getDepth() {
        return $this->JRnode->getDepth();
    }
    
    /**
     *
     * @return string
     * The (or a) name of this {@link Item} or an empty string if this
     * {@link Item} is the root {@link Node}.
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::getName()
     */
    public function getName() {
        if (!$this->name) {
            $this->name = $this->JRnode->getName();
        }
        return $this->name;
    }
    
    /**
     *
     * @return object
     * The parent of this {@link Item} along the path returned by
     * {@link getPath()}.
     * @throws {@link ItemNotFoundException}
     * If there is no parent.  This only happens if $this
     * {@link Item} is the root node.
     * @throws {@link AccessDeniedException}
     * If the current {@link Ticket} does not have sufficient access rights to
     * complete the operation.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Item::getParent()
     */
    public function getParent() {
        try {
        $p = $this->JRnode->getParent();
        return new jr_cr_node($this->session,$p);
        } catch (Exception $e) {
            throw new phpCR_ItemNotFoundException;
        }
    }
    
    /**
     *
     * @return string
     * The path (or one of the paths) of this {@link Item}.
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::getPath()
     */
    public function getPath() {
        if (!$this->path) {
            $this->path = $this->JRnode->getPath();
        }
        return $this->path;
    }
    
    /**
     *
     * @return object
     * A {@link Session} object
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::getSession()
     */
    public function getSession() {
        return $this->session;
    }
    
    /**
     *
     * @return boolean
     * @see phpCR_Item::isModified()
     */
    public function isModified() {
        return $this->modified;
    }
    
    public function setModified($m) {
        if ($m) {
            $this->session->addNodeToModifiedList($this);
        }
        $this->modified = $m;
    }
    
    /**
     *
     * @return boolean
     * @see phpCR_Item::isNew()
     */
    public function isNew() {
        return $this->new;
    }
    
    public function setNew($new) {
        $this->new = $new;
        if ($new) {
            $this->session->addNodeToList($this);
            $this->session->addNodeToModifiedList($this);
        }
    }
    
    /**
     *
     * @return bool
     * Returns TRUE if this {@link Item} is a {@link Node};
     * Returns FALSE if this {@link Item} is a {@link Property}.
     * @see phpCR_Item::isNode()
     */
    public function isNode() {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param object
     * A {@link Item} object
     * @return boolean
     * @throws {@link RepositoryException}
     * If an error occurs.
     * @see phpCR_Item::isSame()
     */
    public function isSame(phpCR_Item $otherItem) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @param boolean
     * @throws {@link InvalidItemStateException}
     * If this {@link Item} object represents a workspace item that has been
     * removed (either by this session or another).
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Item::refresh()
     */
    public function refresh($keepChanges) {
        //TODO - Insert your code here
    }
    
    /**
     *
     * @throws {@link VersionException}
     * If the parent node of this item is versionable and checked-in or is
     * non-versionable but its nearest versionable ancestor is checked-in
     * and this implementation performs this validation immediately instead
     * of waiting until {@link save()}.
     * @throws {@link LockException}
     * If a lock prevents the removal of this item and this implementation
     * performs this validation immediately instead of waiting until
     * {@link save()}.
     * @throws {@link ConstraintViolationException}
     * If removing the specified item would violate a node type or
     * implementation-specific constraint and this implementation performs
     * this validation immediately instead of waiting until {@link save()}.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Item::remove()
     */
    public function remove() {
        $this->JRnode->remove();
    }
    
    /**
     * Helper function not in specs :
     *
     * @param string $toAbsPath
     */
    public function copy($toAbsPath) {
          $this->session->getWorkspace()->copy(null,$this->getPath(),$toAbsPath);
          return ;
     }
     
    /**
     *
     * @throws {@link AccessDeniedException}
     * If any of the changes to be persisted would violate the access
     * privileges of the this {@link Session}. Also thrown if any of the
     * changes to be persisted would cause the removal of a node that is
     * currently referenced by a <i>REFERENCE</i> property that this
     * Session <i>does not</i> have read access to.
     * @throws {@link ItemExistsException}
     * If any of the changes to be persisted would be prevented by the
     * presence of an already existing item in the workspace.
     * @throws {@link ConstraintViolationException}
     * If any of the changes to be persisted would violate a node type or
     * restriction. Additionally, a repository may use this exception to
     * enforce implementation- or configuration-dependent restrictions.
     * @throws {@link InvalidItemStateException}
     * If any of the changes to be persisted conflicts with a change already
     * persisted through another session and the implementation is such that
     * this conflict can only be detected at save-time and therefore was not
     * detected earlier, at change-time.
     * @throws {@link ReferentialIntegrityException}
     * If any of the changes to be persisted would cause the removal of a
     * node that is currently referenced by a <i>REFERENCE</i> property
     * that this {@link Session} has read access to.
     * @throws {@link VersionException}
     * If the {@link save()} would make a result in a change to persistent
     * storage that would violate the read-only status of a checked-in node.
     * @throws {@link LockException}
     * If the {@link save()} would result in a change to persistent storage
     * that would violate a lock.
     * @throws {@link NoSuchNodeTypeException}
     * If the {@link save()} would result in the addition of a node with an
     * unrecognized node type.
     * @throws {@link RepositoryException}
     * If another error occurs.
     * @see phpCR_Item::save()
     */
    public function save() {
        /*foreach ($this->properties as $p) {
            if ($p->isModified()) {
                $p->save();
            }
        }*/
        $this->JRnode->save();
        //some storage providers have to write all properties at once (jr_cr_storage_file eg)
    }
    
    public static function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
    
    protected function addPropertyToList(jr_cr_property $property) {
        $this->properties[$property->getName()] = $property;
    }
    
    protected function getPropertyFromList($jrnode) {
        $path = $jrnode->getName();
        if (! $path) {
            return null;
        }
        
        if (isset($this->properties[$path]) && $this->properties[$path]) {
            return $this->properties[$path];
        }
        
        $prop = new jr_cr_property($this, $jrnode);
        if ($prop) {
            $this->addPropertyToList($prop);
            return $prop;
        } else {
            return null;
        }
    }
}
