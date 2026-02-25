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
class Tessera_Block_MyOtp extends Horde_Core_Block
{
    private $registry;
    /**
     */
    public function __construct($app, $params = [])
    {
        parent::__construct($app, $params);
        // TODO: Make this injectable
        $this->registry = $GLOBALS['registry'];

        $this->_name = _("My OTP Setup");
    }

    /**
     */
    protected function _params()
    {
        return [
        ];
    }

    /**
     */
    protected function _title()
    {
        return _("My OTP Setup");
    }

    /**
     */
    protected function _content()
    {
        $html  = '<table>';
        $html .= '<tr><td>' . 'secondfactor/isEnabled' . ' ' . _('API present') . '</td><td>' . ($this->registry->hasMethod('secondfactor/isEnabled') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/isEnabled' . ' ' . _('Mode') . '</td><td>' . ($this->registry->call('secondfactor/isEnabled') ? _('Enabled') : _('Disabled')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/isOptional' . ' ' . _('API present') . '</td><td>' . ($this->registry->hasMethod('secondfactor/isOptional') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/isOptional' . ' ' . _('Mode') . '</td><td>' . ($this->registry->call('secondfactor/isOptional') ? _('Optional') : _('Required')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/showCode' . ' ' . _('API present') . '</td><td>' . ($this->registry->hasMethod('secondfactor/showCode') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/showCode' . ' ' . _('Mode') . '</td><td>' . ($this->registry->call('secondfactor/showCode') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/blockLogin' . ' ' . _('API present') . '</td><td>' . ($this->registry->hasMethod('secondfactor/blockLogin') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . 'secondfactor/isSetup' . ' ' . _('API present') . '</td><td>' . ($this->registry->hasMethod('secondfactor/isSetup') ? _('Yes') : _('No')) . '</td></tr>';
        $html .= '<tr><td>' . _('Is a second factor setup for me?') . '</td><td>' . ($this->registry->call('secondfactor/isSetup', [$this->registry->getAuth()]) ? _('Yes') : '<a href="' . Horde::url('', true, ['app' => 'tessera']) . '">' . _('No, please setup')) . '</a></td></tr>';
        $html .= '</table>';

        return $html;
    }

}
