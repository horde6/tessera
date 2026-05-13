<div class="settings-page">
  <h1 class="settings-page-title">Configure Authenticator</h1>
  <p class="settings-section-desc">Step 2 of 3 &mdash; Create an account for <?php echo htmlspecialchars($sitename) ?> in your authenticator app.</p>

  <div class="settings-callout">
    <p>You should have installed an authenticator app in the previous step. If not, click <strong>Cancel</strong> to go back.</p>
  </div>

<?php
$show = $vars->show == '1';

parse_str($_SERVER['QUERY_STRING'], $query);
$query['show'] = $show ? '0' : '1';
$redir = '?' . http_build_query($query);

if ($show) {
?>
  <h2 class="settings-section-title">Manual Entry</h2>
  <p class="settings-section-desc">Open your authenticator app, add a new account, and enter the parameters below.</p>

  <div class="settings-callout" style="background: #fff3cd; border-color: #ffc107;">
    <p><strong>Do not save this information</strong> &mdash; only enter it in the authenticator app.</p>
  </div>

  <ul class="settings-status-list">
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Account name</span>
        <code class="settings-path"><?php echo htmlspecialchars("$sitename: $user") ?></code>
      </div>
    </li>
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Secret key</span>
        <code class="settings-path"><?php echo htmlspecialchars($tempkey) ?></code>
      </div>
    </li>
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Type</span>
        <span class="settings-status settings-status-ok">Time-based (TOTP)</span>
      </div>
    </li>
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Digits</span>
        <span>6</span>
      </div>
    </li>
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Algorithm</span>
        <span>SHA1</span>
      </div>
    </li>
    <li class="settings-status-card">
      <div class="settings-status-card-header">
        <span class="settings-status-card-label">Interval</span>
        <span>30 seconds</span>
      </div>
    </li>
  </ul>

  <p class="settings-section-desc" style="margin-top: 16px;">
    Or <a href="<?php echo $redir ?>">scan a QR Code</a> instead.
  </p>

<?php } else { ?>
  <h2 class="settings-section-title">Scan QR Code</h2>
  <p class="settings-section-desc">Open your authenticator app, add a new account, and scan the QR Code below.</p>

  <div class="settings-callout" style="background: #fff3cd; border-color: #ffc107;">
    <p><strong>Do not save the QR Code image</strong> on your device.</p>
  </div>

  <div class="settings-form-card" style="text-align: center;">
    <?php echo Tessera::QRCodeAuth($user, $tempkey) ?>
  </div>

  <p class="settings-section-desc" style="margin-top: 16px;">
    Or <a href="<?php echo $redir ?>">enter parameters manually</a>.
  </p>
<?php } ?>

  <h2 class="settings-section-title">Validate</h2>
  <p class="settings-section-desc">Enter the OTP code shown in your authenticator app to complete setup.</p>

  <form method="post">
    <div class="settings-form-card">
      <div class="settings-form-row">
        <label class="settings-form-label" for="<?php echo $otpkey ?>">OTP Code</label>
        <input class="settings-form-control" type="text" autocomplete="off" autocapitalize="none" autocorrect="off" id="<?php echo $otpkey ?>" name="<?php echo $otpkey ?>" value="" style="direction:ltr" placeholder="Enter 6-digit code">
        <span class="settings-form-help">The code refreshes every 30 seconds</span>
      </div>
      <div class="settings-form-actions">
        <input name="submit_button" class="btn btn-primary" value="Validate" type="submit">
        <input name="submit_button" class="btn btn-secondary" value="Cancel" type="submit">
      </div>
    </div>
  </form>
</div>
