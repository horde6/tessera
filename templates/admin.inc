<div class="settings-page">
  <h1 class="settings-page-title">OTP Administration</h1>

<?php if (empty($users)) { ?>
  <div class="settings-empty">No users have OTP configured.</div>
<?php } else { ?>
  <ul class="settings-provider-list">
<?php
    foreach ($users as $u) {
	$viewQuery = '?a=v&u=' . urlencode($u);
	$disableQuery = '?a=d&u=' . urlencode($u);
	$showOtp = ($u === $user && $action === 'v');
?>
    <li class="settings-provider-item">
      <div class="settings-provider-info">
        <span class="settings-provider-name"><?php echo htmlspecialchars($u) ?></span>
<?php if ($showOtp) { ?>
        <span class="settings-provider-type">Current OTP: <code class="settings-path"><?php echo htmlspecialchars($otp) ?></code></span>
<?php } ?>
      </div>
      <div class="settings-provider-actions">
        <a href="<?php echo $viewQuery ?>" class="btn btn-sm btn-secondary">View OTP</a>
        <a href="<?php echo $disableQuery ?>" class="btn btn-sm btn-danger">Disable</a>
      </div>
    </li>
<?php } ?>
  </ul>
<?php } ?>
</div>
