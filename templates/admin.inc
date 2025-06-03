<table class="tessera">
<thead>
<tr>
<?php
    $cols = [
	'user'	=> 'User',
	'v'	=> 'View',
	'd'	=> 'Disable OTP'
    ];

    foreach ($cols as $key => $col) {
	print "<th>" . htmlspecialchars($col) . "</th>\n";
    }
?>
</tr>
</thead>
<tbody>
<?php
    $cols = [
	'user'	=> 'User',
	'v'	=> 'OTP',
	'd'	=> 'Disable'
    ];

    $i = 0;
    foreach ($users as $u) {
	print "<tr>\n";
	foreach ($cols as $key => $col) {
	    if ($key == 'user') {
		$text = htmlspecialchars($u);
	    } else {
		$query = '?a=' . htmlspecialchars($key) . '&u=' . htmlspecialchars($u);
		if ($u == $user && $key == 'v' && $action == 'v')
		    $text = $otp;
		else {
		    $text = $col;
		}
		$text = '<a href="' . $query . '">' . htmlspecialchars($text) . '</a>';
	    }
	    print "<td>$text</td>\n";
	}
	print "</tr>\n";
        ++$i;
    }
?>
</tbody>
</table>
