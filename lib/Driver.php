<?php
/**
 * Tessera_Driver defines an API for implementing storage backends for
 * Tessera.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @package   Tessera
 */
abstract class Tessera_Driver
{
    /**
     * Hash containing connection parameters.
     *
     * @var array
     */
    protected $_params = [];

    /**
     * Constructor.
     *
     * @param array $params  A hash containing connection parameters.
     */
    public function __construct($params = [])
    {
        $this->_params = $params;
    }

    abstract public function getSecret($user);
    abstract public function setSecret($user, $secret);
    abstract public function delSecret($user);
    abstract public function getUsers();
}
