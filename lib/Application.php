<?php

/* Determine the base directories. */
if (!defined('TESSERA_BASE')) {
    define('TESSERA_BASE', realpath(__DIR__ . '/..'));
}

if (!defined('HORDE_BASE')) {
    /* If Horde does not live directly under the app directory, the HORDE_BASE
     * constant should be defined in config/horde.local.php. */
    if (file_exists(TESSERA_BASE . '/config/horde.local.php')) {
        include TESSERA_BASE . '/config/horde.local.php';
    } else {
        define('HORDE_BASE', realpath(TESSERA_BASE . '/..'));
    }
}

/* Load the Horde Framework core (needed to autoload
 * Horde_Registry_Application::). */
require_once HORDE_BASE . '/lib/core.php';

/**
 * Tessera application API.
 *
 * This class defines Horde's core API interface. Other core Horde libraries
 * can interact with Tessera through this API.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @package   Tessera
 */
class Tessera_Application extends Horde_Registry_Application
{
    /**
     */
    public $version = 'H6 (0.2)';

    /**
     */
    protected function _bootstrap()
    {
        $GLOBALS['injector']->bindFactory('Tessera_Driver', 'Tessera_Factory_Driver', 'create');
    }

    /**
     * Adds items to the sidebar menu.
     *
     * Simple sidebar menu entries go here. More complex entries are added in
     * the sidebar() method.
     *
     * @param $menu Horde_Menu  The sidebar menu.
     */
    public function menu($menu)
    {
        /* If index.php == lists.php, jump some extra loops to highlight the
         * menu entry. */
        $menu->add(
            Horde::url('?setup'),
            ("Reconfigure"),
            'tessera-reconfigure',
            null,
            null,
            null,
            basename($_SERVER['PHP_SELF']) == 'index.php' ? 'current' : null
        );

        if ($GLOBALS['registry']->isAdmin()) {
            $menu->add(
                Horde::url('admin.php'),
                ("Admin Tools"),
                'tessera-admin',
                null,
                null,
                null,
                basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'current' : null
            );
        }


        /* A regular entry. */
        //$menu->add(Horde::url('data.php'), _("Import/Export"), 'horde-data');
    }

    /**
     * Adds additional items to the sidebar.
     *
     * @param Horde_View_Sidebar $sidebar  The sidebar object.
     */
    public function sidebar($sidebar)
    {
        $url = Horde::url('');

        $sidebar->addNewButton(
            _("_Setup OTP"),
            $url
        );
    }

    /**
     * Add node(s) to the topbar tree.
     *
     * @param Horde_Tree_Renderer_Base $tree  Tree object.
     * @param string $parent                  The current parent element.
     * @param array $params                   Additional parameters.
     *
     * @throws Horde_Exception
     */
    public function topbarCreate(Horde_Tree_Renderer_Base $tree, $parent = null, array $params = [])
    {
        /*
            $tree->addNode([
                'id' => $parent . '__sub',
                'parent' => $parent,
                'label' => _("Reset"),
                'expanded' => false,
                'params' => [
        //			'icon' => Horde_Themes::img('reset.png'),
                    'url' => Horde::url('?reset=1'),
                ],
            ]);
        */
    }
}
