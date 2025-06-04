This is just to see the list of outstanding issues (to be replaced with the real README).

Please also check https://github.com/horde6/tessera/discussions

ISSUES:
1) Currently the TOTP code expects to be in `vendor/horde/tessera` folder.
   This might need ot be changed, with the corresponding adjustments in the code.

2) TOTP should be added to Horde's global configuration. At the very least we need a setting which would specify TOTP state ("disabled", "enabled", "required").
   Horde's `login.php` and `login.inc` need to be modified to add an input field for the TOTP (unless TOTP is disabled). Currently it is unconditional - see `_patched` folder.
3) Code in `hooks.php` (see `_patched` folder) might need to be moved elsewhere.
   ~Also, the code calls `$this->authusername($userId, TRUE)` directly. I should probably use `convertUsername()` instead.~
4) ~The current code relies on SQL table `nch_auth`. This probably should be renamed to `horde_totp` (see issue #5).~
5) Currently only SQL driver is supported.
6) Translations?
