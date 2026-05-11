<?php

use Horde\Util\Util;

require_once __DIR__ . '/lib/Application.php';

$app = 'tessera';

Horde_Registry::appInit($app);

$tessera = $injector->getInstance('Tessera_Driver');

$vars = Horde_Variables::getDefaultVariables();

$sitename = Tessera::SiteName();

$user = $registry->getAuth();

$secret = $tessera->getSecret($user);

// regular user actions

// session key for temp key
$tskey = 'secret';

// form key
$otpkey = 'otp';

$already = $secret != '';

$tempkey = $session->get($app, $tskey);

$button = Util::getPost('submit_button');
switch ($button) {
    case 'Continue':
        $tempkey = Tessera::GenerateKey();
        $session->set($app, $tskey, $tempkey);
        $mode = 'display';
        break;
    case 'Cancel':
        // remove temp key
        $session->remove($app, $tskey);
        $tempkey = '';
        break;
}

$setup = empty($button) ? $vars->setup : null;

if (empty($tempkey)) {
    if ($already) {
        $already = $button != 'Reconfigure' && is_null($setup);
    }

    $mode = $already ? 'success' : 'setup';
} else {
    // we have temp key
    // check if we got OTP posted
    if ($button == 'Validate') {
        // check otp against temp key
        $otp = Util::getPost($otpkey) ?? '';
        if (Tessera::Authenticate($tempkey, $otp)) {
            $tessera->setSecret($user, $tempkey);

            $already = false;

            // remove temp key
            $session->remove($app, $tskey);
            $tempkey = '';

            $notification->push('Your OTP key is now activated', 'horde.message');
            $mode = 'success';
        } else {
            $notification->push('OTP is invalid. Try again.', 'horde.error');
            $mode = 'display';
        }
    } else {
        $mode = 'display';
    }
}

if ($mode == 'setup') {
    $apps = [
        [
            'name'	=> 'FreeOTP Authenticator',
            'g'		=> 'https://play.google.com/store/apps/details?id=org.fedorahosted.freeotp',
            'a'		=> 'https://apps.apple.com/app/freeotp-authenticator/id872559395',
        ],
        [
            'name'	=> 'Google Authenticator',
            'g'		=> 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2',
            'a'		=> 'https://apps.apple.com/app/google-authenticator/id388497605',
        ],
        [
            'name'	=> 'Microsoft Authenticator',
            'g'		=> 'https://play.google.com/store/apps/details?id=com.azure.authenticator',
            'a'		=> 'https://apps.apple.com/us/app/microsoft-authenticator/id983156458',
        ],
        [
            'name'	=> 'Twilio Authy Authenticator',
            'g'		=> 'https://play.google.com/store/apps/details?id=com.authy.authy',
            'a'		=> 'https://apps.apple.com/us/app/twilio-authy/id494168017',
            'w'		=> 'https://authy.com/download/',
            'm'		=> 'https://authy.com/download/',
        ],
        [
            'name'	=> 'Aegis Authenticator',
            'g'		=> 'http://play.google.com/store/apps/details?id=com.beemdevelopment.aegis',
        ],
        [
            'name'	=> 'Authenticator Extension',
            'b'		=> 'https://authenticator.cc/',
        ],
    ];

    $cols = [
        'name'	=> 'Compatible Applications',
        'g'		=> 'Android',
        'a'		=> 'Apple iOS',
        'w'		=> 'Windows',
        'm'		=> 'MacOS',
        'b'		=> 'Browser',
    ];
}

Horde::startBuffer();

$page_output->header([
    //	'body_class' => 'modal-form',
    'title' => 'Setup',
]);

$notification->notify(['listeners' => 'status']);

$template = $registry->get('templates', $app) . '/' . $mode . '.inc';
//TODO: Check if exists?

require $template;

$page_output->footer();
