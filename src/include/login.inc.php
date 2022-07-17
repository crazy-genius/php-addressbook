<?php

use AddressBook\AuthLogin;

function hasRole(AuthLogin $login, $role) {
	return $login->hasRoles(array($role));
}
