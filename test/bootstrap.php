<?php

/**
 * Bootstrap file for jr_cr
 *
 * This file does some basic stuff that's project specific.
 * 
 * function getRepository(config) which returns the repository
 * function getJCRSession(config) which returns the session
 *
 * TODO: remove the following once it has been moved to a base file
 * function getSimpleCredentials(user, password) which returns simpleCredentials
 *
 * constants necessary to the JCR 1.0/JSR-170 and JSR-283 specs
 */

// Make sure we have the necessary config
$necessaryConfigValues = array('jcr.url', 'jcr.user', 'jcr.pass', 'jcr.workspace', 'jcr.transport');
foreach ($necessaryConfigValues as $val) {
    if (empty($GLOBALS[$val])) {
        die('Please set '.$val.' in your phpunit.xml.' . "\n");
    }
}

/** autoloader: jackalope-api-tests relies on this autoloader.
 */
function jackalopeApiTestsAutoload($class) {
    if (strpos($class,'jr_') === 0) {
        $incFile = dirname(__FILE__) . '/../' . str_replace("_", DIRECTORY_SEPARATOR, substr($class,3)).".php";
    } elseif (strpos($class,'PHPCR_') === 0) {
        $incFile = dirname(__FILE__) . '/suite/lib/' . str_replace("_", DIRECTORY_SEPARATOR, $class).".php";
    }
    if (@fopen($incFile, "r", TRUE)) {
        include($incFile);
        return $incFile;
    }
    return FALSE;
}
spl_autoload_register('jackalopeApiTestsAutoload');

/**
 * Repository lookup is implementation specific.
 * @param config The configuration where to find the repository
 * @return the repository instance
 */ 
function getRepository($config) {
    if (empty($config['url']) || empty($config['transport'])) {
        return false;
    }
    return jr_cr::lookup($config['url'], $config['transport']);
}

/**
 * @param user The user name for the credentials
 * @param password The password for the credentials
 * @return the simple credentials instance for this implementation with the specified username/password
 */
function getSimpleCredentials($user, $password) {
    return new jr_cr_simplecredentials($user, $password);
}

/** 
 * Get a session for this implementation.
 * @param config The configuration that is passed to getRepository
 * @param credentials The credentials to log into the repository. If omitted, $config['user'] and $config['pass'] is used with getSimpleCredentials
 * @return A session resulting from logging into the repository found at the $config path
 */
function getJCRSession($config, $credentials = null) {
    $repository = getRepository($config);
    if (isset($config['pass']) || isset($credentials)) {
        if (empty($config['workspace'])) {
            $config['workspace'] = null;
        }
        if (empty($credentials)) {
            $credentials = getSimpleCredentials($config['user'], $config['pass']);
        }
        return $repository->login($credentials, $config['workspace']);
    } elseif (isset($config['workspace'])) {
        return $repository->login(null, $config['workspace']);
    } else {
        return $repository->login(null, null);
    }
}
/** some constants */

define('SPEC_VERSION_DESC', 'jcr.specification.version');
define('SPEC_NAME_DESC', 'jcr.specification.name');
define('REP_VENDOR_DESC', 'jcr.repository.vendor');
define('REP_VENDOR_URL_DESC', 'jcr.repository.vendor.url');
define('REP_NAME_DESC', 'jcr.repository.name');
define('REP_VERSION_DESC', 'jcr.repository.version');
define('LEVEL_1_SUPPORTED', 'level.1.supported');
define('LEVEL_2_SUPPORTED', 'level.2.supported');
define('OPTION_TRANSACTIONS_SUPPORTED', 'option.transactions.supported');
define('OPTION_VERSIONING_SUPPORTED', 'option.versioning.supported');
define('OPTION_OBSERVATION_SUPPORTED', 'option.observation.supported');
define('OPTION_LOCKING_SUPPORTED', 'option.locking.supported');
define('OPTION_QUERY_SQL_SUPPORTED', 'option.query.sql.supported');
define('QUERY_XPATH_POS_INDEX', 'query.xpath.pos.index');
define('QUERY_XPATH_DOC_ORDER', 'query.xpath.doc.order');
