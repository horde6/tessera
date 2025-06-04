<?php
/**
 * Copyright 2013-2017 Horde LLC (http://www.horde.org/)
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
 * Tessera Block example.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @category  Horde
 * @copyright 2013-2017 Horde LLC
 * @license   http://www.horde.org/licenses/gpl GPL
 * @package   Tessera
 */
class Tessera_Block_Example extends Horde_Core_Block
{
    /**
     */
    public function __construct($app, $params = [])
    {
        parent::__construct($app, $params);

        $this->_name = _("Example Block");
    }

    /**
     */
    protected function _params()
    {
        return [
            'color' => [
                'type' => 'text',
                'name' => _("Color"),
                'default' => '#ff0000'
            ]
        ];
    }

    /**
     */
    protected function _title()
    {
        return _("Color");
    }

    /**
     */
    protected function _content()
    {
        $html  = '<table width="100" height="100" bgcolor="%s">';
        $html .= '<tr><td>&nbsp;</td></tr>';
        $html .= '</table>';

        return sprintf($html, $this->_params['color']);
    }

}
