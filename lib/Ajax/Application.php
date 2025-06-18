<?php

/**
 * Copyright 2012-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author   Dmitry Petrov <dpetrov67@gmail.com>
 * @category Horde
 * @license  http://www.horde.org/licenses/gpl GPL
 * @package  Tessera
 */

/**
 * Tessera AJAX application API.
 *
 * This file defines the AJAX actions provided by this module. The primary
 * AJAX endpoint is represented by horde/services/ajax.php but that handler
 * will call the module specific actions defined in this class.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @category  Horde
 * @copyright 2012-2017 Horde LLC
 * @license   http://www.horde.org/licenses/gpl GPL
 * @package   Tessera
 */
class Tessera_Ajax_Application extends Horde_Core_Ajax_Application
{
    /**
     * Application specific initialization tasks should be done in here.
     */
    protected function _init()
    {
        // This adds the 'noop' action to the current application.
        $this->addHandler('Horde_Core_Ajax_Application_Handler_Noop');
    }

}
