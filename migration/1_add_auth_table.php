<?php
/**
 * Create Tessera base table
 *
 * @author   Dmitry Petrov <dpetrov67@gmail.com>
 * @category Horde
 * @license  http://www.horde.org/licenses/gpl GPL
 * @package  Tessera
 */
 
class AddAuthTable extends Horde_Db_Migration_Base
{
    private static string $tbl = 'horde_tessera';

    /**
     * Upgrade.
     */
    public function up()
    {
	$tableList = $this->tables();
	if (!in_array(self::$tbl, $tableList)) {
	    $t = $this->createTable(self::$tbl, array('autoincrementKey' => false));
	    $t->column('user', 'string', array('limit' => 255, 'null' => false));
	    $t->column('secret', 'string', array('limit' => 32, 'null' => false));
	    $t->primaryKey(array('user'));
	    $t->end();
	}
    }

    /**
     * Downgrade.
     */
    public function down()
    {
        $tables = $this->tables();
        if (in_array(self::$tbl, $tables)) {
            $this->dropTable(self::$tbl);
        }
    }
}
