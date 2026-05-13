<div class="settings-page">
<?php if ($already) { ?>
  <h1 class="settings-page-title">Two-Factor Authentication</h1>

  <div class="settings-callout" style="background: #d4edda; border-color: #c3e6cb;">
    <p><strong>2FA is enabled.</strong> You will need to enter a one-time password (OTP) from your authenticator app each time you log in to <?php echo htmlspecialchars($sitename) ?>.</p>
  </div>

  <div class="settings-callout" style="background: #fff3cd; border-color: #ffc107;">
    <p>Contact your IT Department immediately if your device with the authenticator app is lost or stolen.</p>
  </div>

  <p class="settings-section-desc">To use a different device or authenticator app, click Reconfigure below.</p>

  <form method="post">
    <div class="settings-form-actions" style="border-top: none; padding-top: 0;">
      <input name="submit_button" class="btn btn-secondary" value="Reconfigure" type="submit">
    </div>
  </form>

<?php } else { ?>
  <h1 class="settings-page-title">Setup Complete</h1>

  <div class="settings-callout" style="background: #d4edda; border-color: #c3e6cb;">
    <p><strong>Two-factor authentication is now active.</strong></p>
    <p>From now on, you will need to enter an OTP code from your authenticator app in addition to your password each time you log in to <?php echo htmlspecialchars($sitename) ?>.</p>
  </div>

  <div class="settings-callout" style="background: #fff3cd; border-color: #ffc107;">
    <p>Contact your IT Department immediately if your device with the authenticator app is lost or stolen.</p>
  </div>
<?php } ?>
</div>
