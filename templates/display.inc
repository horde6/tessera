<p><b>CREATE ACCOUNT FOR <?php print htmlspecialchars(strtoupper($sitename)) ?> IN THE AUTHENTICATOR APP</b></p>

<p><u>NOTE</u>: You should have installled the authenticator app at the previous step. If you do not have it, please click the Cancel button below to go back.</p>

<?php
$show = $vars->show == '1';

parse_str($_SERVER['QUERY_STRING'], $query);
$query['show'] = $show ? '0' : '1';
$redir = '?' . http_build_query($query);

if ($show) {
?>
<p><b>Step 1.</b> Open the authenticator app and add a new account by manually entering the information shown below (not all parameters may be needed).</p>
<p><u>IMPORTANT</u>: <i>Do not save the below information, only enter it in the authenticator app!</i></p>
<table class="tessera left">
<thead>
<th>Parameter</th>
<th>Value</th>
</thead>
<tbody>
<tr>
<td>Account name</td>
<td><?php print htmlspecialchars("$sitename: $user") ?></td>
</tr>
<tr>
<td>Secret key or setup key</td>
<td><?php print htmlspecialchars($tempkey) ?></td>
</tr>
<tr>
<td>Type of key</td>
<td>Time based (TOTP)</td>
</tr>
<tr>
<td>Digits</td>
<td>6</td>
</tr>
<tr>
<td>Algorithm</td>
<td>SHA1</td>
</tr>
<tr>
<td>Interval</td>
<td>30</td>
</tr>
</tbody>
</table>
<br>
<p>Click <a href="<?php echo $redir ?>">here</a> if you would like to add a new account by scanning the <a href="<?php echo $redir ?>">QR Code</a>.</p>
<?php } else { ?>
<p><b>Step 1.</b> Open the authenticator app and add a new account by scanning the QR Code below. An <?php print htmlspecialchars($sitename) ?> account will be created automatically.</p>

<p><u>IMPORTANT</u>: <i>Do not save the QR Code photo on your device!</i></p>
<?php print Tessera::QRCodeAuth($user, $tempkey) ?>
<br>
<p>Click <a href="<?php echo $redir ?>">here</a> if you would like to add a new account <a href="<?php echo $redir ?>">manually</a>.</p>
<?php } ?>
<br>
<p><b>Step 2.</b> Make sure the OTP code for the <?php print htmlspecialchars($sitename) ?> account is displayed in the authenticator app (you may need to tap on the <?php print htmlspecialchars($sitename) ?> account in the app).</p>
<p><b>Step 3.</b> Enter the OTP code below and click on the Validate button.</p>

<form method="post">
<div>
 <label for="<?php echo $otpkey ?>">OTP code</label>
 <input type="text" autocomplete="off" autocapitalize="none" autocorrect="off" id="<?php echo $otpkey ?>" name="<?php echo $otpkey ?>" value="" style="direction:ltr">
</div>
<br>
<div style="display: inline-block">
  <input name="submit_button" class="horde-default submit-button" value="Validate" type="submit">
  <input name="submit_button" class="horde-default submit-button" value="Cancel" type="submit">
</div>
</form>
