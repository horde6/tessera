<?php
require_once __DIR__ . '/lib/Application.php';

$app = 'tessera';

Horde_Registry::appInit($app);

// in admin mode we will allow to override user and display its current OTP
if (!$registry->isAdmin()) {
	throw new Horde_Exception_PermissionDenied();
}

$tessera = $injector->getInstance('Tessera_Driver');

$users = $tessera->getUsers();

$vars = Horde_Variables::getDefaultVariables();

$action = $vars->a;
$user = $vars->u;

$otp = '';
switch ($action) {
    case 'd':
	$tessera->delSecret($user);
	break;
    case 'v':
	$secret = $tessera->getSecret($user) ?? '';
	$otp = Tessera::GetCode($secret);
	break;
}

$mode = 'admin';

Horde::startBuffer();

$page_output->header(array(
//	'body_class' => 'modal-form',
	'title' => 'Admin'
));

$notification->notify(array('listeners' => 'status'));

$template = $registry->get('templates', $app) . '/' . $mode . '.inc';
//TODO: Check if exists?

require $template;

$page_output->footer();
