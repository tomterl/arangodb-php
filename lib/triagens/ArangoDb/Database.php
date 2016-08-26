<?php

/**
 * ArangoDB PHP client: single database
 *
 * @package   triagens\ArangoDb
 * @author    Frank Mayer
 * @copyright Copyright 2013, triagens GmbH, Cologne, Germany
 */

namespace triagens\ArangoDb;

/**
 * A class for managing ArangoDB Databases
 *
 * This class provides functions to manage Databases through ArangoDB's Database API<br>
 *
 * @link      http://www.arangodb.com/manuals/1.4/HttpDatabase.html
 *
 * @package   triagens\ArangoDb
 * @since     1.4
 */
class Database
{
    /**
     * Databases index
     */
    const ENTRY_DATABASE_NAME = 'name';

    /**
     * Username parameter
     */
    const ENTRY_DATABASE_USERNAME = 'username';

    /**
     * Extra user information parameter
     */
    const ENTRY_DATABASE_EXTRA = 'extra';

    /**
     * Password parameter
     */
    const ENTRY_DATABASE_PASSWD = 'passwd';

    /**
     * Active parameter
     */
    const ENTRY_DATABASE_ACTIVE = 'active';

    /**
     * Additional users parameter
     */
    const ENTRY_DATABASE_USERS = 'users';
    
    /**
     * 
     */
    /**
     * creates a database
     *
     * This creates a new database<br>
     *
     * @param Connection $connection  - the connection to be used
     * @param string     $name        - the database name, for example 'myDatabase'
     * @param array      $options     - additional parameters
     *                                  username - the database owner, for example 'root'
     *                                  extra - information for the user, stored but ignored by arangodb
     *                                  passwd - the users password
     *                                  active - activate the account 'username' - default is true
     *                                  users array of additional users (each user an array with the keys 'username', 'active', 'passwd')
     *
     * @link http://docs.arangodb.com/2.8/HttpDatabase/DatabaseManagement.html
     *
     * @return array $responseArray - The response array.
     */
    public static function create(Connection $connection, $name, $options = array())
    {
        $payload = array(self::ENTRY_DATABASE_NAME => $name);
        $payload = araray_merge($payload, $options);
        
        $response = $connection->post(Urls::URL_DATABASE, $connection->json_encode_wrapper($payload));

        $responseArray = $response->getJson();

        return $responseArray;
    }


    /**
     * Deletes a database
     *
     * This will delete an existing database.
     *
     * @param Connection $connection - the connection to be used
     * @param string     $name       - the database specification, for example 'myDatabase'
     *
     * @link http://www.arangodb.com/manuals/1.4/HttpDatabase.html
     *
     * @return array $responseArray - The response array.
     */
    public static function delete(Connection $connection, $name)
    {
        $url = UrlHelper::buildUrl(Urls::URL_DATABASE, array($name));

        $response = $connection->delete($url);

        $responseArray = $response->getJson();

        return $responseArray;
    }


    /**
     * List databases
     *
     * This will list the databases that exist on the server
     *
     * @param Connection $connection - the connection to be used
     *
     * @link http://www.arangodb.com/manuals/1.4/HttpDatabase.html
     *
     * @return array $responseArray - The response array.
     */
    public static function listDatabases(Connection $connection)
    {
        $response = $connection->get(Urls::URL_DATABASE);

        $responseArray = $response->getJson();

        return $responseArray;
    }

    /**
     * List user databases
     *
     * Retrieves the list of all databases the current user can access without
     * specifying a different username or password.
     *
     * @param Connection $connection - the connection to be used
     *
     * @link http://www.arangodb.com/manuals/1.4/HttpDatabase.html
     *
     * @return array $responseArray - The response array.
     */
    public static function listUserDatabases(Connection $connection)
    {

        $url      = UrlHelper::buildUrl(Urls::URL_DATABASE, array('user'));

        $response = $connection->get($url);

        $responseArray = $response->getJson();

        return $responseArray;
    }


    /**
     * Retrieves information about the current database
     *
     * This will get information about the currently used database from the server
     *
     * @param Connection $connection - the connection to be used
     *
     * @link http://www.arangodb.com/manuals/1.4/HttpDatabase.html
     *
     * @return array $responseArray - The response array.
     */
    public static function getInfo(Connection $connection)
    {
        $url = UrlHelper::buildUrl(Urls::URL_DATABASE, array('current'));

        $response = $connection->get($url);

        $responseArray = $response->getJson();

        return $responseArray;
    }
}
