<?php
$qr = $setup ?? '';
if (!empty($qr)) {
    $i = (int) substr($qr, 1);
    if (isset($apps[$i])) {
	$app = $apps[$i];
	$name = $app['name'];
	$q = substr($qr, 0, 1);
	$for = $cols[$q];
	$url = isset($app[$q]) ? $app[$q] : '';
    } else {
	$url = '';
    }
    if ($url == '')
	$qr = '';
}

if (empty($qr)) { ?>
<div class="settings-page">
  <h1 class="settings-page-title">Two-Factor Authentication</h1>

  <p class="settings-section-desc">
    Two-factor authentication (2FA) is a security process in which users provide two different authentication factors to verify themselves.
    It provides a higher level of security than single-factor authentication by requiring both a password and a one-time passcode.
  </p>

  <p class="settings-section-desc">
    <?php echo htmlspecialchars($sitename) ?> implements 2FA using <em>one-time passwords</em> (OTP).
    An OTP is a passcode valid for a single login session, used in addition to your main password.
  </p>

  <div class="settings-callout">
    <p><strong>You need an authenticator app</strong> to generate OTP codes for <?php echo htmlspecialchars($sitename) ?>.</p>
    <p>We recommend installing an authenticator app on your <strong>personal smartphone</strong>.</p>
  </div>

  <h2 class="settings-section-title">Compatible Applications</h2>
  <p class="settings-section-desc">If you do not already have a compatible app, click an install link below for your device.</p>

  <ul class="settings-provider-list">
<?php
    $i = 0;
    foreach ($apps as $app) {
	$appName = htmlspecialchars($app['name']);
	if ($i === 0) {
	    $appName .= ' <span class="settings-status settings-status-ok">Recommended</span>';
	}

	$platforms = [];
	foreach ($cols as $key => $col) {
	    if ($key === 'name') continue;
	    if (!empty($app[$key])) {
		$query = '?setup=' . $key . $i;
		if (strpos('ag', $key) === false) {
		    $query .= '&show=1';
		}
		$platforms[] = '<a href="' . $query . '" class="btn btn-sm btn-secondary">' . htmlspecialchars($col) . '</a>';
	    }
	}
?>
    <li class="settings-provider-item">
      <div class="settings-provider-info">
        <span class="settings-provider-name"><?php echo $appName ?></span>
      </div>
      <div class="settings-provider-actions">
        <?php echo implode(' ', $platforms) ?>
      </div>
    </li>
<?php
        ++$i;
    }
?>
  </ul>

  <p class="settings-section-desc" style="margin-top: 24px;">
    Click <strong>Continue</strong> if you already have a compatible authenticator app installed.
  </p>

  <form method="post" action="">
    <div class="settings-form-actions" style="border-top: none; padding-top: 0;">
      <input name="submit_button" class="btn btn-primary" value="Continue" type="submit">
      <input name="submit_button" class="btn btn-secondary" value="Cancel" type="submit">
    </div>
  </form>
</div>
<?php } else {
$show = $vars->show == '1';

parse_str($_SERVER['QUERY_STRING'], $query);
$query['show'] = $show ? '0' : '1';
$redir = '?' . http_build_query($query);
?>
<div class="settings-page">
  <h1 class="settings-page-title"><?php echo htmlspecialchars($name) ?></h1>
  <p class="settings-section-desc">Install for <?php echo htmlspecialchars($for) ?></p>

<?php if ($show) { ?>
  <div class="settings-form-card">
    <p>Use this link to install the authenticator:</p>
    <p><a href="<?php echo htmlspecialchars($url) ?>" target="_blank" class="btn btn-primary"><?php echo htmlspecialchars($name) ?></a></p>
    <p class="settings-form-help">Or <a href="<?php echo $redir ?>">scan a QR Code</a> instead.</p>
  </div>
<?php } else { ?>
  <div class="settings-form-card">
    <p>Open the Camera app on your <?php echo htmlspecialchars($for) ?> device and scan the QR Code below:</p>
    <div style="text-align: center; margin: 16px 0;">
      <?php echo Tessera::QRCode($url, 4); ?>
    </div>
    <p class="settings-form-help">Or use a <a href="<?php echo $redir ?>">direct link</a> instead.</p>
  </div>
<?php } ?>

  <p class="settings-section-desc" style="margin-top: 16px;">
    <a href="?setup">Choose a different app</a>
  </p>

  <form method="post" action="">
    <div class="settings-form-actions" style="border-top: none; padding-top: 0;">
      <input name="submit_button" class="btn btn-primary" value="Continue" type="submit">
      <input name="submit_button" class="btn btn-secondary" value="Cancel" type="submit">
    </div>
  </form>
</div>
<?php } ?>
