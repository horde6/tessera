This is just to see the list of outstanding issues (to be replaced with the real README).

ISSUES:

1) Currently the TOTP code expects to be in `vendor/horde/otpauth` folder.
   This might need ot be changed, with the corresponding adjustments in the code.

2) TOTP should be added to Horde's global configuration. At the very lease we need  setting which would specify TOTP state ("disabled", "enabled", "required").
   Horde's login.php/login.inc need to be modified to add an input field for the TOTP if TOTP is not "disabled". Currently it is unconditional - see `_patched` folder.
3) Code in `hooks.php` (see `_patched` folder) might need to be moved elsewhere.
   Also, the code calls `$this->authusername($userId, TRUE)` directly. I should probably use `convertUsername()` instead.
4) The current code relies on SQL table `nch_auth`. This probably sohuld be renamed to `horde_totp` (see issue #5).
5) Currently only SQL driver is supported.
6) Translations?
