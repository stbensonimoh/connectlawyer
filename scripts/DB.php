<?php
/**
 * This script is the DB Class
 *
 * PHP version 7.2
 *
 * @category DB_Class
 * @package  DB_Class
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
class DB
{
    private $_dsn;
    private $_host;
    private $_db;
    private $_username;
    private $_password;
    public $email;
    public $tablename;
    private $_conn;

    /**
     * Constructor function
     *
     * @param string $host     The host of the Database
     * @param string $db       The Database name
     * @param string $username The Database Username
     * @param string $password The Database Password
     */
    public function __construct($host, $db, $username, $password)
    {
        $this->_dsn = "mysql:host=$host;dbname=$db";
        $this->_host = $host;
        $this->_db = $db;
        $this->_username = $username;
        $this->_password = $password;

        //Create PDO Connection with the dbconfig data
        $this->_conn = new PDO($this->_dsn, $username, $password);

        return $this->_conn;
    }

    /**
     * Check if User Exists in the Database
     *
     * @param string $email     The Email Address to be checked
     * @param string $tablename The name of the tale to be checked
     *
     * @return void
     */
    public function userExists($email, $tablename)
    {
        $usercheck = "SELECT * FROM $tablename WHERE email=?";
        // prepare the Query
        $usercheckquery = $this->_conn->prepare($usercheck);
        //Execute the Query
        $usercheckquery->execute(array("$email"));
        //Fetch the Result
        $usercheckquery->rowCount();
        if ($usercheckquery->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Inserts a New User in to the Database
     *
     * @param string $tablename The Name of the table to insert user
     * @param array  $details   The Details to be entered into
     *
     * @return void
     */
    public function insertUser($tablename, $details)
    {
        $columns = array_keys($details);
        $values = array_values($details);
        // Insert the user into the database
        $enteruser = "INSERT into $tablename (" . implode(',', $columns) .")
                    VALUES ('" . implode("', '", $values) . "')";
        //  Prepare Query
        $enteruserquery = $this->_conn->prepare($enteruser);
        //  Execute the Query
        $enteruserquery->execute();
        //  Fetch Result
        $enteruserquery->rowCount();

        if ($enteruserquery->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
