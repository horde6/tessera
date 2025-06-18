<?php
/**
 * Tessera storage implementation for the Horde_Db database abstraction layer.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @package   Tessera
 */
class Tessera_Driver_Sql extends Tessera_Driver
{
    /**
     * Handle for the current database connection.
     *
     * @var Horde_Db_Adapter
     */
    protected $_db;

    /**
     * Constructs a new SQL storage object.
     *
     * @param array $params  Class parameters:
     *                       - db:    (Horde_Db_Adapater) A database handle.
     *                       - table: (string, optional) The name of the
     *                                database table.
     *
     * @throws InvalidArgumentException
     */
	public function __construct(array $params = []) {
		if (!isset($params['db'])) {
			throw new InvalidArgumentException('Missing db parameter.');
		}
		$this->_db = $params['db'];
		unset($params['db']);
		
		$params = array_merge([ 'table' => 'horde_tessera' ], $params);
		
		parent::__construct($params);
	}
	
	/**
	 * Retrieves the auth secret from the database.
	 *
	 * @throws Tessera_Exception
	 */
	public function getSecret($user)
	{
		$query = sprintf('SELECT secret FROM %s WHERE user=%s',
			$this->_params['table'],
			$this->_db->quote($user),
		);
		
		try {
			return $this->_db->selectValue($query);
		} catch (Horde_Db_Exception $e) {
			throw new Tessera_Exception($e);
		}
		
		return '';
	}
	
	public function setSecret($user, $secret) {
		// TODO: Check if secret looks like a valid secret.
		// This will work on mariadb and mysql but not all standard SQL databases implement it.
		$query = sprintf('REPLACE INTO %s (user,secret) VALUES(?,?)', $this->_params['table']);
		$values = [ $user, $secret ];
		
		try {
			$this->_db->update($query, $values);
		} catch (Horde_Db_Exception $e) {
			throw new Tessera_Exception($e);
		}
	}
	
	public function delSecret($user) {
		$query = sprintf('DELETE FROM %s WHERE user=?', $this->_params['table']);
		$values = [ $user ];
		
		try {
			$this->_db->update($query, $values);
		} catch (Horde_Db_Exception $e) {
			throw new Tessera_Exception($e);
		}
	}
	
	public function getUsers() {
		$query = sprintf('SELECT user FROM %s ORDER BY user', $this->_params['table']);
		try {
			return $this->_db->selectValues($query);
		} catch (Horde_Db_Exception $e) {
			throw new Tessera_Exception($e);
		}
	}
}
